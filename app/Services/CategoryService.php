<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    public function getAll()
    {
        return Cache::remember('categories:all', 300, function () {
            return Category::get();
        });
    }

    public function create($data) {
        $category = Category::create($data);
        Cache::forget('categories:all');
        return $category;
    }
}
