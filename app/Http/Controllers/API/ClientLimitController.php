<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ClientLimitService;
use Illuminate\Http\Request;

class ClientLimitController extends Controller
{
    protected $clientLimitService;

    public function __construct(ClientLimitService $clientLimitService)
    {
        $this->clientLimitService = $clientLimitService;
    }

    public function remainingLimits($clientPackageId)
    {
        $limits = $this->clientLimitService->getRemainingLimits($clientPackageId);
        return response()->json(['data' => $limits]);
    }

    public function decrementEdit($clientPackageId, $itemType)
    {
        $this->clientLimitService->decrementEdit($clientPackageId, $itemType);
        return response()->json(['message' => 'Edit limit decremented successfully']);
    }

    public function decrementDecline($clientPackageId, $itemType)
    {
        $this->clientLimitService->decrementDecline($clientPackageId, $itemType);
        return response()->json(['message' => 'Decline limit decremented successfully']);
    }
    
}
