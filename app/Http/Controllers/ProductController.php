<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    protected $service;
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('products.index');
    }

    public function data(Request $request)
    {
        // Cache::put('test-cache', 'Hello Redis!', 60);
        // dd(Cache::get('test-cache'));
        $products = $this->service->getAll();

        if ($search = $request->input('search.value')) {
            $products = $products->filter(function ($item) use ($search) {
                return stripos($item->nama, $search) !== false ||
                    stripos($item->category->nama ?? '', $search) !== false;
            });
        }

        return datatables()->of($products)
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-primary edit-btn" data-id="' . $row->id . '">Edit</button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Delete</button>';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $product = $this->service->create($request->all());
        return response()->json($product);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $product = $this->service->update($product, $request->all());
        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $this->service->delete($product);
        return response()->json(['success' => true]);
    }
}
