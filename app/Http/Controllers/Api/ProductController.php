<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private ProductService $productService) {}

    public function index()
    {
        try {
            
            $products = $this->productService->getAll();
            $data =  ProductResource::Collection($products)->response()->getData(true);
            return $this->responseSuccess($data, 'Products fetched successfully');

        } catch (\Exception $e) {

            return $this->responseError($e->getMessage(), 'Error fetching products', 500);

        } 
    }

    public function show($id)
    {
        try{
            $product = $this->productService->getById($id);
            if (!$product) {
                return $this->responseError([], 'Product not found', 404);
            }
            $data = new ProductResource($product);
            return $this->responseSuccess($data, 'Product fetched successfully');

        } catch (\Exception $e) {

            return $this->responseError($e->getMessage(), 'Error fetching product', 500);

        }
    }
       
}
