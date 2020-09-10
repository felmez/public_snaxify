<?php

namespace App;

// namespace Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // FIXME:
        // 'restaurant_name',
        // 'slug',

        'restaurant_id',
        'restaurant',
        'role_id',
        'role',
        'name',
        'username',
        'email',
        'password',
        'access_full',
        'access_news',
        'access_categories',
        'access_products',
        'access_orders',
        'access_customers',
        'access_pushes',
        'access_delivery_areas',
        'access_promo_codes',
        'access_tax_groups',
        'access_cities',
        'access_restaurants',
        'access_settings',
        'access_users',
        'access_delivery_boys',
        'access_order_statuses',
    ];
    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($restaurant) {
    //         $restaurant->username = auth()->user()->username;
    //     });
    // }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function cities()
    {
        return $this->belongsToMany(City::class);
    }
    public function roles()
    {
        return $this->belongsToMany('\App\Role');
    }

    // new added tested if its working ^_^
    public function restaurants()
    {
        // showing just owner restaurant TODO:
        return $this->belongsToMany('\App\Restaurant');
        // FIXME: regitration failed if restaurant_id added due no value sent over view
        // return $this->belongsToMany('\App\Restaurant', 'restaurant_id');
        // return $this->belongsToMany(Restaurant::class);
        // return $this->belongsToMany('App\Restaurant', 'restaurant_users', 'owner_id', 'restaurant_id');
    }
    // public function hasAccess(array $permissions)
    // {
    //         foreach($this->roles as $role){
    //             if($role->hasAccess($permissions)){
    //                 return true;
    //             }
    //         }
    //         return false;
    // }
    // testing ui directive roles also checking if user has any role/s
    // public function hasAnyRoles($roles){
    //     return null !== $this->roles()->whereIn('name', $roles)->first();
    // }
    // public function hasAnyRole($role){
    //     return null !== $this->roles()->whereIn('name', $role)->first();
    // }
    // FIXME: testing restaurant id and name for user table   
    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($user) {
    //         $user->restaurant_id = auth()->user()->id;
    //         $user->restaurant_name = auth()->user()->name;
    //     });
    // }
}
