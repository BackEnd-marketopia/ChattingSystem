<?php

namespace App\Repositories\ItemStatusHistory;

use App\Models\ItemStatusHistory;

interface ItemStatusHistoryRepositoryInterface
{
    public function create(array $data): ItemStatusHistory;
    public function find(int $id): ?ItemStatusHistory;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getByItem(int $itemId): array;
}
