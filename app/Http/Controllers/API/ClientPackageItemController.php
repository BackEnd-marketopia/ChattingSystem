<?php

namespace App\Http\Controllers\Api;

use App\Services\ClientPackageItemService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientPackageItemRequest;
use Illuminate\Support\Facades\Response;

class ClientPackageItemController extends Controller
{
    protected $service;

    public function __construct(ClientPackageItemService $service)
    {
        $this->service = $service;
    }

    // public function index($clientPackageId)
    // {
    //     $items = $this->service->getItemsByClientPackage($clientPackageId);
    //     return Response::api('Client package items retrieved successfully', 200, true, 200, $items);
    // }


    // public function show($clientPackageId, $id)
    // {
    //     $item = $this->service->getItemByClientPackage($clientPackageId, $id);
    //     return Response::api('Client package item retrieved successfully', 200, true, 200, $item);
    // }

    // public function store($clientPackageId, Request $request)
    // {
    //     dd($request);
    //     $data = $request->only(['type_id', 'status', 'notes']);
    //     $item = $this->service->createItem($clientPackageId, $data);
    //     return Response::api('Client package item created successfully', 200, true, 200, $item);
    // }

    // public function update($clientPackageId, $id, Request $request)
    // {
    //     $data = $request->only(['type_id', 'status', 'notes']);
    //     $item = $this->service->updateItem($clientPackageId, $id, $data);
    //     return Response::api('Client package item updated successfully', 200, true, 200, $item);
    // }

    // public function destroy($clientPackageId, $id)
    // {
    //     $this->service->deleteItem($clientPackageId, $id);
    //     return Response::api('Item deleted successfully', 200, true, 200, null);
    // }


    // public function edit(Request $request, $id)
    // {
    //     $data = $request->only(['note']);
    //     $item = $this->service->editItemStatus($id, $data);
    //     return Response::api('Item edited successfully', 200, true, 200, $item);
    // }

    // public function accept($id)
    // {
    //     $item = $this->service->acceptItemStatus($id);
    //     return Response::api('Item accepted successfully', 200, true, 200, $item);
    // }

    // public function decline(Request $request, $id)
    // {
    //     $data = $request->only(['note']);
    //     $item = $this->service->declineItemStatus($id, $data);
    //     return Response::api('Item declined successfully', 200, true, 200, $item);
    // }


    public function index($clientPackageId)
    {
        return $this->service->getAll($clientPackageId);
    }

    public function show($clientPackageId, $id)
    {
        return $this->service->getById($clientPackageId, $id);
    }

    public function store(ClientPackageItemRequest $request, $clientPackageId)
    {
        return $this->service->store($clientPackageId, $request->validated());
    }

    public function update(ClientPackageItemRequest $request, $clientPackageId, $id)
    {
        return $this->service->update($clientPackageId, $id, $request->validated());
    }

    public function destroy($clientPackageId, $id)
    {
        return $this->service->destroy($clientPackageId, $id);
    }

    public function accept(Request $request, $id)
    {
        return $this->service->accept($id, $request->all());
    }

    public function edit(Request $request, $id)
    {
        return $this->service->edit($id, $request->all());
    }

    public function decline(Request $request, $id)
    {
        return $this->service->decline($id, $request->all());
    }
}
