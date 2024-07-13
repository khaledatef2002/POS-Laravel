<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\user;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware() : array
    {
        return [
            new Middleware('permission:create-user', only: ['create', 'store']),
            new Middleware('permission:read-user', only: ['index']),
            new Middleware('permission:edit-user', only: ['edit', 'update']),
            new Middleware('permission:remove-user', only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $users = User::when($req->search, function($q) use ($req) {
            return $q->where(DB::raw("CONCAT(first_name, ' ' , last_name)") , 'LIKE', "%{$req->search}%")
            ->orWhere('email' , 'LIKE', "%{$req->search}%");
        })->paginate(10);
        return view('dashboard.users.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('dashboard.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required|exists:roles,id',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $data = $request->except(['password_confirmation', 'role']);
        $data['password'] = bcrypt($request['password']);


        $saved_path = 'uploads/user_images/' . $request->image->hashName();
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->image);
        $image->scale(300)
        ->save(public_path($saved_path));

        $data['image'] = $saved_path;

        

        $user = User::create($data);

        $user->syncRoles($request->only('role'));

        return to_route('dashboard.users.index')->with('success', __('site.record.added'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        $roles = Role::all();
        return view('dashboard.users.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,id'
        ]);

        $data = $request->except(['password', 'password_confirmation', 'role']);

        if($request->has('password') && $request->password != null)
        {
            $request->validate([
                'password' => 'required|confirmed',
            ]);
            $data['password'] = $request->only(['password']);
        }
        
        if($request->image)
        {
            $request->validate([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg'
            ]);

            $saved_path = 'uploads/user_images/' . $request->image->hashName();

            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->image);
            $image->scale(300)
            ->save(public_path($saved_path));

            $data['image'] = $saved_path;

            $old_image = substr($user->image, 7);
            Storage::disk('public_uploads')->delete($old_image);
        }

        $user->update($data);
        $user->syncRoles($request->only('role'));

        return back()->with('success', __('site.record.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        if($user->image != 'assets/dashboard/images/users/user-dummy-img.jpg')
        {
            $image = substr($user->image, 7);
            Storage::disk('public_uploads')->delete($image);
        }

        $user->delete();
 
        return back()->with('success', __('site.record.deleted'));
    }
}
