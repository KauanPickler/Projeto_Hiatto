<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
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
            $validate = $request->validate([
                'name' => 'required|string|unique:roles,name',
            ]);
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'sanctum',
            ]);
            $permission = Permission::whereIn('id',$request->permissions)->get();

            $role->syncPermissions($permission);

            return response()->json([
                'message' => 'Usuario Cadastrado com Sucesso',
                'Permissoes do Usuario' => $role->permissions()->get(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao cadastrar usuario',
                'error' => $e->getMessage(),
            ]);
        }

    }

    

    public function update(Request $request, Role $role)
    {
         

        try {

            $permissions = Permission::whereIn('id', $request->permissions)->get();

            $role->update([

                'name' => $request->name,
                'guard_name' => 'sanctum',
            ]);

            $role->syncPermissions($permissions);
            

            return response()->json([
                'message' => 'Perfil Atualizado com Sucesso',
                'Permissoes do Usuario' => $permissions,
                'Antigo' => $role->name
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

        } 
        catch (\Exception $e) {

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
