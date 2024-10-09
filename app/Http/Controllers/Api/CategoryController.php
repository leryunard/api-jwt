<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * php artisan make:controller Api/CategoryController --api (create controller with api resource) 
     */ 
    public function index()
    {
        return response()->json(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                Category::$rules,
                Category::$messages,
            );

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $category = new Category($request->only('nombre'));
            $category->created_at = now();
            $category->updated_at = now();
            $category->save();

            $id_user = auth()->user()->id;
            $auditLogs = $category->audits;

            $auditLogs->each(function ($audit) use ($id_user) {
                $audit->user_id = $id_user;
                $audit->save();
            });

            DB::commit();

            return response()->json(['mensaje' => 'Categoría creada correctamente'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al crear la categoría.', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada.'], 404);
        }

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'nombre' => 'required|string|max:255',
                ],
                [
                    'nombre.required' => 'El nombre es obligatorio.',
                    'nombre.string' => 'El nombre debe ser una cadena de texto.',
                    'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',
                ],
            );

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            DB::beginTransaction();

            $category = Category::findOrFail($id);
            $category->nombre = $request->input('nombre');
            $category->updated_at = now();
            $category->save();

            $id_user = auth()->user()->id;
            $auditLogs = $category->audits;

            $auditLogs->each(function ($audit) use ($id_user) {
                $audit->user_id = $id_user;
                $audit->save();
            });

            DB::commit();

            return response()->json(['mensaje' => 'Categoría actualizada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al actualizar la categoría.', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $category = Category::findOrFail($id);
            $category->delete();

            $id_user = auth()->user()->id;
            $auditLogs = $category->audits;

            $auditLogs->each(function ($audit) use ($id_user) {
                $audit->user_id = $id_user;
                $audit->save();
            });

            DB::commit();

            return response()->json(['mensaje' => 'Categoría eliminada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar la categoría.', 'details' => $e->getMessage()], 500);
        }
    }
}
