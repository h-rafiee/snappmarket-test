<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductRepository
 * @package App\Repositories
 */
class ProductRepository implements ProductRepositoryInterface
{

    /**
     * @var Product
     */
    private $model;

    /**
     * ProductRepository constructor.
     * @param  Product  $product
     */
    public function __construct(Product $product)
    {
        $this->model = $product;
    }


    /**
     * @param $data
     * @return mixed
     */
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
