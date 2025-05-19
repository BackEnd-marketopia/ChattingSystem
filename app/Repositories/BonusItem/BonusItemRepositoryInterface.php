<?php

namespace App\Repositories\BonusItem;

use App\Models\BonusItem;

interface BonusItemRepositoryInterface
{

    public function allByClientPackage($clientPackageId);
    public function markAsDelivered($bonusItemId);

    public function find($id): BonusItem;
    public function create(array $data): BonusItem;
    public function update($id, array $data): BonusItem;
    public function delete($id): bool;
}
