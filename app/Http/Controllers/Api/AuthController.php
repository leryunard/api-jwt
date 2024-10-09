<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        // validate the incoming request
        // set every field as required
        // set email field so it only accept the valid email format

        $this->validate($request, [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email',
            'password' => 'required|string|min:6|max:255',
        ]);

        try {
            // start a database transaction
            DB::beginTransaction();
           
            // if the request valid, create user
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
            $userRol = Role::where('name', 'lector')->where('estado',true)->first();
            $userAsignacion = User::where('email', $user->email)->first();
            
            $lectorPermission = Permission::where('name','publish_post')->where('estado',true)->first();
        
            $userRol->permissions()->attach($lectorPermission);
            $userAsignacion->roles()->attach($userRol);

            // commit the transaction if all the operations are successful
            DB::commit();

            // login the user immediately and generate the token
            $token = auth()->login($user);

            // return the response as json 
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
                        'expires_in' => auth()->factory()->getTTL() * 60,    // get token expires in seconds
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            // rollback the transaction if any operation fails
            DB::rollback();

            // return the error response as json
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
        $this->validate($request, [
            'email' => 'required|string|email:rfc,dns|max:255',
            'password' => 'required|string',
        ], [
            'email.required' => 'El campo de correo electrónico es obligatorio.',
            'email.email' => 'El campo de correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'password.required' => 'El campo de contraseña es obligatorio.',
        ]);

        // attempt a login (validate the credentials provided)
        $token = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // if token successfully generated then display success response
        // if attempt failed then "unauthenticated" will be returned automatically
        if ($token)
        {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Quote fetched successfully.',
                ],
                'data' => [
                    'user' => auth()->user(),
                    'access_token' => [
                        'token' => $token,
                        'type' => 'Bearer',
                        'expires_in' => auth()->factory()->getTTL() * 60,
                    ],
                ],
            ]);
        }
    }

    public function logout()
    {
        // get token
        $token = JWTAuth::getToken();

        // invalidate token
        $invalidate = JWTAuth::invalidate($token);

        if($invalidate) {
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

    public function profile()
    {
        return response()->json(auth()->user());
    }

    public function admin()
    {
        return response()->json(['message' => 'Welcome, Admin!']);
    }

    public function editPosts()
    {
        return response()->json(['message' => 'You can edit posts']);
    }

    public function publishPosts()
    {
        return response()->json(['message' => 'You can publish posts']);
    }
}