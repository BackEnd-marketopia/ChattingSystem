<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ItemUsageLogService;
use Illuminate\Http\Request;

class ItemUsageLogController extends Controller
{
    protected $service;

    public function __construct(ItemUsageLogService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->all());
    }

    public function show($id)
    {
        return response()->json($this->service->find($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_package_id' => 'required|exists:client_package,id',
            'item_id' => 'required|integer',
            'item_type' => 'required|string',
            'action' => 'required|in:edit,accept,decline',
            'note' => 'nullable|string',
            'performed_by' => 'nullable|exists:users,id',
        ]);
        return response()->json($this->service->create($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'item_type' => 'required|string',
            'item_id' => 'nullable|integer',
            'action' => 'required|in:edit,decline,accept',
            'count' => 'required|integer|min:1'
        ]);
        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        return response()->json([
            'deleted' => $this->service->delete($id),
            'message' => 'Item usage log deleted successfully'
        ]);
    }

    public function byClientPackage($clientPackageId)
    {
        return response()->json($this->service->getByClientPackage($clientPackageId));
    }
}
