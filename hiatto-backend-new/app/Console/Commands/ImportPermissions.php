<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;

class ImportPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to import permissions';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->addPermission();
    }

    private function permissions(): array
    {
        return [
            [
                'group'       => 'roles',
                'group_label' => 'Perfis',
                'permissions' => [
                    [
                        'name'  => 'create',
                        'label' => 'Criar perfil',
                    ],

                    [
                        'name'  => 'update',
                        'label' => 'Atualizar perfil',
                    ],

                    [
                        'name'  => 'delete',
                        'label' => 'Excluir perfil',
                    ],

                    [
                        'name'  => 'view',
                        'label' => 'Visualizar perfil',
                    ],

                    [
                        'name'  => 'view_any',
                        'label' => 'Visualizar todos os perfis',
                    ],
                ],
            ],

            [
                'group'       => 'users',
                'group_label' => 'Usuários',
                'permissions' => [
                    [
                        'name'  => 'create',
                        'label' => 'Criar Usuário',
                    ],

                    [
                        'name'  => 'update',
                        'label' => 'Atualizar Usuário',
                    ],

                    [
                        'name'  => 'delete',
                        'label' => 'Excluir Usuário',
                    ],

                    [
                        'name'  => 'view',
                        'label' => 'Visualizar Usuário',
                    ],

                    [
                        'name'  => 'view_any',
                        'label' => 'Visualizar todos os Usuários',
                    ],
                ],
            ],

            [
                'group'       => 'products',
                'group_label' => 'Produtos',
                'permissions' => [
                    [
                        'name'  => 'create',
                        'label' => 'Criar Produto',
                    ],

                    [
                        'name'  => 'update',
                        'label' => 'Atualizar Produto',
                    ],

                    [
                        'name'  => 'delete',
                        'label' => 'Excluir Produto',
                    ],

                    [
                        'name'  => 'view',
                        'label' => 'Visualizar Produto',
                    ],

                    [
                        'name'  => 'view_any',
                        'label' => 'Visualizar todos os Produtos',
                    ],
                ],
            ],
        ];
    }

    private function addPermission(): void
    {
        // dd($this->permissions());

        $permissions = $this->prepareData($this->permissions());

        // dd($permissions);

        $permissions = $this->modelDeletePermission($permissions);

        $this->modelHandle($permissions);

        $this->info('Permissões atualizadas com sucesso!');
    }

    private function modelHandle(array $data): void
    {
        Permission::upsert($data, ['name'], ['label', 'group', 'group_label', 'guard_name']);
    }

    private function modelDeletePermission(array $data)
    {
        $permissions         = collect($data)->filter(fn ($item) => true === $item['delete']);
        $permissionsToDelete = Permission::whereIn('name', $permissions->pluck('name'))->get();
        $idsToDelete         = $permissionsToDelete->pluck('id');

        if ( ! $idsToDelete->isEmpty()) {
            Permission::destroy($idsToDelete);

            if ($idsToDelete->count() > 1) {
                $this->info("{$idsToDelete->count()} permissões excluídas com sucesso.");
            } else {
                $this->info("{$idsToDelete->count()} permissão excluída com sucesso.");
            }
        } else {
            $this->info('Nenhuma permissão encontrada para exclusão.');
        }

        $permissions = collect($data)
            ->reject(fn ($item) => true === $item['delete'])
            ->map(function ($item) {
                unset($item['delete']);

                return $item;
            })
            ->toArray();

        return $permissions;
    }

    private function prepareData(array $data): array
    {
        $flattenedData = collect($data)
            ->flatMap(function ($item) {
                $permissions = collect($item['permissions'])->map(function ($permission) use ($item) {
                    $permission['guard_name']  = 'web';
                    $permission['name']        = $item['group'] . '_' . $permission['name'];
                    $permission['group']       = $item['group'];
                    $permission['group_label'] = $item['group_label'];
                    $permission['delete'] ??= false;

                    return $permission;
                });

                return $permissions;
            })
            ->toArray();

        return $flattenedData;
    }
}
