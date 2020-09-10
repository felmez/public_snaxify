<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
// use \App\Restaurant;

class Product extends Model implements HasMedia
{
    use HasMediaTrait; // todo: add SoftDeletes

    protected $fillable = ['name', 'category_id', 'description', 'price', 'price_old', 'tax_group_id'];

    protected $appends = ['images', 'formatted_price', 'formatted_old_price', 'tax_value', 'city_id', 'restaurant_id'];

    // pluck owner username to table added
    public static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            // $restaurant->owner_id = auth()->user()->id;
            // $restaurant->owner_name = auth()->user()->name;
            $product->owner_username = auth()->user()->username;
            // $product->restaurants_id = Restaurant::with('id')->get();
        });
    }

    public function taxGroup()
    {
        return $this->belongsTo('App\TaxGroup');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function orderedProducts()
    {
        return $this->hasMany('App\OrderedProducts');
    }

    public function getImagesAttribute()
    {
        return $this->getMedia('thumbnails')->map(function ($thumbnail) {
            return $thumbnail->getUrl();
        });
    }

    public function getFormattedPriceAttribute()
    {
        return Settings::currency($this->price);
    }

    public function getFormattedOldPriceAttribute()
    {
        return Settings::currency($this->price_old);
    }

    public function getTaxValueAttribute()
    {
        $result = $this->taxGroup;
        if ($result == null) {
            $result = TaxGroup::getDefaultTaxObject();
        }

        return $result->value;
    }

    public function getCityIdAttribute()
    {
        $result = null;
        if ($this->category != null) {
            $result = $this->category->city_id;
        }

        return $result;
    }

    public function getRestaurantIdAttribute()
    {
        $result = null;
        if ($this->category != null) {
            $result = $this->category->restaurant_id;
        }

        return $result;
    }

    /**
     * Relation of models accessible by current user
     * @return Relation
     */
    public static function policyScope()
    {
        // TODO: fixed without role and owner_user due category policy as i think FIXME: later
        return Product::whereIn('category_id', Category::policyScope()->pluck('id')->all());
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('thumbnails');
    }

    /**
     * @param Media|null $media
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('full')
//             ->nonQueued()
             ->performOnCollections();

        $this->addMediaConversion('medium')
             ->width(800)
             ->height(450)
//             ->sharpen(10)
//             ->nonQueued()
             ->performOnCollections();

        $this->addMediaConversion('thumbnail')
             ->width(400)
             ->height(225)
//             ->nonQueued()
             ->performOnCollections();
    }
}
