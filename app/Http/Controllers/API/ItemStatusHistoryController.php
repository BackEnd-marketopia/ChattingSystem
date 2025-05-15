<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ItemStatusHistoryService;

class ItemStatusHistoryController extends Controller
{
    protected $service;

    public function __construct(ItemStatusHistoryService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_package_item_id' => 'required|exists:client_package_items,id',
            'status' => 'required|in:accepted,declined,edited',
            'comment' => 'nullable|string'
        ]);

        return response()->json([
            'status' => true,
            'data' => $this->service->create($data)
        ]);
    }

    public function show(int $id)
    {
        return response()->json([
            'status' => true,
            'data' => $this->service->find($id)
        ]);
    }


    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'status' => 'required|in:accepted,declined,edited',
            'comment' => 'nullable|string'
        ]);

        return response()->json([
            'status' => true,
            'data' => $this->service->update($id, $data)
        ]);
    }

    public function destroy(int $id)
    {
        return response()->json([
            'status' => true,
            'data' => $this->service->delete($id)
        ]);
    }


    public function indexByItem($itemId)
    {
        return response()->json([
            'status' => true,
            'data' => $this->service->getByItem($itemId)
        ]);
    }
}
