<?php

namespace App\Http\Controllers\Dashboard;

use App\PushMessage;

class PushMessagesController extends BaseController
{
    protected $base = 'dashboard.push_messages';
    protected $cls = 'App\PushMessage';

    protected function getIndexItems($data)
    {
        return PushMessage::policyScope()->
        orderBy($this->orderBy, $this->orderByDir)->paginate(20);
    }
}
