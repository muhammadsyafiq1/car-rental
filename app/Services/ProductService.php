<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    public function getAll()
    {
        return Cache::remember('products:all', 300, function () {
            return Product::with('category')->get();
        });
    }

    public function getOne($id)
    {
        return Cache::remember("product:$id", 300, function () use ($id) {
            return Product::with('category')->findOrFail($id);
        });
    }

    public function create($data)
    {
        $product = Product::create($data);
        $this->invalidate($product);
        return $product;
    }

    public function update(Product $product, $data)
    {
        $product->update($data);
        $this->invalidate($product);
        return $product;
    }

    public function delete(Product $product)
    {
        $id = $product->id;
        $categoryId = $product->category_id;

        $product->delete();
        Cache::forget("product:$id");
        Cache::forget("products:all");
        Cache::forget("category:$categoryId:products");

        return true;
    }

    private function invalidate(Product $product)
    {
        Cache::forget('products:all');
        Cache::forget("product:{$product->id}");
        Cache::forget("category:{$product->category_id}:products");
    }
}
