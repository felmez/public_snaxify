<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = ['name', 'sort', 'is_default'];
    // pluck owner username to table added
    public static function boot()
    {
        parent::boot();
        static::creating(function ($order_status) {
            // $restaurant->owner_id = auth()->user()->id;
            // $restaurant->owner_name = auth()->user()->name;
            $order_status->owner_username = auth()->user()->username;
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function getDefault()
    {
        $res = OrderStatus::where('is_default', true)->first();
        if ($res == null) {
            $res = OrderStatus::orderBy('sort', 'ASC')->first();
        }

        return $res;
    }
}
