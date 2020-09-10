<?php

namespace App\Http\Controllers\Dashboard;

use App\NewsItem;
use Illuminate\Http\Request;
use Validator;

class NewsItemsController extends BaseController
{
    protected $base = 'dashboard.news_items';
    protected $cls = 'App\NewsItem';
    protected $images = ['image'];
    protected $setEmpty = ['announce'];

    public function getRules()
    {
        return [
            'title' => 'required',
            'full_text' => 'required'
        ];
    }

    protected function getIndexItems($data)
    {
        if ($data != null) {
            $news = NewsItem::policyScope();
            if (is_array($data) && isset($data['q'])) {
                $news = $news->where('name', 'LIKE', '%' . $data['q'] . '%');
            }
            if (is_array($data) && isset($data['city_id'])) {
                $news = $news->where('city_id', $data['city_id']);
            }

            return $news->paginate(20);
        } else {
            return NewsItem::policyScope()->paginate(20);
        }
    }
}
