<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class ProductController
 * @package App\Http\Controllers\API
 */
class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * ProductController constructor.
     * @param  ProductRepositoryInterface  $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $products = [];
            foreach($request->all() as $data) {
                if(!$this->isValidPayload($data))
                    continue;
                // available summary fetch by $this->productRepository->store($data)->summary
                $products[] = $this->productRepository->store($data);
            }
            DB::commit();
            return response()->json($products, 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function isValidPayload(array $payload)
    {
        $validator = Validator::make($payload, [
            'category' => 'required|string|max:191',
            'title' => 'required|string|max:191',
            'price' => 'required|numeric|min:0',
            'count' => 'required|numeric|min:0'
        ]);
        return !$validator->fails();
    }
}
