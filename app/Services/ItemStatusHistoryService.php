<?php

namespace App\Services;

use App\Repositories\ItemStatusHistory\ItemStatusHistoryRepositoryInterface;

class ItemStatusHistoryService
{
    protected $repository;

    public function __construct(ItemStatusHistoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

    public function getByItem(int $itemId)
    {
        return $this->repository->getByItem($itemId);
    }
}
