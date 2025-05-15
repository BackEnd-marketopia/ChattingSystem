<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PackageAllowedItemService;


class PackageAllowedItemController extends Controller
{
    protected $service;

    public function __construct(PackageAllowedItemService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->all());
    }

    public function show($id)
    {
        return response()->json($this->service->find($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'item_type' => 'required|string',
            'allowed_quantity' => 'required|integer',
        ]);
        return response()->json($this->service->create($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'item_type' => 'sometimes|string',
            'allowed_quantity' => 'sometimes|integer',
        ]);
        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        return response()->json(['deleted' => $this->service->delete($id)]);
    }

    public function byPackage($packageId)
    {
        return response()->json($this->service->getByPackage($packageId));
    }
}
