<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        
        $user = User::all();

        return response()->json([
            'message' => 'Usuario Listados com Sucesso',
            'Users' => $user,
        ]);
    }

    public function store(Request $request)
    {
        
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'message' => 'Usuario Cadastrado com Sucesso',
                'Dados do Usuario' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao cadastrar usuario',
                'error' => $e->getMessage(),
            ]);
        }

    }

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

    public function update(Request $request, User $user)
    {
        try {

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'message' => 'Usuario Atualizado com Sucesso',
                'Dados do Usuario' => $user,
                'Dados Atualizados' => $request->all(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar usuario',
                'error' => $e->getMessage(),
            ]);

        }

    }

    public function grantPermission(Request $request, User $user)
    {
        try {
            $permissions = [
                1 => 'Usuarios',
                2 => 'Produtos',
                3 => 'Movimentacoes',
                4 => 'Pedidos',
                5 => 'Perfis_de_Usuario',
            ];
            foreach ($request->permission as $permi) {
                $permissionSelection = $permissions[$permi];
                $user->givePermissionTo(Permission::findByName($permissionSelection, 'api'));
            }

            return response()->json([
                'message' => 'Permissão concedida com sucesso',
                'Dados do Usuario' => $user,
                'Permissão' => $user->getAllPermissions(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao conceder permissão',
                'error' => $e->getMessage(),
            ]);
        }

    }

    public function logout(User $user)
    {
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Usuario deslogado com sucesso',
            'Dados do Usuario' => $user,
        ]);
    }
}
