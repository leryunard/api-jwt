<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoria = request()->query('categoria');
        $usuario = request()->query('usuario');

        $query = Almacen::with('categoria', 'usuario');

        if ($categoria) {
            $query->whereHas('categoria', function ($q) use ($categoria) {
                $q->where('nombre', $categoria);
            });
        }

        if ($usuario) {
            $query->whereHas('usuario', function ($q) use ($usuario) {
                $q->where('name', $usuario);
            });
        }

        $dato = $query->paginate(10);
        return response()->json($dato, 200);
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
        //$codigo = 'P-' . str_pad(Almacen::max('id') + 1, 5, '0', STR_PAD_LEFT);
        $validator = Validator::make($request->all(), Almacen::$rules, Almacen::$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();
        //$validatedData['codigo'] = $codigo;
        $validatedData['fecha_ingreso'] = now();
        $validatedData['id_usuario'] = auth()->user()->id; // Asegurarse de que id_usuario esté en los datos validados

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $path = $imagen->store('public/productos/' . auth()->user()->id . '/imagenes');
            $validatedData['imagen'] = $path;
        }
        DB::beginTransaction();
        try {
            $almacen = new Almacen($validatedData);
            $almacen->save();

            $id_user = auth()->user()->id;
            $auditLogs = $almacen->audits;

            $auditLogs->each(function ($audit) use ($id_user) {
                $audit->user_id = $id_user;
                $audit->save();
            });

            DB::commit();

            return response()->json(['mensaje' => 'Producto Agregado Correctamente'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                [
                    'message' => 'Error al actualizar el perfil',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $almacen = Almacen::with('categoria', 'usuario')->find($id);

        if (!$almacen) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($almacen, 200);
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
        $validator = Validator::make($request->all(), Almacen::$rules, Almacen::$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();
        $validatedData['fecha_actualizacion'] = now();
        $validatedData['id_usuario'] = auth()->user()->id;

        $almacen = Almacen::find($id);

        if (!$almacen) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($almacen->imagen) {
                Storage::delete($almacen->imagen);
            }

            $imagen = $request->file('imagen');
            $path = $imagen->store('public/productos/' . auth()->user()->id . '/imagenes');
            $validatedData['imagen'] = $path;
        }

        DB::beginTransaction();
        try {
            $almacen->update($validatedData);

            $id_user = auth()->user()->id;
            $auditLogs = $almacen->audits;

            $auditLogs->each(function ($audit) use ($id_user) {
                $audit->user_id = $id_user;
                $audit->save();
            });

            DB::commit();

            return response()->json(['mensaje' => 'Producto Actualizado Correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                [
                    'message' => 'Error al actualizar el producto',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $almacen = Almacen::find($id);

        if (!$almacen) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        DB::beginTransaction();
        try {
            if ($almacen->imagen) {
                Storage::delete($almacen->imagen);
            }

            $almacen->delete();

            $id_user = auth()->user()->id;
            $auditLogs = $almacen->audits;

            $auditLogs->each(function ($audit) use ($id_user) {
                $audit->user_id = $id_user;
                $audit->save();
            });

            DB::commit();

            return response()->json(['mensaje' => 'Producto Eliminado Correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                [
                    'message' => 'Error al eliminar el producto',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
