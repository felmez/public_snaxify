<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'sort'];

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function deliveryAreas()
    {
        return $this->hasMany(DeliveryArea::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Relation of models accessible by current user
     * @return Relation
     */
    public static function policyScope()
    {
        $user = Auth::user();
        if ($user->access_full || ! Settings::getSettings()->multiple_cities) {
            return City::orderBy('sort', 'ASC');
        } else {
            return City::orderBy('sort', 'ASC')->whereIn('id', $user->cities->pluck('id')->all());
            // return Restaurant::where('owner_username', Auth::user()->username);

        }
    }
}
