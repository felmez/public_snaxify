<?php

namespace App\Http\Controllers\Dashboard;

use App\DeliveryArea;
use Illuminate\Http\Request;
use Validator;

class DeliveryAreasController extends BaseController
{
    protected $base = 'dashboard.delivery_areas';
    protected $cls = 'App\DeliveryArea';

    protected function getIndexItems($data)
    {
        if ($data != null) {
            $areas = DeliveryArea::policyScope()->
            orderBy($this->orderBy, $this->orderByDir);
            if (is_array($data) && isset($data['city_id'])) {
                $areas = $areas->where('city_id', $data['city_id']);
            }

            return $areas->paginate(20);
        } else {
            return DeliveryArea::policyScope()->
            orderBy($this->orderBy, $this->orderByDir)->
            paginate(20);
        }
    }

    public function getRules()
    {
        return [
            'name' => 'required',
            'coords' => 'required',
            'price' => 'required'
        ];
    }
}
