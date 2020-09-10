<?php

namespace App\Http\Controllers\Dashboard;

use App\PromoCode;
use Validator;

class PromoCodesController extends BaseController
{
    protected $base = 'dashboard.promo_codes';
    protected $cls = 'App\PromoCode';
    protected $checkboxes = ['discount_in_percent'];

    protected function getIndexItems($data)
    {
        if ($data != null) {
            $codes = PromoCode::policyScope()->
            orderBy($this->orderBy, $this->orderByDir);
            if (is_array($data) && isset($data['city_id'])) {
                $codes = $codes->where('city_id', $data['city_id']);
            }
            if (is_array($data) && isset($data['restaurant_id'])) {
                $codes = $codes->where('restaurant_id', $restaurant_id);
            }

            return $codes->paginate(20);
        } else {
            return PromoCode::policyScope()->
            orderBy($this->orderBy, $this->orderByDir)->
            paginate(20);
        }
    }

    public function getRules()
    {
        return [
            'name' => 'required',
            'code' => 'required',
            'discount' => 'required',
            'limit_use_count' => 'required',
            'active_from' => 'required',
            'active_to' => 'required',
            'min_price' => 'required'
        ];
    }
}
