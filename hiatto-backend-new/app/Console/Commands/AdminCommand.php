<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class AdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        $allpermission = Permission::pluck('name');
        $admin->syncPermissions($allpermission);

        $user = User::create([
            'name' => 'kauan',
            'email' => 'kauan',
            'password' => bcrypt('kauan')
        ]);

        $token = $user->createToken('token-user')->plainTextToken;
        $this->info($token);
    }
}
