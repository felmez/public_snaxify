<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'lat',
        'lng',
        'delivery_area_id',
        'delivery_price',
        'promo_code',
        'promo_code_id',
        'promo_discount',
        'payment_method',
        'stripe_token',
        'paypal_id',
        'city_id',
        'restaurant_id',
        'delivery_boy_id',
        'is_paid',
        'customer_id',
        // FIXME: store restaurant on order
        'restaurant'
    ];

    protected $appends = ['restaurant_data'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function getTotalTax()
    {
        $result = 0;
        foreach ($this->orderedProducts as $op) {
            if ($op->tax_value > 0) {
                $result = $result + $op->tax_value * $op->product->price * $op->count / 100;
            }
        }

        return $result;
    }

    public function orderedProducts()
    {
        return $this->hasMany('App\OrderedProduct');
    }

    public function deliveryArea()
    {
        return $this->belongsTo('App\DeliveryArea');
    }

    public function getGrandTotal()
    {
        return $this->total_with_tax + $this->delivery_price;
    }

    /**
     * Process one of the payment methods (PayPal or Stripe)
     * @return void
     */
    public function pay()
    {
        $settings = Settings::first();
        if ($this->payment_method == 'stripe') {
            \Stripe\Stripe::setApiKey($settings->stripe_private);
            $charge = \Stripe\Charge::create([
                'amount' => $this->getGrandTotal() * 100,
                'currency' => 'usd',
                'source' => $this->stripe_token
            ]);
            $this->is_paid = true;
            $this->save();
        }
        if ($this->payment_method == 'paypal') {
            // get token
            $ch = curl_init('https://api.sandbox.paypal.com/v1/oauth2/token');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'Accept-Language: en_US'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $settings->paypal_client_id . ':' . $settings->paypal_client_secret);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
            $x = curl_exec($ch);
            curl_close($ch);
            $token = json_decode($x)->access_token;
            // get payment info
            $ch = curl_init('https://api.sandbox.paypal.com/v1/payments/payment/' . $this->paypal_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ]);
            $result = curl_exec($ch);
            $result = json_decode($result);
            curl_close($ch);
            if (isset($result->transactions) && count($result->transactions) > 0) {
                if ($result->state == "approved" && $result->transactions[0]->amount->total == $this->getGrandTotal()) {
                    $this->is_paid = true;
                    $this->save();
                }
            }
        }
    }

    /**
     * Relation of models accessible by current user
     * @return Relation
     */
    public static function policyScope()
    {
        // FIXME: original style
        // $user = Auth::user();
        // if ($user->access_full || ! Settings::getSettings()->multiple_cities) {
        //     return Order::orderBy('created_at', 'DESC');
        // } else {
        //     return Order::whereIn('city_id', $user->cities->pluck('id')->all())->
        //     orderBy('created_at', 'DESC');
        // }
        // TODO: new style

        if (Auth::user()->role_id == 'Admin') {
            //  indexing done when you are admin also
            return Order::orderBy('created_at', 'DESC');
        } else {
            // this condition where user can view his own items e.g. restaurant TODO:
            // TODO: more short without '='
            // wow ohhh yeaaaa finally :)) 
            // FIXME: pleaseeee this preventing restaurants indexing also on restaurant page 
            return Order::where('restaurant_id', Auth::user()->restaurant_id);
        }
        // TODO: categories style
        // if (Auth::user()->role_id == 'Admin') {
        //     //  indexing done when you are admin also
        //     return Order::orderBy('created_at', 'DESC');
        // } else {
        //     // this condition where user can view his own items e.g. restaurant TODO:
        //     // TODO: more short without '='
        //     // wow ohhh yeaaaa finally :)) 
        //     // FIXME: pleaseeee this preventing restaurants indexing also on restaurant page 
        //     return Order::where('restaurant_id', Auth::user()->restaurant_id);
        // }
    }

    public function getRestaurantDataAttribute()
    {
        return $this->restaurant;
    }
}
