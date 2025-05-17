<?php

namespace App\Modules\Base\Databases\Seeders;

use App\Modules\Base\Models\Role;
use App\Modules\Base\Models\User;
use App\Modules\Base\Models\UserRole;
use Illuminate\Database\Seeder;

class InitUserAndRoles extends Seeder
{
    public function run(): void
    {
        //
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $role = Role::create([
            'name' => 'Super Admin',
            'created_by' => $user->id
        ]);

        $role->routes()->create([
            'role_id' => $role->id,
            'route_name' => '*',
            'created_by' => $user->id
        ]);

        UserRole::create([
            'role_id' => $role->id,
            'user_id' => $user->id,
            'created_by' => $user->id
        ]);

    }
}