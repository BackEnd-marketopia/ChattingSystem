<?php

namespace App\Repositories\BonusItem;

use App\Models\BonusItem;

class BonusItemRepository implements BonusItemRepositoryInterfacE
{


    public function allByClientPackage($clientPackageId)
    {
        return BonusItem::where('package_id', $clientPackageId)->get();
    }


    public function markAsDelivered($bonusItemId)
    {
        $bonus = BonusItem::findOrFail($bonusItemId);
        $bonus->update([
            'is_claimed' => true,
            'updated_at' => now(),
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
