<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class DeliveryArea extends Model
    {
    // adding to fillable giving ability to fetch and attach if selecting from field on Blade view
    protected $fillable = ['name', 'coords', 'price', 'city_id', 'restaurant_id'];
    // pluck owner username to table added
    public static function boot()
    {
        parent::boot();
        static::creating(function ($delivery_area) {
            // $restaurant->owner_id = auth()->user()->id;
            // $restaurant->owner_name = auth()->user()->name;
            // $delivery_area->restaurant_id = auth()->user()->id;
            $delivery_area->owner_username = auth()->user()->username;
        });
    }

    public function orders()
    {
        return $this->hasMany('App\Orders');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relation of models accessible by current user
     * @return Relation
     */
    public static function policyScope()
    {
        // $user = Auth::user();
        // if ($user->access_full || !Settings::getSettings()->multiple_cities) {
        //     return DeliveryArea::where('id', '>', '0');
        // } else {
        //     return DeliveryArea::whereIn('city_id', $user->cities->pluck('id')->all());
        // }
        //  indexing done when you are admin also or if owner_username equals
        if (Auth::user()->role_id == 'Admin') {
            // FIXME: where without where('id', '>', '0') sorting add this to other objects also like products etc.
            return DeliveryArea::where('id', '>', '0');
        } else {
            return DeliveryArea::where('owner_username', Auth::user()->username);
        }
    }
}
