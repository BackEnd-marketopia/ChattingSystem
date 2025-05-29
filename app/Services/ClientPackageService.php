<?php

namespace App\Services;

use App\Repositories\ClientPackage\ClientPackageInterface;

class ClientPackageService
{
    protected $clientPackageRepo;

    public function __construct(ClientPackageInterface $clientPackageRepo)
    {
        $this->clientPackageRepo = $clientPackageRepo;
    }

    // public function recordUsage($clientPackageId, $itemType, $itemId, $action, $userId)
    // {
    //     return $this->clientPackageRepo->logItemUsage(
    //         $clientPackageId,
    //         $itemType,
    //         $itemId,
    //         $action,
    //         $userId
    //     );
    // }

    // public function updateStatus($clientPackageId, $itemType, $itemId, $status, $note = null, $userId = null)
    // {
    //     return $this->clientPackageRepo->changeItemStatus(
    //         $clientPackageId,
    //         $itemType,
    //         $itemId,
    //         $status,
    //         $note,
    //         $userId
    //     );
    // }

    public function getAll()
    {
        return $this->clientPackageRepo->all();
    }

    public function getByChat($id){
        return $this->clientPackageRepo->getByChat($id);
    }

    public function getById($id)
    {
        return $this->clientPackageRepo->find($id);
    }

    public function create(array $data)
    {
        return $this->clientPackageRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->clientPackageRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->clientPackageRepo->delete($id);
    }
}
