<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientLimitRequest;
use App\Http\Requests\UpdateClientLimitRequest;
use App\Services\ClientLimitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ClientLimitController extends Controller
{
    protected $clientLimitService;

    public function __construct(ClientLimitService $clientLimitService)
    {
        $this->clientLimitService = $clientLimitService;
    }

    // public function remainingLimits($clientPackageId)
    // {
    //     $limits = $this->clientLimitService->getRemainingLimits($clientPackageId);
    //     return response()->json(['data' => $limits]);
    // }

    // public function decrementEdit($clientPackageId, $itemType)
    // {
    //     $this->clientLimitService->decrementEdit($clientPackageId, $itemType);
    //     return response()->json(['message' => 'Edit limit decremented successfully']);
    // }

    // public function decrementDecline($clientPackageId, $itemType)
    // {
    //     $this->clientLimitService->decrementDecline($clientPackageId, $itemType);
    //     return response()->json(['message' => 'Decline limit decremented successfully']);
    // }


    public function index(Request $request)
    {
        $limits = $this->clientLimitService->getAll($request->all());
        return response()->json($limits);
    }

    public function store(ClientLimitRequest $request)
    {
        $data = $request->validated();
        return Response::api('Client limit created successfully', 201, true, 201, $this->clientLimitService->create($data));
    }

    public function update(UpdateClientLimitRequest $request, $id)
    {
        $data = $request->validated();
        return Response::api('Client limit updated successfully', 200, true, 200, $this->clientLimitService->update($id, $data));
    }

    public function destroy($id)
    {
        return Response::api('Client limit deleted successfully', 200, true, 200, $this->clientLimitService->delete($id));
    }

    public function remainingLimits($clientPackageId, Request $request)
    {
        $itemType = $request->input('item_type');
        $limits = $this->clientLimitService->getRemainingLimits($clientPackageId, $itemType);

        return response()->json($limits);
    }

    public function decrementEdit($clientPackageId, Request $request)
    {
        $itemType = $request->input('item_type');
        $result = $this->clientLimitService->decrementEdit($clientPackageId, $itemType);

        return response()->json(['success' => (bool) $result]);
    }

    public function decrementDecline($clientPackageId, Request $request)
    {
        $itemType = $request->input('item_type');
        $result = $this->clientLimitService->decrementDecline($clientPackageId, $itemType);

        return response()->json(['success' => (bool) $result]);
    }
}
