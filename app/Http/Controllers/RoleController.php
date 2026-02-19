<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest()->paginate(10);
        return view('super_admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'label' => 'nullable|string',
        ]);

        Role::create($request->only('name', 'label'));

        return redirect()->route('super_admin.roles.index')->with('success', 'Role Berhasil di Tambahkan.');
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
    public function edit(Role $role)
    {
        return view('super_admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'label' => 'nullable|string'
        ]);

        $role->update($request->only('name', 'label'));

        return redirect()->route('super_admin.roles.index')->with('success', 'Role Berhasil di Edit.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (in_array($role->name, [
            'super_admin',
            'admin',
            'editor',
            'author',
            'user',
        ])) {
            return back()->with('error', 'Role default tidak boleh dihapus.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role masih digunakan oleh user.');
        }

        $role->delete();

        return back()->with('success', 'Role Berhasil di Hapus.');
    }

    public function trash()
    {
        $roles = Role::onlyTrashed()->latest()->paginate(10);
        return view('super_admin.roles.trash', compact('roles'));
    }

    public function restore($id)
    {
        $role = Role::onlyTrashed()->findOrFail($id);

        $role->restore();

        return redirect()->route('super_admin.roles.trash')
            ->with('success', 'Role berhasil direstore.');
    }

    public function forceDelete($id)
    {
        $role = Role::onlyTrashed()->findOrFail($id);

        $role->forceDelete();

        return redirect()->route('super_admin.roles.trash')
            ->with('success', 'Role dihapus permanen.');
    }

}
