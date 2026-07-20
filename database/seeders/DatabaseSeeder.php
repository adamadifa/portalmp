<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create basic permission groups
        $groupDashboard = \App\Models\Permission_group::updateOrCreate(['name' => 'Dashboard']);
        $groupRoles = \App\Models\Permission_group::updateOrCreate(['name' => 'Roles']);
        $groupUsers = \App\Models\Permission_group::updateOrCreate(['name' => 'Users']);
        $groupDataMaster = \App\Models\Permission_group::updateOrCreate(['name' => 'Data Master']);
        $groupGudangJadi = \App\Models\Permission_group::updateOrCreate(['name' => 'Gudang Jadi']);
        $groupProduksi = \App\Models\Permission_group::updateOrCreate(['name' => 'Produksi']);

        // Create basic permissions with group associations
        $permissions = [
            // Dashboard group
            ['name' => 'dashboard.view', 'id_permission_group' => $groupDashboard->id],
            
            // Produksi Group
            ['name' => 'samutasiproduksi.view', 'id_permission_group' => $groupProduksi->id],
            ['name' => 'samutasiproduksi.create', 'id_permission_group' => $groupProduksi->id],
            ['name' => 'samutasiproduksi.delete', 'id_permission_group' => $groupProduksi->id],
            
            // Gudang Jadi Group
            ['name' => 'sagudangjadi.view', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'sagudangjadi.create', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'sagudangjadi.delete', 'id_permission_group' => $groupGudangJadi->id],
            
            // Roles group
            ['name' => 'roles.view', 'id_permission_group' => $groupRoles->id],
            ['name' => 'roles.create', 'id_permission_group' => $groupRoles->id],
            ['name' => 'roles.edit', 'id_permission_group' => $groupRoles->id],
            ['name' => 'roles.delete', 'id_permission_group' => $groupRoles->id],
            
            // Users group
            ['name' => 'users.view', 'id_permission_group' => $groupUsers->id],
            ['name' => 'users.create', 'id_permission_group' => $groupUsers->id],
            ['name' => 'users.edit', 'id_permission_group' => $groupUsers->id],
            ['name' => 'users.delete', 'id_permission_group' => $groupUsers->id],

            // Data Master group
            ['name' => 'produk.view', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'produk.create', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'produk.edit', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'produk.delete', 'id_permission_group' => $groupDataMaster->id],

            ['name' => 'pelanggan.view', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'pelanggan.create', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'pelanggan.edit', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'pelanggan.delete', 'id_permission_group' => $groupDataMaster->id],

            ['name' => 'supplier.view', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'supplier.create', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'supplier.edit', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'supplier.delete', 'id_permission_group' => $groupDataMaster->id],

            ['name' => 'angkutan.view', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'angkutan.create', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'angkutan.edit', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'angkutan.delete', 'id_permission_group' => $groupDataMaster->id],

            ['name' => 'barangpembelian.view', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'barangpembelian.create', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'barangpembelian.edit', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'barangpembelian.delete', 'id_permission_group' => $groupDataMaster->id],

            ['name' => 'barangproduksi.view', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'barangproduksi.create', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'barangproduksi.edit', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'barangproduksi.delete', 'id_permission_group' => $groupDataMaster->id],

            ['name' => 'tujuanangkutan.view', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'tujuanangkutan.create', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'tujuanangkutan.edit', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'tujuanangkutan.delete', 'id_permission_group' => $groupDataMaster->id],
        ];

        foreach ($permissions as $p) {
            $perm = Permission::findOrCreate($p['name']);
            $perm->id_permission_group = $p['id_permission_group'];
            $perm->save();
        }

        // Create roles and assign created permissions
        $roleSuperAdmin = Role::findOrCreate('super admin');
        $roleAdmin = Role::findOrCreate('admin');

        // Assign all permissions to super admin
        $roleSuperAdmin->syncPermissions(Permission::all());

        // Assign view permissions to admin
        $roleAdmin->syncPermissions([
            'dashboard.view',
            'roles.view',
            'users.view'
        ]);

        // Create or update super admin user
        $superAdminUser = User::updateOrCreate(
            ['email' => 'admin@makmurpermata.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        );

        // Assign super admin role
        $superAdminUser->assignRole($roleSuperAdmin);
    }
}
