<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    protected $service;
    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index() {
        return response()->json($this->service->getAll());
    }

    public function store(Request $request) {
        $this->service->create($request->only('nama'));
        return response()->json(['success' => true]);
    }
}
