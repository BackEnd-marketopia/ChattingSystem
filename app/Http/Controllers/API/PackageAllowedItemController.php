<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PackageAllowedItemService;
use App\Http\Requests\PackageAllowedItemRequest;
use Illuminate\Support\Facades\Response;

class PackageAllowedItemController extends Controller
{
    protected $service;

    public function __construct(PackageAllowedItemService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return Response::api("Package allowed items fetched successfully", 200, true, 200, $this->service->all());
    }

    public function show($id)
    {
        return Response::api("Package allowed item fetched successfully", 200, true, 200, $this->service->find($id));
    }

    public function store(PackageAllowedItemRequest $request)
    {
        $data = $request->validated();
        return Response::api("Package allowed item created successfully", 200, true, 200, $this->service->create($data));
    }

    public function update(PackageAllowedItemRequest $request, $id)
    {
        $data = $request->validated();
        return Response::api("Package allowed item updated successfully", 200, true, 200, $this->service->update($id, $data));
    }

    public function destroy($id)
    {
        return Response::api("Package allowed item deleted successfully", 200, true, 200, $this->service->delete($id));
    }
}
