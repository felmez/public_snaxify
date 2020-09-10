<?php

namespace App\Http\Controllers\Dashboard;

use App\Order;
use App\Product;
use App\Services\OrdersService;
use Illuminate\Http\Request;

class OrderedProductsController extends BaseController
{
    protected $base = 'dashboard.ordered_products';
    protected $cls = 'App\OrderedProduct';

    protected function getIndexItems($data)
    {
        return call_user_func([$this->cls, 'orderBy'], $this->orderBy, $this->orderByDir)->
        where('order_id', $data['order_id'])->
        paginate(20);
    }

    public function index(Request $request)
    {
        $filter = $request->input('filter');
        $items = $this->getIndexItems($filter);
        $order = Order::find($filter['order_id']);

        return view($this->base . '.index', compact('items', 'filter', 'order'));
    }

    protected function getAdditionalData($data = null)
    {
        return [
            'order' => Order::find($data['order_id'])
        ];
    }

    protected function save($item, Request $request)
    {
        $validator = $this->getRules($request);
        if ($validator->passes()) {
            $data = $request->all();
            if ($item->id == null) {
                // if already exists
                $x = Order::find($data['order_id'])->orderedProducts->where('product_id', $data['product_id'])->first();
                if ($x != null) {
                    $data['count'] = $data['count'] + $x->count;
                    $item = $x;
                }
            }
            unset($data['product_name']);
            $product = Product::find($data['product_id']);
            $data['price'] = $product->price;
            $data['product_data'] = json_encode($product->toArray());
            $item->fill($data);
            $item->save();
            $service = new OrdersService();
            $service->setOrderTotals($item->order, $item->order->promo_code);

            return redirect(route($this->base . '.index', ['filter' => ['order_id' => $item->order_id]]));
        } else {
            $item->fill($request->all());
            $errors = $validator->messages();

            return view($this->base . '.form',
                array_merge(compact('item', 'errors'), $this->getAdditionalData($request->all())));
        }
    }

    public function destroy($id)
    {
        $item = call_user_func([$this->cls, 'find'], $id);
        $item->delete();

        return redirect(route($this->base . '.index', ['filter' => ['order_id' => $item->order_id]]));
    }
}
