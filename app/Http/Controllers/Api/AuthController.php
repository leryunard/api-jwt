<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(User $user)
    {
        // model as dependency injection
        $this->user = $user;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email',
            'password' => 'required|string|min:6|max:255',
        ], [
            'name.required' => 'El campo de nombre es obligatorio.',
            'name.string' => 'El campo de nombre debe ser una cadena de texto.',
            'name.min' => 'El campo de nombre debe tener al menos 2 caracteres.',
            'name.max' => 'El campo de nombre no debe exceder los 255 caracteres.',
            'email.required' => 'El campo de correo electrónico es obligatorio.',
            'email.string' => 'El campo de correo electrónico debe ser una cadena de texto.',
            'email.email' => 'El campo de correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El campo de correo electrónico no debe exceder los 255 caracteres.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'password.required' => 'El campo de contraseña es obligatorio.',
            'password.string' => 'El campo de contraseña debe ser una cadena de texto.',
            'password.min' => 'El campo de contraseña debe tener al menos 6 caracteres.',
            'password.max' => 'El campo de contraseña no debe exceder los 255 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);

            $user->save();
            $id_user = $user->id;
            $auditLogs = $user->audits;
            $auditLogs->each(function ($audit) use ($id_user) {
                $audit->user_id = $id_user;
                $audit->save();
            });

            // logica de asignacion de roles y permisos
            $userRol = Role::where('name', 'lector')->where('estado', true)->first();
            $userAsignacion = User::where('email', $user->email)->first();

            $lectorPermission = Permission::where('name', 'publish_post')->where('estado', true)->first();

            $userRol->permissions()->attach($lectorPermission);
            $userAsignacion->roles()->attach($userRol);
            DB::commit();

            // iniciar sesión del usuario inmediatamente y generar el token
            $token = auth()->login($user);

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'User created successfully!',
                ],
                'data' => [
                    'user' => $user,
                    'access_token' => [
                        'token' => $token,
                        'type' => 'Bearer',
                        'expires_in' => auth()->factory()->getTTL() * 60, // obtener el tiempo de expiración del token en segundos
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'meta' => [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Failed to create user. ' . $e->getMessage(),
                ],
                'data' => [],
            ]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|string|email:rfc,dns|max:255',
                'password' => 'required|string',
            ],
            [
                'email.required' => 'El campo de correo electrónico es obligatorio.',
                'email.email' => 'El campo de correo electrónico debe ser una dirección de correo válida.',
                'password.required' => 'El campo de contraseña es obligatorio.',
            ],
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $token = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!$token) {
            return response()->json(
                [
                    'meta' => [
                        'code' => 401,
                        'status' => 'error',
                        'message' => 'Credenciales inválidas.',
                    ],
                ],
                401,
            );
        }

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Autenticación exitosa.',
            ],
            'data' => [
                'access_token' => [
                    'token' => $token,
                    'type' => 'Bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ],
            ],
        ]);
    }

    public function logout()
    {
        $token = JWTAuth::getToken();
        $invalidate = JWTAuth::invalidate($token);

        if ($invalidate) {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Successfully logged out',
                ],
                'data' => [],
            ]);
        }
    }
}
