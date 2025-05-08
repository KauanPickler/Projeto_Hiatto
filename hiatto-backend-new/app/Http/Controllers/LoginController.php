<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user || Hash::check($user->password, $request->password)) {
            $token = $user->createToken('token-user')->plainTextToken;

            return response()->json([
                'message' => 'Usuario Logado com Sucesso',
                'Dados do Usuario' => $user,
                'token' => $token,
            ]);
        }
    }
}
