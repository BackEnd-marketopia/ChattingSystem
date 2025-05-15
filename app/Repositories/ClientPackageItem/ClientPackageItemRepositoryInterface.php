<?php


namespace App\Repositories\ClientPackageItem;

interface ClientPackageItemRepositoryInterface
{
    public function find($id);
    public function update($id, array $data);
    public function createHistory(array $data);
}
