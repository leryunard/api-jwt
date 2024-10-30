<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', '');

        $query = Clientes::query();

        if (!empty($search)) {
            $query->where('nombre', 'like', '%' . $search . '%')
                  ->orWhere('nit', 'like', '%' . $search . '%');
        }

        $clientes = $query->paginate($perPage);

        return response()->json($clientes, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), Clientes::$rules, Clientes::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $cliente = new Clientes($request->only('nombre', 'nit', 'celular', 'email'));
            $cliente->created_at = now();
            $cliente->updated_at = now();
            $cliente->save();

            DB::commit();

            return response()->json(['mensaje' => 'Cliente creado exitosamente'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al crear el cliente.', 'detalles' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $cliente = Clientes::find($id);
            if (!$cliente) {
                return response()->json(['error' => 'Cliente no encontrado.'], 404);
            }
            return response()->json($cliente, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Cliente no encontrado.', 'detalles' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), Clientes::$rules, Clientes::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $cliente = Clientes::find($id);
            if (!$cliente) {
                return response()->json(['error' => 'Cliente no encontrado.'], 404);
            }
            $cliente->fill($request->only('nombre', 'nit', 'celular', 'email'));
            $cliente->updated_at = now();
            $cliente->save();

            DB::commit();

            return response()->json(['mensaje' => 'Cliente actualizado exitosamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al actualizar el cliente.', 'detalles' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $cliente = Clientes::find($id);
            if (!$cliente) {
                return response()->json(['error' => 'Cliente no encontrado.'], 404);
            }

            $cliente->delete();
            DB::commit();

            return response()->json(['mensaje' => 'Cliente eliminado exitosamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar el cliente.', 'detalles' => $e->getMessage()], 500);
        }
    }
}
