<?php

namespace App\Http\Controllers;

use App\Models\Parts;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Services::with('serviceParts.parts')->get();
        return view('service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $partses = Parts::all();
        return view('service.create', compact('partses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'chassis_number' => 'required',
            'km_run' => 'required|numeric',
            'bay_number' => 'required',
            'charge' => 'required|numeric',
            'type' => 'required',
            'start_time' => 'required',
            'parts' => 'nullable|array',
            'phone' => 'required',
            'img' => 'required|file',
        ]);

        $img_url = $request->file('img')->store('services');
        
        $data = $request->except(['parts', 'img']);
        $data['img_url'] = $img_url;
        $data['start_time'] = Carbon::parse($data['start_time'])->format('Y-m-d H:i:s');

        $service = Services::create($data);
        $service->serviceParts()->createMany($request->parts);
        return response()->json(['message' => 'success'], 201);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Services::findOrFail($id);
        $service->update($request->all());
        return true;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
