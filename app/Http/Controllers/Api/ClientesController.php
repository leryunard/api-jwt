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
            $validator = Validator::make($request->all(), Clientes::$rules, Clientes::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $cliente = new Clientes($request->only('nombre', 'nit', 'celular', 'email'));
            $cliente->created_at = now();
            $cliente->updated_at = now();
            $cliente->save();

            $id_user = auth()->user()->id;
            $auditLogs = $cliente->audits;

            $auditLogs->each(function ($audit) use ($id_user) {
                $audit->user_id = $id_user;
                $audit->save();
            });

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
        //
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
            $validator = Validator::make($request->all(), Clientes::$rules, Clientes::$messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $cliente = Clientes::findOrFail($id);
            $cliente->fill($request->only('nombre', 'nit', 'celular', 'email'));
            $cliente->updated_at = now();
            $cliente->save();

            $id_user = auth()->user()->id;
            $auditLogs = $cliente->audits;

            $auditLogs->each(function ($audit) use ($id_user) {
                $audit->user_id = $id_user;
                $audit->save();
            });

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
        //
    }
}
