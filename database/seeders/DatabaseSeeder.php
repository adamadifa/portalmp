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
        $groupGudangBahan = \App\Models\Permission_group::updateOrCreate(['name' => 'Gudang Bahan']);
        $groupGudangLogistik = \App\Models\Permission_group::updateOrCreate(['name' => 'Gudang Logistik']);
        $groupPembelian = \App\Models\Permission_group::updateOrCreate(['name' => 'Pembelian']);
        $groupMarketing = \App\Models\Permission_group::updateOrCreate(['name' => 'Marketing']);

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
            ['name' => 'repackgudangjadi.index', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'repackgudangjadi.create', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'repackgudangjadi.edit', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'repackgudangjadi.show', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'repackgudangjadi.delete', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'rejectgudangjadi.index', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'rejectgudangjadi.create', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'rejectgudangjadi.edit', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'rejectgudangjadi.show', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'rejectgudangjadi.delete', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'lainnyagudangjadi.index', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'lainnyagudangjadi.create', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'lainnyagudangjadi.edit', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'lainnyagudangjadi.show', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'lainnyagudangjadi.delete', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'gj.persediaan', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'gj.rekappersediaan', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'gj.rekaphasilproduksi', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'gj.rekappengeluaran', 'id_permission_group' => $groupGudangJadi->id],
            ['name' => 'gj.realisasikiriman', 'id_permission_group' => $groupGudangJadi->id],
            
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

            ['name' => 'produkharga.view', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'produkharga.create', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'produkharga.edit', 'id_permission_group' => $groupDataMaster->id],
            ['name' => 'produkharga.delete', 'id_permission_group' => $groupDataMaster->id],

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

            // Gudang Bahan Group
            ['name' => 'sagudangbahan.index', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'sagudangbahan.create', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'sagudangbahan.delete', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'sagudangbahan.show', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'sahargagb.index', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'sahargagb.create', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'sahargagb.delete', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'sahargagb.show', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'opgudangbahan.index', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'opgudangbahan.create', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'opgudangbahan.delete', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'opgudangbahan.show', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'opgudangbahan.edit', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'barangmasukgb.index', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'barangmasukgb.create', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'barangmasukgb.delete', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'barangmasukgb.show', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'barangmasukgb.edit', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'barangkeluargb.index', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'barangkeluargb.create', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'barangkeluargb.delete', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'barangkeluargb.show', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'barangkeluargb.edit', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'gb.barangmasuk', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'gb.barangkeluar', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'gb.persediaan', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'gb.rekappersediaan', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'gb.kartugudang', 'id_permission_group' => $groupGudangBahan->id],
            ['name' => 'laporangudangbahan.index', 'id_permission_group' => $groupGudangBahan->id],

            // Gudang Logistik Group
            ['name' => 'sagudanglogistik.index', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'sagudanglogistik.create', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'sagudanglogistik.show', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'sagudanglogistik.delete', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'barangmasukgl.index', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'barangmasukgl.create', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'barangmasukgl.edit', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'barangmasukgl.delete', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'barangmasukgl.show', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'barangkeluargl.index', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'barangkeluargl.create', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'barangkeluargl.edit', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'barangkeluargl.show', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'barangkeluargl.delete', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'opgudanglogistik.index', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'opgudanglogistik.create', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'opgudanglogistik.edit', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'opgudanglogistik.show', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'opgudanglogistik.delete', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'gl.barangmasuk', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'gl.barangkeluar', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'gl.persediaan', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'gl.rekappersediaan', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'gl.kartugudang', 'id_permission_group' => $groupGudangLogistik->id],
            ['name' => 'laporangudanglogistik.index', 'id_permission_group' => $groupGudangLogistik->id],

            // Pembelian Group
            ['name' => 'pembelian.index', 'id_permission_group' => $groupPembelian->id],
            ['name' => 'pembelian.create', 'id_permission_group' => $groupPembelian->id],
            ['name' => 'pembelian.edit', 'id_permission_group' => $groupPembelian->id],
            ['name' => 'pembelian.store', 'id_permission_group' => $groupPembelian->id],
            ['name' => 'pembelian.update', 'id_permission_group' => $groupPembelian->id],
            ['name' => 'pembelian.show', 'id_permission_group' => $groupPembelian->id],
            ['name' => 'pembelian.delete', 'id_permission_group' => $groupPembelian->id],
            ['name' => 'pembelian.jatuhtempo', 'id_permission_group' => $groupPembelian->id],

            // Marketing Group
            ['name' => 'penjualanmarketing.view', 'id_permission_group' => $groupMarketing->id],
            ['name' => 'penjualanmarketing.create', 'id_permission_group' => $groupMarketing->id],
            ['name' => 'penjualanmarketing.edit', 'id_permission_group' => $groupMarketing->id],
            ['name' => 'penjualanmarketing.delete', 'id_permission_group' => $groupMarketing->id],
            ['name' => 'laporanmarketing.index', 'id_permission_group' => $groupMarketing->id],
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
