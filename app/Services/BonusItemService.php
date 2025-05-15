<?php

namespace App\Services;

use App\Repositories\Interfaces\BonusItemRepositoryInterface;

class BonusItemService
{
    protected $bonusItemRepository;

    public function __construct(BonusItemRepositoryInterface $bonusItemRepository)
    {
        $this->bonusItemRepository = $bonusItemRepository;
    }

    public function getByClientPackage($clientPackageId)
    {
        return $this->bonusItemRepository->allByClientPackage($clientPackageId);
    }

    public function deliver($bonusItemId)
    {
        return $this->bonusItemRepository->markAsDelivered($bonusItemId);
    }


    public function create(array $data)
    {
        return $this->bonusItemRepository->create($data);
    }

    public function find($id)
    {
        return $this->bonusItemRepository->find($id);
    }


    public function update($id, array $data)
    {
        return $this->bonusItemRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->bonusItemRepository->delete($id);
    }
}
