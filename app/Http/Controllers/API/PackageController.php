<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\packageitemRequest;
use App\Http\Requests\packageRequest;
use PackageService;

class PackageController extends Controller
{
    public function __construct(protected PackageService $service) {}

    public function create(packageRequest $request)
    {
        $data = $request->validated();
        return response()->json($this->service->createPackage($data['client_id'], $data['limits']));
    }

    public function addItem(packageitemRequest $request, $packageId)
    {
        $data = $request->validated();
        return response()->json($this->service->addItem($packageId, $data));
    }

    public function updateItemStatus(Request $request, $itemId)
    {
        $status = $request->validate(['status' => 'required|in:accepted,rejected,pending'])['status'];
        return response()->json($this->service->updateItemStatus($itemId, $status));
    }

    public function myItems(Request $request)
    {
        return response()->json($this->service->getClientItems($request->user()->id));
    }
}
