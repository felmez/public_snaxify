<?php

namespace App\Providers;

use App\Category;
use App\City;
use App\Customer;
use App\DeliveryArea;
use App\DeliveryBoy;
use App\NewsItem;
use App\Order;
use App\OrderedProduct;
use App\OrderStatus;
use App\Policies\CategoryPolicy;
use App\Policies\CityPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\DeliveryAreaPolicy;
use App\Policies\DeliveryBoyPolicy;
use App\Policies\NewsItemPolicy;
use App\Policies\OrderedProductPolicy;
use App\Policies\OrderPolicy;
use App\Policies\OrderStatusPolicy;
use App\Policies\ProductPolicy;
use App\Policies\PromoCodePolicy;
use App\Policies\PushMessagePolicy;
use App\Policies\RestaurantPolicy;
use App\Policies\SettingsPolicy;
use App\Policies\TaxGroupPolicy;
use App\Policies\UserPolicy;
use App\Product;
use App\PromoCode;
use App\PushMessage;
use App\Restaurant;
use App\Settings;
use App\TaxGroup;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Category::class => CategoryPolicy::class,
        User::class => UserPolicy::class,
        Product::class => ProductPolicy::class,
        Order::class => OrderPolicy::class,
        Customer::class => CustomerPolicy::class,
        PushMessage::class => PushMessagePolicy::class,
        DeliveryArea::class => DeliveryAreaPolicy::class,
        PromoCode::class => PromoCodePolicy::class,
        TaxGroup::class => TaxGroupPolicy::class,
        City::class => CityPolicy::class,
        Restaurant::class => RestaurantPolicy::class,
        Settings::class => SettingsPolicy::class,
        NewsItem::class => NewsItemPolicy::class,
        OrderedProduct::class => OrderedProductPolicy::class,
        DeliveryBoy::class => DeliveryBoyPolicy::class,
        OrderStatus::class => OrderStatusPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // $this->registerRestaurantPolicies();

        //
    }
    // new permissions test
    // public function registerRestaurantPolicies()
    // {
    //     Gate::define('view-res', function($user, \App\Restaurant $restaurant){
    //         return $user->hasAccess(['view-res']) or $user->id == $restaurant->user_id;
    //     });
    // }
}
