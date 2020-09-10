<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Date;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'name',
        'code',
        'discount',
        'discount_in_percent',
        'limit_use_count',
        'times_used',
        'active_from',
        'active_to',
        'min_price',
        'city_id',
        'restaurant_id'
    ];

    protected $dates = ['active_from', 'active_to'];

    public function setActiveFromAttribute($value)
    {
        $this->attributes['active_from'] = Carbon::parse($value);
    }

    public function setActiveToAttribute($value)
    {
        $this->attributes['active_to'] = Carbon::parse($value);
    }

    public function getActiveFromAttribute($value)
    {
        return Date::parse($value)->format('Y/m/d');
    }

    public function getActiveToAttribute($value)
    {
        return Date::parse($value)->format('Y/m/d');
    }

    public function getPrice($price)
    {
        $result = $price;
        if ($this->discount_in_percent) {
            $result = $result * (1 - $this->discount / 100);
        } else {
            $result = $result - $price;
        }

        return round($result, 2);
    }

    /**
     * Detect if promo code could be used for specified price
     *
     * @param  float $price Price to check
     *
     * @return boolean
     */
    public function isAvailableFor($price)
    {
        return ($this->min_price <= $price) && ($this->times_used < $this->limit_use_count);
    }

    /**
     * Check if promocode could be used for specified product (have the same city and restaurant)
     *
     * @param  Product $product
     *
     * @return boolean
     */
    public function isAvailableForProduct($product)
    {
        $result = true;
        if ($this->city_id != null) {
            $result = $result && ($this->city_id == $product->city_id);
        }
        if ($this->restaurant_id != null) {
            $result = $result && ($this->restaurant_id == $product->restaurant_id);
        }

        return $result;
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Relation of models accessible by current user
     * @return Relation
     */
    public static function policyScope()
    {
        $user = Auth::user();
        if ($user->access_full || ! Settings::getSettings()->multiple_cities) {
            return PromoCode::where('id', '>', '0');
        } else {
            return PromoCode::whereIn('city_id', $user->cities->pluck('id')->all());
        }
    }
}
