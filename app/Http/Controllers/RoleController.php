<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('role_name', 'asc')->get();
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name'   => 'required|string|max:255|unique:roles,role_name',
            'description' => 'nullable|string|max:500',
        ]);

        Role::create([
            'role_name'   => $request->role_name,
            'description' => $request->description ?? '',
        ]);

        return redirect()->route('admin.roles')->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'role_name'   => 'required|string|max:255|unique:roles,role_name,' . $id,
            'description' => 'nullable|string|max:500',
        ]);

        $role->update([
            'role_name'   => $request->role_name,
            'description' => $request->description ?? '',
        ]);

        return redirect()->route('admin.roles')->with('success', 'Role berhasil diperbarui.');
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles')->with('error', 'Role tidak bisa dihapus karena masih memiliki karyawan.');
        }

        $role->delete();
        return redirect()->route('admin.roles')->with('success', 'Role berhasil dihapus.');
    }
}

