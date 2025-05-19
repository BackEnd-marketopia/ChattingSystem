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

    public function logUsage(LogUsageRequest $request)
    {
        $validated = $request->validated();

        $log = $this->clientPackageService->recordUsage(
            $validated['client_package_id'],
            $validated['item_type'],
            $validated['item_id'],
            $validated['action'],
            Auth::id()
        );

        return Response::api('Usage logged successfully', 200, true, 200, $log);
    }

    public function changeStatus(ChangeStatusRequest $request)
    {
        $validated = $request->validated();

        $history = $this->clientPackageService->updateStatus(
            $validated['client_package_id'],
            $validated['item_type'],
            $validated['item_id'],
            $validated['status'],
            $validated['note'],
            Auth::id()
        );

        return Response::api('Status updated successfully', 200, true, 200, $history);
    }


    public function index()
    {
        return Response::api('Client packages retrieved successfully', 200, true, 200, $this->clientPackageService->getAll());
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
