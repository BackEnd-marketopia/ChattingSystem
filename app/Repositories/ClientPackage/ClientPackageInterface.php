<?php

namespace App\Repositories\ClientPackage;

interface ClientPackageInterface
{
    public function logItemUsage($clientPackageId, $itemType, $itemId, $actionType, $userId);
    public function changeItemStatus($clientPackageId, $itemType, $itemId, $status, $note = null, $userId = null);

    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
