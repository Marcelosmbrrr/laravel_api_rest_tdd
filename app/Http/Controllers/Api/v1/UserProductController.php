<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserProductController\{
    AddProductRequest,
    ConfirmPurchaseRequest,
    RemoveProductRequest
};
use App\Models\{
    User,
    Product
};

class UserProductController extends Controller
{

    function __construct(User $userModel, Product $productModel)
    {
        $this->userModel = $userModel;
        $this->productModel = $productModel;
    }

    function addProduct(AddProductRequest $request)
    {
        $user = $this->userModel->findOrFail($request->user_id);
        $product = $this->productModel->findOrFail($request->product_id);

        $user->products()->attach($product->id, ['amount' => $request->amount]);

        return response()->json([
            "message" => "Product has been added to your chart."
        ], 201);
    }

    function removeProduct(RemoveProductRequest $user_identifier, $product_identifier)
    {
        $user = $this->userModel->where("uuid", $user_identifier)->get();
        $product = $this->productModel->where("uuid", $product_identifier)->get();

        $user->products()->detach($product->id);

        return response()->json([
            "message" => "Product has been removed from your chart."
        ], 204);

    }
}
