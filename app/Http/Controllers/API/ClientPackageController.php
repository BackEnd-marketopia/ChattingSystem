<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientPackageService;
use Illuminate\Support\Facades\Auth;

class ClientPackageController extends Controller
{
    protected $clientPackageService;

    public function __construct(ClientPackageService $clientPackageService)
    {
        $this->clientPackageService = $clientPackageService;
    }

    public function logUsage(Request $request)
    {
        $validated = $request->validate([
            'client_package_id' => 'required|exists:client_packages,id',
            'item_type' => 'required|string',
            'item_id' => 'required|integer',
            'action_type' => 'required|in:edit,accept,decline',
        ]);

        $log = $this->clientPackageService->recordUsage(
            $validated['client_package_id'],
            $validated['item_type'],
            $validated['item_id'],
            $validated['action_type'],
            Auth::id()
        );

        return response()->json(['success' => true, 'data' => $log]);
    }

    public function changeStatus(Request $request)
    {
        $validated = $request->validate([
            'client_package_id' => 'required|exists:client_packages,id',
            'item_type' => 'required|string',
            'item_id' => 'required|integer',
            'status' => 'required|in:pending,accepted,declined,edited',
            'note' => 'nullable|string',
        ]);

        $history = $this->clientPackageService->updateStatus(
            $validated['client_package_id'],
            $validated['item_type'],
            $validated['item_id'],
            $validated['status'],
            $validated['note'],
            Auth::id()
        );

        return response()->json(['success' => true, 'data' => $history]);
    }


    public function index()
    {
        return response()->json($this->clientPackageService->getAll());
    }

    public function show($id)
    {
        return response()->json($this->clientPackageService->getById($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'is_active' => 'boolean',
        ]);

        return response()->json($this->clientPackageService->create($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'is_active' => 'boolean',
        ]);

        return response()->json($this->clientPackageService->update($id, $data));
    }

    public function destroy($id)
    {
        return response()->json(['deleted' => $this->clientPackageService->delete($id)]);
    }
}
