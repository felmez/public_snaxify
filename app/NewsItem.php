<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    protected $fillable = ['title', 'image', 'announce', 'full_text', 'city_id'];

    protected $appends = ['image_url'];
    protected $hidden = ['image'];

    public function getImageUrlAttribute()
    {
        return url($this->image);
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
        if (Settings::getSettings()->multiple_cities && ! Auth::user()->access_full) {
            return NewsItem::whereIn('city_id', City::policyScope()->pluck('id')->all())->
            orderBy('created_at', 'DESC');
        } else {
            return NewsItem::orderBy('created_at', 'DESC');
        }
    }
}
