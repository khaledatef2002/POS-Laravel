<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ClientController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:create-client', only: ['create', 'store']),
            new Middleware('permission:read-client', only: ['index']),
            new Middleware('permission:edit-client', only: ['edit', 'update']),
            new Middleware('permission:remove-client', only: ['destroy']),
        ];
    }
    public function index(Request $req)
    {
        $clients = Client::when($req->search, function ($q) use ($req) {
            return $q->where('name', 'LIKE', "%{$req->search}%")
            ->orWhere('phone', 'LIKE', "%{$req->search}%")
            ->orWhere('address', 'LIKE', "%{$req->search}%");
        })->paginate(10);

        return view('dashboard.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|unique:clients',
            'address' => 'required'
        ]);

        Client::create($request->all());

        return to_route('dashboard.clients.index')->with('success', __('site.record.added'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|unique:clients,phone,' . $client->id,
            'address' => 'required'
        ]);

        $client->update($request->all());

        return back()->with('success', __('site.record.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
    }
}
