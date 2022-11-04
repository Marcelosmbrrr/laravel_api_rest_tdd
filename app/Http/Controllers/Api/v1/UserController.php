<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Api\UserController\{
    StoreUserRequest,
    UpdateUserRequest
};
use App\Http\Resources\Api\UserResource;

class UserController extends Controller
{
    function __construct(User $userModel){
        $this->userModel = $userModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserResource($this->userModel->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userModel->create($request->validated());

        return response()->json([
            "message" => "User successful created.",
            "user" => $user
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
        return new UserResource($this->userModel->findOrFail($identifier));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $identifier)
    {
        $user = $this->userModel->where("uuid", $identifier)->update($request->validated());

        return response()->json([
            "message" => "User successful updated.",
            "user" => $user
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
        $user = $this->userModel->where("uuid", $identifier)->delete();

        return response()->json([
            "message" => "User successful deleted.",
            "user" => $user
        ]);
    }
}
