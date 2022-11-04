<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Resources\Api\RoleResource;

class RoleController extends Controller
{
    function __construct(Role $roleModel)
    {
        return $this->roleModel = $roleModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RoleResource($this->roleModel->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = $this->roleModel->create($request->validated());

        return response()->json([
            "message" => "Role successful created.",
            "role" => $role
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
        return new RoleResource($this->roleModel->where("uuid", $identifier)->firstOrFail());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $identifier)
    {
        $role = $this->roleModel->where("uuid", $identifier)->update($request->validated());

        return response()->json([
            "message" => "Role successful updated.",
            "role" => $role
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
        $role = $this->roleModel->where("uuid", $identifier)->delete();

        return response()->json([
            "message" => "Role successful deleted.",
            "role" => $role
        ]);
    }
}
