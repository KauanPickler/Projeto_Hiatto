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


    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|unique:roles,name,' . $role->id,
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);
    
            
            
    
            $role->update([
                'name' => $validatedData['name'],
                'guard_name' => 'sanctum',
            ]);
    
            $permissions = Permission::whereIn('id', $validatedData['permissions'])->get();
            $role->syncPermissions($permissions);
    
            return response()->json([
                'message' => 'Perfil Atualizado com Sucesso',
                'Permissoes do Usuario' => $permissions,
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar usuario',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    
    
}
