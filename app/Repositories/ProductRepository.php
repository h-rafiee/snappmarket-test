<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{

    private $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }


    public function store($data)
    {
        $category = Category::firstOrCreate([
            'title' => $data['category']
        ]);
        $product = $category->products()->updateOrCreate([
            'title' => $data['title']
        ],
            $data
        );
        return $product;
    }


}
