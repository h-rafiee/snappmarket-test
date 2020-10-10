<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $products = [];
            foreach($request->all() as $data) {
                $validator = Validator::make($data, [
                    'category' => 'required',
                    'title' => 'required',
                    'price' => 'required|numeric',
                    'count' => 'required|numeric'
                ]);
                if ( $validator->fails() )
                    continue;
                $products[] = $this->productRepository->store($data);
            }
            DB::commit();
            return response()->json($products, 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
