<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', '');

        $query = Proveedor::query();

        if (!empty($search)) {
            $query->where('nombre', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
        }

        $proveedores = $query->paginate($perPage);

        return response()->json($proveedores, 200);
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
        // Validate the request
        try {
            $validator = Validator::make($request->all(), Proveedor::$rules, Proveedor::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $proveedor = new Proveedor($request->only('nombre', 'celular', 'telefono', 'empresa', 'email', 'direccion'));
            $proveedor->created_at = now();
            $proveedor->updated_at = now();
            $proveedor->save();

            DB::commit();

            return response()->json(['mensaje' => 'Proveedor creado exitosamente'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al crear el proveedor.', 'detalles' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $proveedor = Proveedor::find($id);
            if (!$proveedor) {
                return response()->json(['error' => 'Proveedor no encontrado.'], 404);
            }
            return response()->json($proveedor, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Proveedor no encontrado.', 'detalles' => $e->getMessage()], 404);
        }
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
        // Validate the request
        try {

            // Validar los datos
            $validator = Validator::make($request->all(), Proveedor::rules($id), Proveedor::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $proveedor = Proveedor::find($id);
            if (!$proveedor) {
                return response()->json(['error' => 'Proveedor no encontrado.'], 404);
            }

            $proveedor->fill($request->only('nombre', 'celular', 'telefono', 'empresa', 'email', 'direccion'));
            $proveedor->updated_at = now();
            $proveedor->save();

            DB::commit();

            return response()->json(['mensaje' => 'Proveedor actualizado exitosamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al actualizar el proveedor.', 'detalles' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $proveedor = Proveedor::find($id);
            if (!$proveedor) {
                return response()->json(['error' => 'Proveedor no encontrado.'], 404);
            }
            $proveedor->delete();

            $id_user = auth()->user()->id;
            $auditLogs = $proveedor->audits;

            $auditLogs->each(function ($audit) use ($id_user) {
                $audit->user_id = $id_user;
                $audit->save();
            });

            DB::commit();

            return response()->json(['mensaje' => 'Proveedor eliminado exitosamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar el proveedor.', 'detalles' => $e->getMessage()], 500);
        }
    }
}
