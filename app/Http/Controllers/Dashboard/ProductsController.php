<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Product;
use App\ProductImage;
use App\Services\ProductsImportService;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class ProductsController extends BaseController
{
    protected $base = 'dashboard.products';
    protected $cls = 'App\Product';

    protected function getIndexItems($data)
    {
        if ($data != null) {
            $products = Product::policyScope()
                               ->orderBy($this->orderBy, $this->orderByDir);

            if (is_array($data) && isset($data['q'])) {
                $products = $products->where(function ($query) use ($data) {
                    $q = '%' . $data['q'] . '%';

                    return $query->where('description', 'LIKE', $q)->
                    orWhere('name', 'LIKE', $q);
                });
            }
            if (is_array($data) && isset($data['category'])) {
                $products = $products->where('category_id', '=', $data['category']);
            }
            if (is_array($data) && isset($data['city'])) {
                $category_ids = Category::where('city_id', $data['city'])->pluck('id');
                $products = $products->whereIn('category_id', $category_ids);
            }
            if (is_array($data) && isset($data['restaurant'])) {
                $category_ids = Category::where('restaurant_id', $data['restaurant'])->pluck('id');
                $products = $products->whereIn('category_id', $category_ids);
            }
            if (is_array($data) && isset($data['tax_group'])) {
                $products = $products->where('tax_group_id', '=', $data['tax_group']);
            }

            return $products->paginate(20);
        } else {
            return Product::policyScope()
                          ->orderBy($this->orderBy, $this->orderByDir)
                          ->paginate(20);
        }
    }

    protected function getAdditionalData($data = null)
    {
        return [
            'categories' => Category::policyScope()->get()
        ];
    }

    public function getRules()
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required'
        ];
    }

    protected function save($item, Request $request)
    {
        $request->validate($this->getRules());

        $item->fill($request->all());
        $item->save();

        foreach ($request->file('image', []) as $index => $file) {
            $fileUploaderListFiles = json_decode($request->get('fileuploader-list-files'));
            $fileAdder = $item->addMedia($file);

            if (isset($fileUploaderListFiles[$index]->editor)) {
                $manipulations = [];
                if (isset($fileUploaderListFiles[$index]->editor->crop)) {
                    $manipulations['*']['manualCrop'] =
                        sprintf("%d,%d,%d,%d",
                            $fileUploaderListFiles[$index]->editor->crop->width,
                            $fileUploaderListFiles[$index]->editor->crop->height,
                            $fileUploaderListFiles[$index]->editor->crop->left,
                            $fileUploaderListFiles[$index]->editor->crop->top
                        );
                }
                if (isset($fileUploaderListFiles[$index]->editor->rotation)) {
                    $manipulations['*']['orientation'] = (string)$fileUploaderListFiles[$index]->editor->rotation;
                }
                if (count($manipulations)) {
                    $fileAdder = $fileAdder->withManipulations($manipulations);
                }
            }

            $media = $fileAdder->toMediaCollection('thumbnails');
        }

        return redirect(route($this->base . '.index'));
    }

    public function deleteImage(Request $request, $id)
    {
        $pi = ProductImage::find($id);
        if ($pi) {
            $pi->delete();
        }

        return response()->json([]);
    }

    public function autocomplete(Request $request)
    {
        $q = $request->input('query');
        $products = Product::policyScope();
        $city = $request->input('city_id');
        $restaurant_id = $request->input('restaurant_id');
        if ( ! empty($city)) {
            $category_ids = Category::where('city_id', $city)->pluck('id');
            $products = $products->whereIn('category_id', $category_ids);
        }
        if ( ! empty($restaurant_id)) {
            $category_ids = Category::where('restaurant_id', $restaurant_id)->pluck('id');
            $products = $products->whereIn('category_id', $category_ids);
        }
        $products = $products->where('name', 'like', '%' . $q . '%')->
        limit(20)->get();
        $result = [
            'query' => $q,
            'suggestions' => []
        ];
        foreach ($products as $product) {
            $result['suggestions'][] = [
                'data' => $product->id,
                'value' => $product->name
            ];
        }

        return response()->json($result);
    }

    public function bulk_upload()
    {
        if ( ! Gate::allows('create', $this->cls)) {
            return redirect('/');
        }

        return view('products.bulk_upload');
    }

    public function bulk(Request $request)
    {
        if ( ! Gate::allows('create', $this->cls)) {
            return redirect('/');
        }
        $file_name = Input::file('fl');
        $result = [
            'created' => 0,
            'updated' => 0
        ];
        if ($file_name != null) {
            $service = new ProductsImportService();
            $result = $service->import(
                $file_name->getPathName(),
                $request->input('city_id'),
                $request->input('restaurant_id')
            );
        }

        return redirect(route('products.index'))->with('status', __('messages.products.imported', $result));;
    }
}
