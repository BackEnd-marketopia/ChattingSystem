<?php

namespace App\Services;

use App\Repositories\ItemUsageLog\ItemUsageLogRepositoryInterface;

class ItemUsageLogService
{
    protected $repository;

    public function __construct(ItemUsageLogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function getByClientPackage($clientPackageId)
    {
        return $this->repository->getByClientPackage($clientPackageId);
    }
}
