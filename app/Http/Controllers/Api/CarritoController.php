<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', '');
        $query = Carrito::with('almacen', 'venta');

        if (!empty($search)) {
            $query->orWhereHas('almacen', function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%');
            });
        }

        $carritos = $query->paginate($perPage);

        return response()->json($carritos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), Carrito::$rules, Carrito::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();
       
            $carrito = new Carrito();
            $carrito->num_venta = $request->input('num_venta');
            $carrito->cantidad = $request->input('cantidad');
            $carrito->id_almacen = $request->input('id_almacen');
            $carrito->created_at = now();
            $carrito->updated_at = now();
            $carrito->save();

            DB::commit();

            return response()->json(['message' => 'Carrito creado correctamente'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al crear el carrito', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $carrito = Carrito::with('almacen', 'venta')->find($id);
            if (!$carrito) {
                return response()->json(['error' => 'Carrito no encontrado.'], 404);
            }

            return response()->json($carrito, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al encontrar el carrito', 'details' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), Carrito::rules($id), Carrito::$messages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $carrito = Carrito::find($id);
            if (!$carrito) {
                return response()->json(['error' => 'Carrito no encontrado.'], 404);
            }

            $carrito->num_venta = $request->input('num_venta');
            $carrito->cantidad = $request->input('cantidad');
            $carrito->id_almacen = $request->input('id_almacen');
            $carrito->updated_at = now();
            $carrito->save();

            DB::commit();

            return response()->json(['message' => 'Carrito actualizado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al actualizar el carrito', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $carrito = Carrito::find($id);
            if (!$carrito) {
                return response()->json(['error' => 'Carrito no encontrado.'], 404);
            }

            $carrito->delete();

            DB::commit();

            return response()->json(['message' => 'Carrito eliminado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar el carrito', 'details' => $e->getMessage()], 500);
        }
    }
}
