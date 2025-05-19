<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\BonusItemService;
use Illuminate\Http\Request;

class BonusItemController extends Controller
{
    protected $bonusItemService;

    public function __construct(BonusItemService $bonusItemService)
    {
        $this->bonusItemService = $bonusItemService;
    }

    public function index($clientPackageId)
    {
        return response()->json([
            'data' => $this->bonusItemService->getByClientPackage($clientPackageId),
        ]);
    }

    public function deliver($id)
    {
        return response()->json([
            'data' => $this->bonusItemService->deliver($id),
            'message' => 'Bonus item marked as delivered.',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'client_id' => 'required|exists:users,id',
            'item_type' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'is_static' => 'boolean',
            'is_claimed' => 'boolean',
            'note' => 'nullable|string',
        ]);

        $bonus = $this->bonusItemService->create($data);

        return response()->json([
            'data' => $bonus,
            'message' => 'Bonus item created successfully.',
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'data' => $this->bonusItemService->find($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'item_type'   => 'sometimes|string',
            'quantity' => 'required|integer|min:1',
            'is_static' => 'boolean',
            'is_claimed' => 'boolean',
            'note' => 'nullable|string',
        ]);

        $bonus = $this->bonusItemService->update($id, $data);

        return response()->json([
            'data' => $bonus,
            'message' => 'Bonus item updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        $this->bonusItemService->delete($id);

        return response()->json([
            'message' => 'Bonus item deleted successfully.',
        ]);
    }
}
