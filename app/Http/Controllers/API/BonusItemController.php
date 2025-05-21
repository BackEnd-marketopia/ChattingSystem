<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BonusItemRequest;
use App\Http\Requests\UpdateBonusItemRequest;
use App\Services\BonusItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BonusItemController extends Controller
{
    protected $bonusItemService;

    public function __construct(BonusItemService $bonusItemService)
    {
        $this->bonusItemService = $bonusItemService;
    }

    public function index($clientPackageId)
    {
        return Response::api('Bonus items retrieved successfully', 200, true, 200, $this->bonusItemService->getByClientPackage($clientPackageId));
    }

    public function deliver($id)
    {
        return Response::api('Bonus item marked as delivered successfully', 200, true, 200, $this->bonusItemService->deliver($id));
    }

    public function store(BonusItemRequest $request)
    {
        $data = $request->validated();
        return Response::api('Bonus item created successfully', 200, true, 200, $this->bonusItemService->create($data));
    }

    public function show($id)
    {
        return Response::api('Bonus item retrieved successfully', 200, true, 200, $this->bonusItemService->find($id));
    }

    public function update(UpdateBonusItemRequest $request, $id)
    {
        $data = $request->validated();
        return Response::api('Bonus item updated successfully', 200, true, 200, $this->bonusItemService->update($id, $data));
    }

    public function destroy($id)
    {
        return Response::api('Bonus item deleted successfully', 200, true, 200, $this->bonusItemService->delete($id));
    }
}
