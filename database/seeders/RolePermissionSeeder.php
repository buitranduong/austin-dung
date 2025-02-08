<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     */
    public function run(): void
    {
        Role::query()->truncate();
        User::query()->truncate();
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roleSuperAdmin = Role::create(['name' => 'Super-Admin']);
        $userAdmin = User::factory()->create([
            'name' => 'Admin Sim Thăng Long',
            'slug' => 'admin',
            'email' => 'info@simthanglong.vn',
            'password'=> '123456'
        ]);
        $userAdmin->assignRole($roleSuperAdmin);

        Role::create(['name' => 'Manager']);
        Role::create(['name' => 'Author']);
        Role::create(['name' => 'Editor']);
        Role::create(['name' => 'SEO']);
    }
}
