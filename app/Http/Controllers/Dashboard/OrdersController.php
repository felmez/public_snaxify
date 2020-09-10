<?php

namespace App\Http\Controllers\Dashboard;

use App\Order;
use App\Services\OrdersService;
use Gate;
use Illuminate\Http\Request;

class OrdersController extends BaseController
{
    protected $base = 'dashboard.orders';
    protected $cls = 'App\Order';
    protected $checkboxes = ['is_paid'];

    protected function getIndexItems($data)
    {
        if ($data != null) {
            $orders = Order::policyScope();
            if (is_array($data) && isset($data['q'])) {
                $orders = $orders->where(function ($query) use ($data) {
                    $q = '%' . $data['q'] . '%';

                    return $query->where('address', 'LIKE', $q)->
                    orWhere('name', 'LIKE', $q)->
                    orWhere('phone', 'LIKE', $q);
                });
            }
            if (is_array($data) && isset($data['city_id'])) {
                $orders = $orders->where('city_id', $data['city_id']);
            }
            if (is_array($data) && isset($data['restaurant_id'])) {
                $orders = $orders->where('restaurant_id', $data['restaurant_id']);
            }
            // FIXME: TODO:
            // if (is_array($data) && isset($data['restaurant'])) {
            //     $orders = $orders->where('restaurant', $data['restaurant']);
            // }
            if (is_array($data) && isset($data['customer_id'])) {
                $orders = $orders->where('customer_id', $data['customer_id']);
            }
            if (is_array($data) && isset($data['order_status_id'])) {
                $orders = $orders->where('order_status_id', $data['order_status_id']);
            }
            if (is_array($data) && isset($data['dt'])) {
                $orders = $orders->whereDate('created_at', '=', $data['dt']);
            }

            return $orders->paginate(20);
        } else {
            return Order::policyScope()->paginate(20);
        }
    }

    public function save($item, Request $request)
    {
        $request->validate($this->getRules());

        $service = new OrdersService();
        $data = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'lat' => 0,
            'lng' => 0,
            'payment_method' => $request->input('payment_method'),
            'stripe_token' => '',
            'paypal_id' => '',
            'delivery_area_id' => $request->input('delivery_area_id'),
            'city_id' => $request->input('city_id'),
            'order_status_id' => $request->input('order_status_id'),
            'restaurant_id' => $request->input('restaurant_id'),
            // FIXME: store selected restaurant on order
            // 'restaurant' => $request->input('restaurant')
        ];
        if ($item->id == null) {
            $service->createOrder($data, [], $request->input('promo_code'));
        } else {
            $service->updateOrder($item, $data, [], $request->input('promo_code'));
        }

        return redirect(route($this->base . '.index'));
    }

    public function setDeliveryBoy($id, Request $request)
    {
        $item = Order::find($id);
        if ( ! Gate::allows('create', $item)) {
            return redirect('/');
        }
        $boy_id = $request->input('delivery_boy_id');
        $item->delivery_boy_id = $boy_id;
        $item->save();

        return redirect(route('orders.show', ['id' => $id]));
    }
}
