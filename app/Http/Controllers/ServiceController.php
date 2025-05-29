<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceStoreRequest;
use App\Models\Parts;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Services::with('serviceParts.parts')->orderByDesc('id')->simplePaginate(10);
        $partses = $this->getParts();
        return view('service.index', compact('services', 'partses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $partses = $this->getParts();
        return view('service.create', compact('partses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except(['parts', 'img']);

            if ($request->hasFile('img')) {
                $img_url = $request->file('img')->store('services');
                $data['img_url'] = $img_url;
            }

            $service = Services::create($data);
            $service->serviceParts()->createMany($request->parts);

            DB::commit();
            return response()->json(['message' => 'Service created successfully'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating service', 'error' => $e->getMessage()], 500);
        }
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
        DB::beginTransaction();
        try {
            $service = Services::findOrFail($id);

            foreach ($request->partses as $parts) {
                $service->serviceParts()->updateOrCreate(
                    [
                        'services_id' => $parts['services_id'],
                        'parts_id' => $parts['parts_id'],
                        'quantity' => $parts['quantity'],
                    ],
                    $parts
                );
            }

            $service->update($request->except('partses'));

            DB::commit();
            return response()->json(['message' => 'Service updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating service', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function getParts()
    {
        $parts = Cache::rememberForever('all_parts', function () {
            return Parts::all();
        });

        return $parts;
    }
}
