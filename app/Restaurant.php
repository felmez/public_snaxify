<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    // TODO: add parameter to fillable when you need to write it manually and store it in DB from input field
    protected $fillable = ['name', 'city_id', 'sort', 'username', 'owner_username'];
    protected $appends = ['image_url'];
    //  FIXME maybe save user_id with restaurant done but i think there is a more efficient way to do this
    public static function boot()
    {
        // TODO: use this when you need to fetch current user info and store it in DB from auth
        parent::boot();
        static::creating(function ($restaurant) {
            $restaurant->owner_id = auth()->user()->id;
            $restaurant->owner_name = auth()->user()->name;
            // $restaurant->owner_username = auth()->user()->username;
        });
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function getImageUrlAttribute()
    {
        return url($this->image);
    }
    // FIXME: testing
    public function users()
    {
        // showing just owner restaurant
        // return $this->belongsToMany('App\User', 'restaurant_users', 'restaurant_username', 'user_username');
        return $this->belongsToMany('App\User');
        // return $this->belongsToMany(User::class);
        // return $this->belongsToMany('App\User', 'post_users', 'post_id', 'user_id');


    }

    /**
     * Relation of models accessible by current user
     * @return Relation
     */
    public static function policyScope()
    {
        // index fixed to show just this user's restaurants on options FIXME:
        // if (Settings::getSettings()->multiple_cities && !Auth::user()->access_full) {
        //     return Restaurant::whereIn('city_id', City::policyScope()->pluck('id')->all())->
        //         orderBy('sort', 'ASC');
        // } else {
        // $restaurant->owner_username = $user->username('Admin');
        // return true;
        // this condition where user can view his own items e.g. restaurant TODO:
        // return Restaurant::where('owner_username', '=', Auth::user()->username);
        // TODO: more short without '='
        // wow ohhh yeaaaa finally :)) 
        // FIXME: please this preventing restaurants indexing also on restaurant page 
        // return Restaurant::where('owner_username', Auth::user()->username || Auth::user()->role, '1');
        // }
        // TODO:
        // index fixed to show just this user's restaurants on options FIXME:
        if (Auth::user()->role_id == 'Admin') {
            //  indexing done when you are admin also
            return Restaurant::orderBy('sort', 'ASC');
        } else {
            // this condition where user can view his own items e.g. restaurant TODO:
            // TODO: more short without '='
            // wow ohhh yeaaaa finally :)) 
            // FIXME: pleaseeee this preventing restaurants indexing also on restaurant page 
            return Restaurant::where('owner_username', Auth::user()->username);
        }
    }

    // just testing 
    // public function store(Request $request)
    // {
    //     $this->validate($request, array(
    //         'title' => 'required|max:255|min:2',
    //         'slug' => 'required|alpha_dash|unique:articles,slug',
    //         'category_id' => 'required|integer',
    //         'content' => 'required|min:2',
    //     ));

    //     $article = new Article;
    //     $article->title = $request->title;
    //     $article->slug = $request->slug;
    //     $article->category_id = $request->category_id;

    //     $article->content = $request->content;
    //     $article->save();

    //     Session::flash('success', 'Your article has been published.');
    //     return redirect()->route('article.show', $article->id);
    // }
}
