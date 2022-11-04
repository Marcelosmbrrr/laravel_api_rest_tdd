<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Api\CategoryController\{
    StoreCategoryRequest,
    UpdateCategoryRequest
};
use App\Http\Resources\Api\CategoryResource;

class CategoryController extends Controller
{
    function __construct(Category $categoryModel){
        $this->categoryModel = $categoryModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CategoryResource($this->categoryModel->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryModel->create($request->validated());

        return response()->json([
            "message" => "Category successful created.",
            "category" => $category
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
        return new CategoryResource($this->categoryModel->findOrFail($identifier));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $identifier)
    {
        $category = $this->categoryModel->where("uuid", $identifier)->update($request->validated());

        return response()->json([
            "message" => "Category successful updated.",
            "category" => $category
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
        $category = $this->categoryModel->where("uuid", $identifier)->delete();

        return response()->json([
            "message" => "Category successful deleted.",
            "category" => $category
        ]);
    }
}
