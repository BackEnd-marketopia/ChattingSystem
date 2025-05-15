<?php

namespace App\Services;

use App\Repositories\Interfaces\ClientLimitRepositoryInterface;

class ClientLimitService
{
    protected $clientLimitRepository;

    public function __construct(ClientLimitRepositoryInterface $clientLimitRepository)
    {
        $this->clientLimitRepository = $clientLimitRepository;
    }

    public function getRemainingLimits($clientPackageId)
    {
        return $this->clientLimitRepository->getRemainingLimits($clientPackageId);
    }

    public function decrementEdit($clientPackageId, $itemType)
    {
        return $this->clientLimitRepository->decrementLimit($clientPackageId, $itemType, 'remaining_edits');
    }

    public function decrementDecline($clientPackageId, $itemType)
    {
        return $this->clientLimitRepository->decrementLimit($clientPackageId, $itemType, 'remaining_declines');
    }
}
