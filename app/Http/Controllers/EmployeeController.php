<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::with('role')->orderBy('fullname', 'asc')->get();
        return view('admin.employee.index', compact('employees'));
    }

    public function create()
    {
        $roles = Role::whereIn('role_name', ['admin', 'cashier', 'chef'])->orderBy('role_name', 'asc')->get();
        return view('admin.employee.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'phone'    => 'required|string|max:20',
            'role_id'  => 'required|exists:roles,id',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'fullname' => $request->fullname,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role_id'  => $request->role_id,
        ]);

        return redirect()->route('admin.employees')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        $roles = Role::whereIn('role_name', ['admin', 'cashier', 'chef'])->orderBy('role_name', 'asc')->get();
        return view('admin.employee.edit', compact('employee', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $id,
            'phone'    => 'required|string|max:20',
            'role_id'  => 'required|exists:roles,id',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role_id'  => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $employee->update($data);

        return redirect()->route('admin.employees')->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();
        return redirect()->route('admin.employees')->with('success', 'Karyawan berhasil dihapus.');
    }
}

