<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', '');

        $query = Compras::query();

        if (!empty($search)) {
            $query->where('numero', 'like', '%' . $search . '%')
                  ->orWhere('comprobante', 'like', '%' . $search . '%');
        }

        $compras = $query->paginate($perPage);

        return response()->json($compras, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), Compras::$rules, Compras::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $compra = new Compras($request->only('numero','fecha','comprobante','precio','cantidad','id_almacen','id_proveedor'));
            $compra->id_usuario = auth()->user()->id;
            $compra->created_at = now();
            $compra->updated_at = now();
            $compra->save();

            DB::commit();

            return response()->json(['mensaje' => 'Compra creada exitosamente'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al crear la compra.', 'detalles' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $compra = Compras::find($id);
            if (!$compra) {
                return response()->json(['error' => 'Compra no encontrada.'], 404);
            }
            return response()->json($compra, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Compra no encontrada.', 'detalles' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), Compras::$rules, Compras::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $compra = Compras::find($id);
            if (!$compra) {
                return response()->json(['error' => 'Compra no encontrada.'], 404);
            }

            $compra->fill($request->only('numero','fecha','comprobante','precio','cantidad','id_almacen','proveedor_id'));
            $compra->id_usuario = auth()->user()->id;
            $compra->updated_at = now();
            $compra->save();

            DB::commit();

            return response()->json(['mensaje' => 'Compra actualizada exitosamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al actualizar la compra.', 'detalles' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $compra = Compras::find($id);
            if (!$compra) {
                return response()->json(['error' => 'Compra no encontrada.'], 404);
            }

            $compra->delete();
            DB::commit();

            return response()->json(['mensaje' => 'Compra eliminada exitosamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar la compra.', 'detalles' => $e->getMessage()], 500);
        }
    }
}
