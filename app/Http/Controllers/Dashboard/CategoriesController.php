<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Settings;
use Illuminate\Http\Request;
use Validator;

class CategoriesController extends BaseController
{
    protected $base = 'dashboard.categories';
    protected $cls = 'App\Category';
    protected $images = ['image'];

    protected function getAdditionalData($data = null)
    {
        $cats = Category::withDepth()->defaultOrder()->get();
        $array = [
            '' => null,
        ];

        foreach ($cats as $category) {
            $prefix = '';
            for ($i = 0; $i < $category->depth; $i++) {
                $prefix .= '-';
            }

            if ( ! empty($prefix)) {
                $prefix .= ' ';
            }

            $array[$category->id] = $prefix . $category->name;
        }

        return [
            'categories' => $array
        ];
    }

    public function getRules()
    {
        $rules = [
            'name' => 'required'
        ];
        if (Settings::getSettings()->multiple_cities) {
            $rules['city_id'] = 'required';
        }

        return $rules;
    }

    protected function getIndexItems($data)
    {
        if ($data != null) {
            $categories = Category::policyScope();
            if (is_array($data) && isset($data['city_id'])) {
                $categories = $categories->where('city_id', $data['city_id']);
            }
            if (is_array($data) && isset($data['restaurant_id'])) {
                $categories = $categories->where('restaurant_id', $data['restaurant_id']);
            }
            // TODO: add restaurant for category
            // if (is_array($data) && isset($data['restaurant'])) {
            //     $categories = $categories->where('restaurant', $data['restaurant']);
            // }

            return $categories->paginate(50);
        } else {
            return Category::policyScope()->paginate(50);
        }
    }
}
