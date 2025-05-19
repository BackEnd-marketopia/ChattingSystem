<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageItemRequest;
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

    public function store(PackageItemRequest $request)
    {
        $validated = $request->validated();
        return Response::api('Package item created successfully', 200, true, 200, $this->service->store($validated));
    }

    public function show($id)
    {
        return Response::api('Package item fetched successfully', 200, true, 200, $this->service->find($id));
    }

    public function update(PackageItemRequest $request, $id)
    {
        $validated = $request->validated();
        return Response::api('Package item updated successfully', 200, true, 200, $this->service->update($id, $validated));
    }

    public function destroy($id)
    {
        return Response::api('Package item deleted successfully', 200, true, 200, ['deleted' => $this->service->delete($id)]);
    }
}
