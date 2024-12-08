<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;

class ClientController extends Controller
{
    public function index()
    {
        return view('admin.pages.clients.index');
    }

    public function store(ClientStoreRequest $request)
    {
        $data = $request->validated();

        unset($data['image']);

        $client = User::create($data);

        if ($request->hasFile('image')) {
            $path = Storage::put('/public/clients', $request->image);
            $client->update(["image" => $path]);
        }

        return http_response_code(200);
    }


    public function update(ClientUpdateRequest $request) {}

    public function destroy(Request $request) {}

    public function getClientsList() {}
}
