<?php

namespace App\Http\Controllers\Api\V1;

use App\Customer;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class CustomersController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->all();
        $result = Auth::guard('app_users')->attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ]);
        $response = [
            'success' => $result
        ];
        if ($result) {
            $customer = Auth::guard('app_users')->user();
            $token = $customer->generateToken();
            $response['token'] = $token->token;
            $response['customer'] = $customer;
        }

        return response()->json($response);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $response = [
            'success' => true
        ];
        $validator = $this->getValidator($data);
        if ($validator->passes()) {
            $data['password'] = bcrypt($data['password']);
            $customer = Customer::create($data);
            $response['customer'] = $customer;
            $token = $customer->generateToken();
            $response['token'] = $token->token;
        } else {
            $response['success'] = false;
            $response['errors'] = $validator->errors()->all();
        }

        return response()->json($response);
    }

    public function update(Request $request)
    {
        $user = $request->user;
        $data = $request->all();
        $validator = $this->getValidator($data, $user->id);
        $response = [
            'success' => true
        ];
        if ($validator->passes()) {
            if ( ! empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }
            unset($data['password_confirmation']);
            $user->fill($data);
            $user->save();
            $response['customer'] = $user->fresh();
        } else {
            $response['success'] = false;
            $response['errors'] = $validator->errors()->all();
        }

        return response()->json($response);
    }

    protected function getValidator($data, $id = null)
    {
        $rules = [
            'email' => 'unique:customers',
            'name' => 'required'
        ];
        if ($id != null) {
            $rules['email'] = [
                Rule::unique('users')->ignore($id)
            ];
            $rules['password'] = 'confirmed';
        } else {
            $rules['password'] = 'required';
        }

        return Validator::make($data, $rules);
    }
}
