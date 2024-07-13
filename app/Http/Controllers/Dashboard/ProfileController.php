<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();
        $roles = Role::all();

        return view('dashboard.profile.index', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        
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
}
