<?php

namespace App;

use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $fillable = ['name', 'email', 'phone', 'city_id', 'password'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function apiTokens()
    {
        return $this->hasMany(ApiToken::class);
    }

    public function generateToken()
    {
        $token = bin2hex(random_bytes(16));
        while (ApiToken::where('token', $token)->count() > 0) {
            $token = bin2hex(random_bytes(16));
        }

        return ApiToken::create([
            'token' => $token,
            'customer_id' => $this->id
        ]);
    }

    /**
     * Relation of models accessible by current user
     * @return Relation
     */
    public static function policyScope()
    {
        $user = Auth::user();
        if ($user->access_full || ! Settings::getSettings()->multiple_cities) {
            return Customer::orderBy('created_at', 'DESC');
        } else {
            return Customer::whereIn('city_id', $user->cities->pluck('id')->all());
        }
    }
}
