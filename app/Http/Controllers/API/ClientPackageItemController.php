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
