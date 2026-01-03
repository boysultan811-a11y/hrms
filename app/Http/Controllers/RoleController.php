<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('dashboard.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('dashboard.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|string',
        ]);

        if ($validated['permissions']) {
            $validated['permissions'] = json_decode($validated['permissions'], true);
        }

        Role::create($validated);

        return redirect()->route('roles.index')->with('success', 'تم إضافة الصلاحية بنجاح!');
    }

    public function edit(Role $role)
    {
        return view('dashboard.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|string',
        ]);

        if ($validated['permissions']) {
            $validated['permissions'] = json_decode($validated['permissions'], true);
        }

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', 'تم تحديث الصلاحية بنجاح!');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'تم حذف الصلاحية بنجاح!');
    }
}
