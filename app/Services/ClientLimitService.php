<?php

namespace App\Services;

use App\Repositories\ClientLimit\ClientLimitRepositoryInterface;

class ClientLimitService
{
    protected $clientLimitRepository;

    public function __construct(ClientLimitRepositoryInterface $clientLimitRepository)
    {
        $this->clientLimitRepository = $clientLimitRepository;
    }

    // public function getRemainingLimits($clientPackageId)
    // {
    //     return $this->clientLimitRepository->getRemainingLimits($clientPackageId);
    // }

    // public function decrementEdit($clientPackageId, $itemType)
    // {
    //     return $this->clientLimitRepository->decrementLimit($clientPackageId, $itemType, 'remaining_edits');
    // }

    // public function decrementDecline($clientPackageId, $itemType)
    // {
    //     return $this->clientLimitRepository->decrementLimit($clientPackageId, $itemType, 'remaining_declines');
    // }

    public function getAll(array $filters = [])
    {
        return $this->clientLimitRepository->getAll($filters);
    }

    public function create(array $data)
    {
        return $this->clientLimitRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->clientLimitRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->clientLimitRepository->delete($id);
    }


    public function getRemainingLimits($clientPackageId, $itemType)
    {
        return $this->clientLimitRepository->getByPackageAndType($clientPackageId, $itemType);
    }

    public function decrementEdit($clientPackageId, $itemType)
    {
        return $this->clientLimitRepository->decrementEdit($clientPackageId, $itemType);
    }

    public function decrementDecline($clientPackageId, $itemType)
    {
        return $this->clientLimitRepository->decrementDecline($clientPackageId, $itemType);
    }
}
