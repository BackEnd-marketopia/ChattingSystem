<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\packageitemRequest;
use App\Services\PackageItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PackageItemController extends Controller
{
    protected $service;

    public function __construct(PackageItemService $service)
    {
        $this->service = $service;
    }

    public function index($packageId)
    {
        return Response::api('Package items fetched successfully', 200, true, 200, $this->service->getItemsForPackage($packageId));
    }

    public function store(packageitemRequest $request)
    {
        $validated = $request->validated();
        return Response::api('Package item created successfully', 200, true, 200, $this->service->store($validated));
    }

    public function show($id)
    {
        return Response::api('Package item fetched successfully', 200, true, 200, $this->service->find($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'item_type' => 'sometimes|string',
            'max_count' => 'sometimes|integer|min:1',
        ]);

        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        return Response::api('Package item deleted successfully', 200, true, 200, ['deleted' => $this->service->delete($id)]);
    }
}
