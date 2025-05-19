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
            'client_package_id' => 'required|exists:client_package,id',
            'item_id' => 'required|integer',
            'item_type' => 'required|string',
            'status' => 'required|in:pending,accepted,edited,declined',
            'note' => 'nullable|string',
            'updated_by' => 'nullable|exists:users,id',
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
            'status' => 'required|in:pending,accepted,edited,declined',
            'note' => 'nullable|string',
            'updated_by' => 'nullable|exists:users,id',
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
