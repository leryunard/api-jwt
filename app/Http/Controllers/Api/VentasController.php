<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            $validator = Validator::make($request->all(), Ventas::$rules, Ventas::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $venta = new Ventas();
            $venta->id_cliente = $request->input('id_cliente');
            $venta->total_pagado = $request->input('total_pagado');
            $venta->num_venta = $request->input('num_venta');
            $venta->created_at = now();
            $venta->updated_at = now();
            $venta->save();

            DB::commit();

            return response()->json(['message' => 'Venta created successfully', 'venta' => $venta], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error creating the venta.', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $venta = Ventas::find($id);

            if (!$venta) {
                return response()->json(['error' => 'Venta no encontrada.'], 404);
            }

            return response()->json(['mensaje' => $venta], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al buscar la venta.', 'details' => $e->getMessage()], 500);
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
            $validator = Validator::make($request->all(), Ventas::rules($id), Ventas::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $venta = Ventas::find($id);

            if (!$venta) {
                return response()->json(['error' => 'Venta no encontrada.'], 404);
            }

            $venta->id_cliente = $request->input('id_cliente');
            $venta->total_pagado = $request->input('total_pagado');
            $venta->num_venta = $request->input('num_venta');
            $venta->updated_at = now();
            $venta->save();

            DB::commit();

            return response()->json(['message' => 'Venta updated successfully', 'venta' => $venta], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error updating the venta.', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $venta = Ventas::find($id);

            if (!$venta) {
                return response()->json(['error' => 'Venta no encontrada.'], 404);
            }

            $venta->delete();

            DB::commit();

            return response()->json(['message' => 'Venta deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error deleting the venta.', 'details' => $e->getMessage()], 500);
        }
    }
}
