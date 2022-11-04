<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Api\ProductController\{
    StoreProductRequest,
    UpdateProductRequest
};
use App\Http\Resources\Api\ProductResource;

class ProductController extends Controller
{
    function __construct(Product $productModel){
        $this->productModel = $productModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ProductResource($this->productModel->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productModel->create($request->validated());

        return response()->json([
            "message" => "Product successful created.",
            "product" => $product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($identifier)
    {
        return new ProductResource($this->productModel->findOrFail($identifier));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, $identifier)
    {
        $product = $this->productModel->where("uuid", $identifier)->update($request->validated());

        return response()->json([
            "message" => "Product successful updated.",
            "product" => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($identifier)
    {
        $product = $this->productModel->where("uuid", $identifier)->delete();

        return response()->json([
            "message" => "Product successful deleted.",
            "product" => $product
        ]);
    }
}
