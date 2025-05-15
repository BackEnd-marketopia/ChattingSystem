<?php

namespace App\Repositories;

use App\Models\BonusItem;
use App\Repositories\Interfaces\BonusItemRepositoryInterface;

class BonusItemRepository implements BonusItemRepositoryInterface
{


    public function allByClientPackage($clientPackageId)
    {
        return BonusItem::where('client_package_id', $clientPackageId)->get();
    }


    public function markAsDelivered($bonusItemId)
    {
        $bonus = BonusItem::findOrFail($bonusItemId);
        $bonus->update([
            'delivered' => true,
            'delivery_date' => now(),
        ]);
        return $bonus;
    }


    public function find($id): BonusItem
    {
        return BonusItem::findOrFail($id);
    }

    public function create(array $data): BonusItem
    {
        return BonusItem::create($data);
    }

    public function update($id, array $data): BonusItem
    {
        $bonus = BonusItem::findOrFail($id);
        $bonus->update($data);
        return $bonus;
    }

    public function delete($id): bool
    {
        $bonus = BonusItem::findOrFail($id);
        return $bonus->delete();
    }
}
