<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemTypeRequest;
use App\Services\ItemTypeService;
use Illuminate\Support\Facades\Response;

class ItemTypeController extends Controller
{
    protected $itemTypeService;

    public function __construct(ItemTypeService $itemTypeService)
    {
        $this->itemTypeService = $itemTypeService;
    }

    public function index()
    {
        return Response::api('ItemTypes fetched successfully', 200, true, 200, $this->itemTypeService->all());
    }

    public function store(ItemTypeRequest $request)
    {
        $validated = $request->validated();
        return Response::api('ItemType created successfully', 201, true, 201, $this->itemTypeService->create($validated));
    }

    public function show($id)
    {
        return Response::api('ItemType fetched successfully', 200, true, 200, $this->itemTypeService->find($id));
    }

    public function update(ItemTypeRequest $request, $id)
    {
        $validated = $request->validated();
        return Response::api('ItemType updated successfully', 200, true, 200, $this->itemTypeService->update($id, $validated));
    }

    public function destroy($id)
    {
        return Response::api('ItemType deleted successfully', 200, true, 200, $this->itemTypeService->delete($id));
    }
}
