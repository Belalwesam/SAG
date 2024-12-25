<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ClientProfileUpdateRequest;

class ProfileController extends Controller
{
    public function index()
    {
        return view('client.pages.profile.index');
    }

    public function update(ClientProfileUpdateRequest $request)
    {

        $client = User::findOrFail($request->id);

        $data = [
            "name" => $request->name,
            "username" => $request->username,
            "email" => $request->email,
        ];

        if ($request->has('password') && $request->filled('password')) {
            $data['password'] = $request->password;
        }

        if ($request->hasFile('image')) {
            $data['image'] =   Storage::put('/public/clients', $request->image);
        }
        $client->update($data);

        return back()->with('success', __("general.edit_success"));
    }
}
