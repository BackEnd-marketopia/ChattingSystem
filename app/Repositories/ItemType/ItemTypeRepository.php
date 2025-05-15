<?php


namespace App\Repositories\ItemType;

use App\Models\ItemType;

class ItemTypeRepository implements ItemTypeRepositoryInterface
{
    public function all()
    {
        return ItemType::all();
    }

    public function find($id)
    {
        return ItemType::findOrFail($id);
    }

    public function create(array $data)
    {
        return ItemType::create($data);
    }

    public function update($id, array $data)
    {
        $itemType = ItemType::findOrFail($id);
        $itemType->update($data);
        return $itemType;
    }

    public function delete($id)
    {
        $itemType = ItemType::findOrFail($id);
        return $itemType->delete();
    }
}
