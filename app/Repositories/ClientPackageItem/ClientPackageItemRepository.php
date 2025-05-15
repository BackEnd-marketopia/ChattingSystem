<?php

namespace App\Repositories\ClientPackageItem;

use App\Models\ClientPackageItem;
use App\Models\ItemStatusHistory;

class ClientPackageItemRepository implements ClientPackageItemRepositoryInterface
{
    public function find($id)
    {
        return ClientPackageItem::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $item = $this->find($id);
        $item->update($data);
        return $item;
    }

    public function createHistory(array $data)
    {
        return ItemStatusHistory::create($data);
    }
}
