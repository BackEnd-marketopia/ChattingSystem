<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemUsageLogRequest;
use App\Http\Requests\UpdateItemUsageLogRequest;
use App\Services\ItemUsageLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ItemUsageLogController extends Controller
{
    protected $service;

    public function __construct(ItemUsageLogService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return Response::api('Item usage logs retrieved successfully', 200, true, 200, $this->service->all());
    }

    public function show($id)
    {
        return Response::api('Item usage log retrieved successfully', 200, true, 200, $this->service->find($id));
    }

    public function store(ItemUsageLogRequest $request)
    {
        $data = $request->validated();
        return Response::api('Item usage log created successfully', 201, true, 201, $this->service->create($data));
    }

    public function update(UpdateItemUsageLogRequest $request, $id)
    {
        $data = $request->validated();
        return Response::api('Item usage log updated successfully', 200, true, 200, $this->service->update($id, $data));
    }

    public function destroy($id)
    {
        return Response::api('Item usage log deleted successfully', 200, true, 200, $this->service->delete($id));
    }

    public function byClientPackage($clientPackageId)
    {
        return Response::api('Item usage logs retrieved successfully', 200, true, 200, $this->service->getByClientPackage($clientPackageId));
    }
}
