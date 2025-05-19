<?php

namespace App\Services;

use App\Repositories\ItemType\ItemTypeRepositoryInterface;



class ItemTypeService
{
    protected $itemTypeRepository;

    public function __construct(ItemTypeRepositoryInterface $itemTypeRepository)
    {
        $this->itemTypeRepository = $itemTypeRepository;
    }

    public function all()
    {
        return $this->itemTypeRepository->all();
    }

    public function find($id)
    {
        return $this->itemTypeRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->itemTypeRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->itemTypeRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->itemTypeRepository->delete($id);
    }
}
