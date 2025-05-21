<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemStatusHistoryRequest;
use App\Http\Requests\UpdateItemStatusHistoryRequest;
use Illuminate\Http\Request;
use App\Services\ItemStatusHistoryService;
use Illuminate\Support\Facades\Response;

class ItemStatusHistoryController extends Controller
{
    protected $service;

    public function __construct(ItemStatusHistoryService $service)
    {
        $this->service = $service;
    }

    public function store(ItemStatusHistoryRequest $request)
    {
        $data = $request->validated();
        return Response::api('Item Status History Created Successfully', 200, true, 200, $this->service->create($data));
    }

    public function show(int $id)
    {
        return Response::api('Item Status History Fetched Successfully', 200, true, 200, $this->service->find($id));
    }


    public function update(UpdateItemStatusHistoryRequest $request, int $id)
    {
        $data = $request->validated();
        return Response::api('Item Status History Updated Successfully', 200, true, 200, $this->service->update($id, $data));
    }

    public function destroy(int $id)
    {
        return Response::api('Item Status History Deleted Successfully', 200, true, 200, $this->service->delete($id));
    }


    public function indexByItem($itemId)
    {
        return Response::api('Item Status History Fetched Successfully', 200, true, 200, $this->service->getByItem($itemId));
    }
}
