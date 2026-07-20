<?php

namespace App\Http\Controllers;

use App\Models\Permission_group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('roles.view'), 403);
        
        $query = Role::query();
        if (!empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $roles = $query->paginate(10);
        $roles->appends(request()->all());
        return view('settings.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('roles.create'), 403);
        return view('settings.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('roles.create'), 403);
        
        $name = strtolower($request->name);
        try {
            Role::create(['name' => $name]);
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return Redirect::back()->with(['error' => $message]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('roles.edit'), 403);
        
        $role = Role::findOrFail($id);
        return view('settings.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('roles.edit'), 403);
        
        $id = Crypt::decrypt($id);
        try {
            Role::where('id', $id)->update(['name' => strtolower($request->name)]);

            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('roles.delete'), 403);
        
        $id = Crypt::decrypt($id);
        try {
            Role::where('id', $id)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    public function createrolepermission($id)
    {
        abort_if(!auth()->user()->can('roles.view'), 403);
        
        $id = Crypt::decrypt($id);
        $allPermissions = Permission::select('permissions.*', 'permission_groups.name as group_name')
            ->join('permission_groups', 'permissions.id_permission_group', '=', 'permission_groups.id')
            ->orderBy('permissions.name')
            ->get();

        $permissions = [];
        foreach ($allPermissions as $p) {
            $parts = explode('.', $p->name);
            if (count($parts) > 1) {
                $groupKey = $parts[0];
                if ($groupKey === 'barangpembelian') {
                    $groupName = 'Barang Pembelian';
                } elseif ($groupKey === 'barangproduksi') {
                    $groupName = 'Barang Produksi';
                } elseif ($groupKey === 'tujuanangkutan') {
                    $groupName = 'Tujuan Angkutan';
                } else {
                    $groupName = ucfirst($groupKey);
                }
            } else {
                $groupKey = 'general_' . str_replace(' ', '_', strtolower($p->group_name));
                $groupName = $p->group_name;
            }
            
            $permissions[$groupKey]['group_name'] = $groupName;
            $permissions[$groupKey]['id_permission_group'] = $groupKey;
            $permissions[$groupKey]['permissions'][] = $p;
        }

        $role = Role::findById($id);
        $rolepermissions = $role->permissions->pluck('name')->toArray();
        return view('settings.roles.create_role_permission', compact('permissions', 'role', 'rolepermissions'));
    }

    public function storerolepermission($id, Request $request)
    {
        abort_if(!auth()->user()->can('roles.edit'), 403);
        
        $id = Crypt::decrypt($id);
        $permissions = $request->permission;
        $role = Role::findById($id);
        $old_permissions = $role->permissions->pluck('name')->toArray();

        if (empty($permissions)) {
            return Redirect::back()->with(['warning' => 'Data Permission Harus Di Pilih']);
        }

        try {
            $role->revokePermissionTo($old_permissions);
            $role->givePermissionTo($permissions);
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
