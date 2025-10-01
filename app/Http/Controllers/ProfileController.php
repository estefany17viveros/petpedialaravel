<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Perfil del entrenador (role_id = 2)
     */
    public function trainer(Request $request)
    {
        $user = $request->user()->load('profile', 'role');

        if (!$user->profile || $user->role->id !== 2) {
            return response()->json([
                'message' => 'No tienes un perfil de entrenador o no eres entrenador'
            ], 404);
        }

        return response()->json($user->profile);
    }

    /**
     * Perfil del veterinario (role_id = 1)
     */
    public function veterinary(Request $request)
    {
        $user = $request->user()->load('profile', 'role');

        if (!$user->profile || $user->role->id !== 1) {
            return response()->json([
                'message' => 'No tienes un perfil de veterinario o no eres veterinario'
            ], 404);
        }

        return response()->json($user->profile);
    }

    /**
     * Perfil del refugio (shelter) (role_id = 3)
     */
    public function shelter(Request $request)
    {
        $user = $request->user()->load('profile', 'role');

        if (!$user->profile || $user->role->id !== 4) {
            return response()->json([
                'message' => 'No tienes un perfil de refugio o no eres refugio'
            ], 404);
        }

        return response()->json($user->profile);
    }

    /**
     * Perfil del cliente (role_id = 4)
     */
    public function client(Request $request)
{
    $user = $request->user()->load('profile', 'role');

    if ($user->role->id !== 3) {
        return response()->json([
            'message' => 'No eres cliente'
        ], 403); // mejor un 403 (forbidden)
    }

    return response()->json($user->profile ?? $user);
}

}
