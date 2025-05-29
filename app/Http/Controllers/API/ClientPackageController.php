<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeStatusRequest;
use App\Services\ClientPackageService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ClientPackageRequest;
use App\Http\Requests\LogUsageRequest;
use Illuminate\Support\Facades\Response;

class ClientPackageController extends Controller
{
    protected $clientPackageService;

    public function __construct(ClientPackageService $clientPackageService)
    {
        $this->clientPackageService = $clientPackageService;
    }

    public function index()
    {
        return Response::api('Client packages retrieved successfully', 200, true, 200, $this->clientPackageService->getAll());
    }

    public function showbychat($id)
    {
        return Response::api('Client packages retrieved successfully', 200, true, 200, $this->clientPackageService->getByChat($id));
    }


    public function show($id)
    {
        return Response::api('Client package retrieved successfully', 200, true, 200, $this->clientPackageService->getById($id));
    }

    public function store(ClientPackageRequest $request)
    {
        $data = $request->validated();
        return Response::api('Client package created successfully', 200, true, 200, $this->clientPackageService->create($data));
    }

    public function update(ClientPackageRequest $request, $id)
    {
        $data = $request->validated();
        return Response::api('Client package updated successfully', 200, true, 200, $this->clientPackageService->update($id, $data));
    }

    public function destroy($id)
    {
        return Response::api('Client package deleted successfully', 200, true, 200, $this->clientPackageService->delete($id));
    }
}
