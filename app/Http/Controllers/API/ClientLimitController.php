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


    public function remainingLimitsByChatId($chatId)
    {
        $chatController = app(\App\Http\Controllers\API\ChatController::class);
        $chatResponse = $chatController->getUserChat($chatId);

        if ($chatResponse instanceof \Illuminate\Http\JsonResponse) {
            $chatData = $chatResponse->getData(true);
            $chat = $chatData['data'] ?? null;
        } else {
            $chat = $chatResponse;
        }
        if (!$chat) {
            return null;
        }

        $clientPackageController = app(\App\Http\Controllers\API\ClientPackageController::class);
        $clientPackageResponse = $clientPackageController->showbychat($chatId);

        if ($clientPackageResponse instanceof \Illuminate\Http\JsonResponse) {
            $clientPackageData = $clientPackageResponse->getData(true);
            $clientpackage = $clientPackageData['data'] ?? null;
        } else {
            $clientpackage = $clientPackageResponse;
        }
        if (!$clientpackage) {
            return null;
        }

        // dd($clientpackage);
        $clientPackageItemController = app(\App\Http\Controllers\API\ClientPackageItemController::class);
        $itemsResponse = $clientPackageItemController->index($clientpackage['id']);

        if ($itemsResponse instanceof \Illuminate\Http\JsonResponse) {
            $itemsData = $itemsResponse->getData(true);
            $items = $itemsData['data'] ?? [];
        } else {
            $items = $itemsResponse;
        }

        // dd($items);
        $result = [];
        if (is_array($items) || is_object($items)) {
            // dd($items);
            foreach ($items as $item) {
                $limits = $this->clientLimitService->getRemainingLimits($clientpackage['id'], $item['item_type'] ?? null);
                $limitData = null;
                if (is_array($limits) && count($limits) > 0) {
                    $limitData = $limits[0]; // Assuming getRemainingLimits returns an array of limits
                } elseif (is_object($limits)) {
                    $limitData = $limits;
                }
                // dd($limitData);
                $result[] = [
                    'id' => $limitData['id'] ?? null,
                    'client_id' => $limitData['client_id'] ?? null,
                    'client_package_id' => $limitData['client_package_id'] ?? null,
                    'client_package_item_id' => $limitData['client_package_item_id'] ?? null,
                    'item_type' => $limitData['item_type'] ?? null,
                    'edit_limit' => $limitData['edit_limit'] ?? null,
                    'decline_limit' => $limitData['decline_limit'] ?? null,
                    'created_at' => $limitData['created_at'] ?? null,
                    'updated_at' => $limitData['updated_at'] ?? null,
                ];
            }
        }

        return $result;
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
