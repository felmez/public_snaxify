<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;
    // TODO: store restaurant field on category
    protected $fillable = ['name', 'parent_id', 'image', 'restaurant_id', 'city_id'];
    // ', 'restaurant'] FIXME:
    protected $appends = ['has_children', 'image_url'];
    protected $hidden = ['image'];
    // pluck owner username to table added
    public static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            // $restaurant->owner_id = auth()->user()->id;
            // $restaurant->owner_name = auth()->user()->name;
            $category->owner_username = auth()->user()->username;
        });
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function getHasChildrenAttribute()
    {
        return $this->children()->count();
    }

    public function getImageUrlAttribute()
    {
        return url($this->image);
    }

    /**
     * Relation of models accessible by current user
     * @return Relation
     */
    public static function policyScope()
    {
        // $user = Auth::user();
        // if ($user->access_full || ! Settings::getSettings()->multiple_cities) {
        //     return Category::withDepth()->defaultOrder();
        // } else {
        //     return Category::withDepth()->defaultOrder()->whereIn('city_id', $user->cities->pluck('id')->all());
        // }
        // wow ohhh yeaaaa finally :))
        // return Category::where('owner_username', Auth::user()->username);
        if (Auth::user()->role_id == 'Admin') {
            //  indexing done when you are admin also
            return Category::withDepth()->defaultOrder();
        } else {
            // this condition where user can view his own items e.g. restaurant TODO:
            // TODO: more short without '='
            // wow ohhh yeaaaa finally :)) 
            // FIXME: pleaseeee this preventing restaurants indexing also on restaurant page 
            return Category::where('owner_username', Auth::user()->username);
        }
    }
}
