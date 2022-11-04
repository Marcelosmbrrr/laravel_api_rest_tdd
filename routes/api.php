<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Version 1.0
use App\Http\Controllers\{
    Auth\v1\LoginController,
    Auth\v1\LogoutController,
    Api\v1\UserController,
    Api\v1\ProductController,
    Api\v1\CategoryController,
    Api\v1\UserProductController
};


Route::post("/login", LoginController::class);
Route::post("/logout", LogoutController::class);

Route::middleware(["auth:sanctum", "ability:admin"])->group(function () {
    Route::group(["prefix" => "v1"], function(){
        Route::apiResource("/users", UserController::class);
        Route::apiResource("/categories", CategoryController::class);
        Route::apiResource("/products", ProductController::class);
        Route::post("/chart/add", [UserProductController::class, "addProduct"]);
        Route::delete("/chart/user/{user_uuid}/product/{product_uuid}", [UserProductController::class, "removeProduct"]);
    });
});

