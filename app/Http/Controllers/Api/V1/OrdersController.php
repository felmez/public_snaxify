<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Order;
use App\Services\OrdersService;
use App\Settings;
use Illuminate\Http\Request;
use Mail;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('customer_id', $request->user->id)->
        orderBy('created_at', 'DESC')->
        limit(50)->get();

        return response()->json($orders);
    }

    public function create(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'lat' => $request->input('lat'),
            'lng' => $request->input('lng'),
            'payment_method' => $request->input('payment_method'),
            'stripe_token' => $request->input('stripe_token'),
            'paypal_id' => $request->input('paypal_id'),
            'delivery_area_id' => $request->input('delivery_area_id'),
            'customer_id' => $request->input('customer_id'),
            'city_id' => $request->input('city_id'),
            'restaurant_id' => $request->input('restaurant_id'),
            // FIXME: store selected restaurant on order
            // 'restaurant' => $request->input('restaurant')
        ];
        $service = new OrdersService();
        $response = $service->createOrder($data, $request->input('products'), $request->input('code'));
        if ($response['success']) {
            $order = $response['order']->fresh();
            /*Mail::send('emails.order_created', ['item' => $order], function ($m) use ($order) {
                $m->from(Settings::getSettings()->mail_from_mail, Settings::getSettings()->mail_from_name);
                $m->to(Settings::getSettings()->notification_email)->subject(Settings::getSettings()->mail_from_new_order_subject);
            });*/
            $response = [
                'success' => true,
                'order' => $order->load('orderedProducts')->toArray()
            ];
        }

        return response()->json($response);
    }

    protected function getValidator($data)
    {
        $service = new OrdersService();

        return $service->getRules();
    }
}
