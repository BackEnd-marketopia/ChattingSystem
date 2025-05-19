<?php

namespace App\Repositories\ClientLimit;


interface ClientLimitRepositoryInterface
{
    // public function getByClientPackageAndType($clientPackageId, $itemType);
    // public function decrementLimit($clientPackageId, $itemType, $field); // 'edit' or 'decline'
    // public function getRemainingLimits($clientPackageId): array;

    public function getAll(array $filters = []);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

    public function getByPackageAndType($clientPackageId, $itemType);
    public function decrementEdit($clientPackageId, $itemType);
    public function decrementDecline($clientPackageId, $itemType);
}
