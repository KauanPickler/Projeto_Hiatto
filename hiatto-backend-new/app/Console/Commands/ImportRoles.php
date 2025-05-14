<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;

class ImportRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $roles = [
            [
                'name'        => 'admin',
                'label'       => 'Administrador',
                'description' => 'Usuário com acesso total ao sistema',
            ],

            [
                'name'        => 'financial',
                'label'       => 'Financeiro',
                'description' => 'Usuário com acesso restrito ao financeiro',
            ],

            [
                'name'        => 'customer',
                'label'       => 'Cliente',
                'description' => 'Usuário com acesso restrito ao sistema',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                [
                    'name' => $role['name'],
                ],
                [
                    'label'       => $role['label'],
                    'description' => $role['description'],
                ]
            );
        }
    }
}
