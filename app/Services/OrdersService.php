<?php

namespace App\Services;

use App\Customer;
use App\DeliveryArea;
use App\Order;
use App\OrderedProduct;
use App\OrderStatus;
use App\Product;
use App\PromoCode;
use App\Settings;
use Carbon\Carbon;
use Validator;

/**
 * Service to create and update orders
 */
class OrdersService
{
    /**
     * Calculate order total price with taxes and promo code applied
     *
     * @param Order  $order order to calc total prices and apply taxes
     * @param string $code  Promo code used
     */
    public function setOrderTotals($order, $code)
    {
        $order = $order->fresh();
        $total = 0;
        $total_tax = 0;
        if ($order->orderedProducts != null) {
            foreach ($order->orderedProducts as $op) {
                $product = $op->product;
                $total = $total + $op->count * $product->price;
                $total_tax = $total_tax + $op->count * $product->price * $product->tax_value / 100;
            }
        }
        $promo_code = PromoCode::where('code', $code)->
        where('active_from', '<=', new Carbon())->
        where('active_to', '>=', new Carbon())->first();
        if ($promo_code != null) {
            if ($promo_code->isAvailableFor($total)) {
                $pre_total = $total;
                $total = $promo_code->getPrice($total);
                $order->promo_code = $promo_code->code;
                $order->promo_discount = $pre_total - $total;
                if ( ! $promo_code->times_used) {
                    $promo_code->times_used = 0;
                }
                $promo_code->times_used = $promo_code->times_used + 1;
                $promo_code->save();
            }
        }
        $order->total = $total;
        $order->tax = $total_tax;
        if (Settings::getSettings()->tax_included) {
            $order->total_with_tax = $total;
        } else {
            $order->total_with_tax = $total + $total_tax;
        }
        $order->save();
    }

    /**
     * Automatically create dummy customer if not set
     *
     * @param Order $order
     * @param int   $customer_id
     */
    public function setCustomer($order, $customer_id)
    {
        if ( ! empty($customer_id)) {
            return;
        }
        $customer = Customer::where('phone', $order->phone)->first();
        if ($customer == null) {
            $customer = Customer::create([
                'phone' => $order->phone,
                'name' => $order->name,
                'city_id' => $order->city_id,
                'email' => '',
                'password' => ''
            ]);
        }
        $order->customer_id = $customer->id;
        $order->save();
    }

    /**
     * Create order from request data (with prior validation)
     *
     * @param  Array  $data     Request data
     * @param  Array  $products Products array from request
     * @param  string $code     Promo code used
     *
     * @return Array
     */
    public function createOrder($data, $products, $code)
    {
        if ($data['paypal_id'] == null) {
            $data['paypal_id'] = '';
        }
        $defaultStatus = OrderStatus::getDefault();
        $delivery_area = DeliveryArea::find($data['delivery_area_id']);
        if ($delivery_area != null) {
            $data['delivery_price'] = $delivery_area->price;
        }
        $validator = $this->getValidator($data);
        $response = [
            'success' => true
        ];
        if ( ! empty($data['city_id'])) {
            // return fail if wrong delivery area is specified
            $area = DeliveryArea::find($data['delivery_area_id']);
            if ($area->city_id != $data['city_id']) {
                $response['success'] = false;

                return $response;
            }
        }
        if ($validator->passes()) {
            $order = new Order($data);
            if ($defaultStatus != null) {
                $order->order_status_id = $defaultStatus->id;
            }
            $order->save();
            foreach ($products as $item) {
                $product = Product::where('id', $item['product']['id'])->first();
                if ($product != null) {
                    $op = new OrderedProduct([
                        'product_id' => $product->id,
                        'order_id' => $order->id,
                        'count' => $item['count'],
                        'price' => $product->price,
                        'product_data' => json_encode($item['product'])
                    ]);
                    $op->save();
                }
            }
            if ( ! isset($data['customer_id'])) {
                $data['customer_id'] = null;
            }
            $this->setCustomer($order, $data['customer_id']);
            $this->setOrderTotals($order, $code);
            $order->pay();
            $response['order'] = $order;
        } else {
            $response['success'] = false;
            $response['errors'] = $validator->errors()->all();
        }

        return $response;
    }

    /**
     * Update existing order
     *
     * @param  Order  $order    Order to update
     * @param  Array  $data     Order data from request
     * @param  Array  $products Products data from request
     * @param  string $code     Promo code used
     *
     * @return Array
     */
    public function updateOrder($order, $data, $products, $code)
    {
        if ($data['paypal_id'] == null) {
            $data['paypal_id'] = '';
        }
        $delivery_area = DeliveryArea::find($data['delivery_area_id']);
        if ($delivery_area != null) {
            $data['delivery_price'] = $delivery_area->price;
        }
        $validator = $this->getValidator($data);
        $response = [
            'success' => true
        ];
        if ($validator->passes()) {
            $order->fill($data);
            if (isset($data['order_status_id'])) {
                $order->order_status_id = $data['order_status_id'];
            }
            $order->save();
            foreach ($order->orderedProducts as $op) {
                $op->delete();
            }
            foreach ($products as $item) {
                $product = Product::where('id', $item['product']['id'])->first();
                if ($product != null) {
                    $op = new OrderedProduct([
                        'product_id' => $product->id,
                        'order_id' => $order->id,
                        'count' => $item['count'],
                        'price' => $product->price,
                        'product_data' => json_encode($item['product'])
                    ]);
                    $op->save();
                }
            }
            $this->setOrderTotals($order, $code);
            $response['order'] = $order;
        } else {
            $response['success'] = false;
            $response['errors'] = $validator->errors()->all();
        }

        return $response;
    }

    /**
     * Make order validator based on system settings
     * city_id is required only in case of multiple cities
     * restaurant_id is required only in case of multiple restaurants
     *
     * @param  Array $data Request data
     *
     * @return Validator
     */
    public function getValidator($data)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            // Disable when text input enabled TODO:
            // 'delivery_area_id' => 'required'
        ];
        if (Settings::getSettings()->multiple_cities) {
            $rules['city_id'] = 'required';
        }
        if (Settings::getSettings()->multiple_restaurants) {
            $rules['restaurant_id'] = 'required';
            // $rules['restaurant'] = 'required';
        }

        return Validator::make($data, $rules);
    }
}