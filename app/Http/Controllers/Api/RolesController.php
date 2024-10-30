<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', '');

        $query = Roles::query();

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $roles = $query->paginate($perPage);

        return response()->json($roles, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), Roles::$rules, Roles::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $role = new Roles($request->only('name'));
            $role->created_at = now();
            $role->updated_at = now();
            $role->save();

            DB::commit();

            return response()->json(['message' => 'Rol creado correctamente'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al crear el rol.', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $role = Roles::find($id);

            if (!$role) {
                return response()->json(['error' => 'Rol no encontrado'], 404);
            }
            return response()->json($role, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al consultar el rol.', 'details' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), Roles::$rules, Roles::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $role = Roles::find($id);

            if (!$role) {
                return response()->json(['error' => 'Rol no encontrado'], 404);
            }

            $role->name = $request->input('name');
            $role->updated_at = now();
            $role->save();

            DB::commit();

            return response()->json(['message' => 'Rol actualizado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al actualizar el rol.', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $role = Roles::find($id);

            if (!$role) {
                return response()->json(['error' => 'Rol no encontrado'], 404);
            }

            $role->delete();

            DB::commit();

            return response()->json(['message' => 'Rol eliminado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar el rol.', 'details' => $e->getMessage()], 500);
        }
    }
}
