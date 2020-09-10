<?php

namespace App;

use App\Observers\PushMessageObserver;
use Illuminate\Database\Eloquent\Model;

class PushMessage extends Model
{
    protected $fillable = ['message'];

    /**
     * Relation of models accessible by current user
     * @return Relation
     */
    public static function policyScope()
    {
        return PushMessage::orderBy('created_at', 'DESC');
    }
}

PushMessage::observe(new PushMessageObserver);
