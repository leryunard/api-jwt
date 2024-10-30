<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissionRoles = PermissionRole::all();
        return response()->json($permissionRoles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permissionRole = new PermissionRole;
        $permissionRole->role_id = $request->role_id;
        $permissionRole->permission_id = $request->permission_id;
        $permissionRole->save();
        return response()->json($permissionRole, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permissionRole = PermissionRole::findOrFail($id);
        return response()->json($permissionRole);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permissionRole = PermissionRole::findOrFail($id);
        $permissionRole->role_id = $request->role_id;
        $permissionRole->permission_id = $request->permission_id;
        $permissionRole->save();
        return response()->json($permissionRole);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permissionRole = PermissionRole::findOrFail($id);
        $permissionRole->delete();
        return response()->json(null, 204);
    }
}
