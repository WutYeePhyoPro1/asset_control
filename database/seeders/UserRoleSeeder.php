<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Copy the legacy users.type value into Spatie's model_has_roles table.
     */
    public function run(): void
    {
        $roleNames = [
            'admin' => 'admin',
            'manager' => 'manager',
            'superadmin' => 'admin',
            'user' => 'user',
        ];

        $users = User::whereNotNull('type')
            ->where('type', '<>', '')
            ->get();

        foreach ($users as $user) {
            $type = strtolower(trim($user->type));
            $roleName = $roleNames[$type] ?? $type;

            if (!$roleName) {
                continue;
            }

            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            $user->syncRoles($role);
        }
    }
}
