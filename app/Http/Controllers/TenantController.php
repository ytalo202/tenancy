<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tenants.index')->with(['tenants' => Tenant::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:tenants'
        ]);


//        return config('app.domain');
        $tenant = Tenant::create($request->all());
        $tenant->domains()->create(['domain' => $request->get('id') . '.' . "tenancy.test"]);

//        return $request->all();
        return redirect()->route('tenants.index')
            ->with('success', 'Tenant created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        return view('tenants.show')->with(['tenant' => $tenant]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        return view('tenants.edit')->with(['tenant' => $tenant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'id' => 'required|unique:tenants,id,' . $tenant->id,
        ]);


        $tenant->update(['id' => $request->get('id')]);
        $tenant->domains()->update(['domain' => $request->get('id') . '.' . "tenancy.test"]);

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant created successfully');
    }
}
