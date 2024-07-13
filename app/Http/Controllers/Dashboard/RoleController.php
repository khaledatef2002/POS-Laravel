<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    public static function middleware()
    {
        return [
            new Middleware('permission:create-role', only: ['create', 'store']),
            new Middleware('permission:read-role', only: ['index']),
            new Middleware('permission:edit-role', only: ['edit', 'update']),
            new Middleware('permission:remove-role', only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $roles = Role::when($req->search, function($q) use ($req) {
            return $q->where('name' , 'LIKE', "%{$req->search}%")
            ->orWhere('display_name', 'LIKE', "%{$req->search}%");
        })->paginate(10);

        return view('dashboard.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|string',
            'display_name' => 'required|string|unique:roles',
            'description' => 'nullable'
        ]);
        $role = Role::create($request->except('permissions'));

        $permissions = Permission::whereIn('name', $request->permissions)->get();

        $role->syncPermissions($permissions);

        return to_route('dashboard.roles.index')->with('success', __('site.record.added'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('dashboard.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . '|string',
            'display_name' => 'required|string|unique:roles,display_name,' . $role->id,
            'description' => 'nullable'
        ]);
        $role->update($request->except('permissions'));

        $permissions = Permission::whereIn('name', $request->permissions)->get();

        $role->syncPermissions($permissions);

        return back()->with('success', __('site.record.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return back()->with('success', __('site.record.deleted'));
    }
}
