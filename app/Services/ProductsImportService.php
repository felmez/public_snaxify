<?php

namespace App\Services;

use App\Category;
use App\Product;
use App\TaxGroup;

/**
 * Service for bulk products import
 */
class ProductsImportService
{
    public function import($file, $city_id = null, $restaurant_id = null)
    {
        $updated = 0;
        $created = 0;
        $row = 1;
        if (($handle = fopen($file, "r")) !== false) {
            while (($data = fgetcsv($handle, 5000, ",")) !== false) {
                if ($row == 1) {
                    $row++;
                    continue;
                }
                $row++;

                $taxGroup = TaxGroup::where('name', $data[2])->first();
                $taxGroupId = null;
                if ($taxGroup != null) {
                    $taxGroupId = $taxGroup->id;
                }
                $category = Category::where('city_id', $city_id)->
                where('city_id', $city_id)->
                where('restaurant_id', $restaurant_id)->
                where('name', $data[1])->
                first();
                $categoryId = null;
                if ($category != null) {
                    $categoryId = $category->id;
                } else {
                    $category = Category::create([
                        'name' => $data[1],
                        'city_id' => $city_id,
                        'restaurant_id' => $restaurant_id
                    ]);
                    $categoryId = $category->id;
                }
                $product = Product::where('name', $data[0])->
                where('category_id', $categoryId)->
                first();
                $productData = [
                    'category_id' => $categoryId,
                    'tax_group_id' => $taxGroupId,
                    'name' => $data[0],
                    'price' => $data[3]
                ];
                if ($product == null) {
                    $product = new Product($productData);
                    $created++;
                } else {
                    $product->fill($productData);
                    $updated++;
                }
                $product->save();
            }
            fclose($handle);
        }

        return [
            'updated' => $updated,
            'created' => $created
        ];
    }
}