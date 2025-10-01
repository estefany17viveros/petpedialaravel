<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|min:3',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id'  => ['required', Rule::in([1,2,3,4])], // roles válidos

            // Veterinario
            'clinic_name' => 'required_if:role_id,1|string',
            'address'     => 'required_if:role_id,1|string',
            'phone'       => 'required_if:role_id,1|string',
            'schedules'   => 'required_if:role_id,1|array',

            // Entrenador
            'specialty'        => 'required_if:role_id,2|string',
            'experience_years' => 'required_if:role_id,2|numeric|min:0',
            'qualifications'   => 'required_if:role_id,2|string',
            'phone'            => 'required_if:role_id,2|string',

            // Refugio
            'address'     => 'required_if:role_id,4|string',
            'responsible' => 'required_if:role_id,4|string',
            'phone'       => 'required_if:role_id,4|string',

            // Imagen opcional
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Crear usuario
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
        ]);

        // Subir foto si existe
        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('profiles', 'public');
        }

        // Perfil base
        $profileData = [
            'user_id' => $user->id,
            'image'   => $imagePath,
        ];

        // Añadir datos según rol
        switch ($request->role_id) {
            case 1: // Veterinario
                $profileData += [
                    'clinic_name' => $request->clinic_name,
                    'address'     => $request->address,
                    'phone'       => $request->phone,
                    'schedules'   => $request->schedules ? json_encode($request->schedules) : null,
                ];
                break;

            case 2: // Entrenador
                $profileData += [
                    'specialty'        => $request->specialty,
                    'experience_years' => $request->experience_years,
                    'qualifications'   => $request->qualifications,
                    'phone'            => $request->phone,
                ];
                break;

            case 4: // Refugio
                $profileData += [
                    'address'     => $request->address,
                    'responsible' => $request->responsible,
                    'phone'       => $request->phone,
                ];
                break;
            // Cliente solo básicos
        }

        Profile::create($profileData);

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user'    => $user->load('profile', 'role'),
        ], 201);
    }

    public function roles()
    {
        return response()->json([
            ['id' => 1, 'name' => 'Veterinario'],
            ['id' => 2, 'name' => 'Entrenador'],
            ['id' => 3, 'name' => 'Cliente'],
            ['id' => 4, 'name' => 'Refugio'],
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])
            ->with('role', 'profile')
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        // Generar token Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login exitoso',
            'token'   => $token,
            'user'    => [
                'id'     => $user->id,
                'name'   => $user->name,
                'email'  => $user->email,
                'role'   => [
                    'id'   => $user->role->id,
                    'name' => $user->role->name,
                ],
                'profile' => $user->profile ?? null, // Asegura que no falle si no hay perfil
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada']);
    }
}
