<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\ItemType\ItemTypeRepositoryInterface;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    protected $itemTypeRepository;

    public function __construct(ItemTypeRepositoryInterface $itemTypeRepository)
    {
        $this->itemTypeRepository = $itemTypeRepository;
    }

    public function index()
    {
        return response()->json($this->itemTypeRepository->all());
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:item_types,name']);
        $type = $this->itemTypeRepository->create($request->only('name'));
        return response()->json($type, 201);
    }

    public function show($id)
    {
        return response()->json($this->itemTypeRepository->find($id));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|unique:item_types,name,' . $id]);
        $type = $this->itemTypeRepository->update($id, $request->only('name'));
        return response()->json($type);
    }

    public function destroy($id)
    {
        $this->itemTypeRepository->delete($id);
        return response()->json(['message' => 'ItemType deleted successfully']);
    }
}
