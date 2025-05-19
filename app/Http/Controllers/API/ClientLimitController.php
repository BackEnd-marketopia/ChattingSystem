<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ClientLimitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:users,id',
            'client_package_id' => 'required|exists:client_package,id',
            'item_type' => 'required|string',
            'edit_limit' => 'required|integer|min:0',
            'decline_limit' => 'required|integer|min:0',
        ]);

        $limit = $this->clientLimitService->create($data);
        return response()->json([
            'message' => 'Client limit created successfully',
            'data' => $limit
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'item_type' => 'required|string',
            'edit_limit' => 'nullable|integer|min:0',
            'decline_limit' => 'nullable|integer|min:0',
        ]);

        $limit = $this->clientLimitService->update($id, $data);
        return response()->json($limit);
    }

    public function destroy($id)
    {
        $this->clientLimitService->delete($id);
        return response()->json(['message' => 'Client limit deleted successfully']);
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
