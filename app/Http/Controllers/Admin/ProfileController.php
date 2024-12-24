<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.pages.profile.index');
    }

    public function update(/* ProfileUpdate */Request $request)
    {

        $admin = Admin::findOrFail($request->id);

        $data = [
            "name" => $request->name,
            "username" => $request->username,
            "email" => $request->email,
        ];

        if ($request->has('password') && $request->filled('password')) {
            $data['password'] = $request->password;
        }

        if ($request->hasFile('image')) {
            $data['image'] =   Storage::put('/public/admins', $request->image);
        }
        $admin->update($data);

        return back()->with('success', __("general.edit_success"));
    }
}
