<?php


namespace App\Repositories\ClientPackageItem;

interface ClientPackageItemRepositoryInterface
{
    // public function getItemsByClientPackage($clientPackageId);
    // public function getItemByClientPackage($clientPackageId, $itemId);
    // public function create($clientPackageId, array $data);
    // public function update($clientPackageId, $itemId, array $data);
    // public function delete($clientPackageId, $itemId);
    // public function findItem($id);
    // public function updateItem($id, array $data);
    // public function createHistory(array $data);

    public function getByClientPackage($clientPackageId);
    public function show($clientPackageId, $id);
    public function store($clientPackageId, array $data);
    public function update($clientPackageId, $id, array $data);
    public function destroy($clientPackageId, $id);
    // public function accept($id);
    // public function decline($id);
    // public function edit($id);
}
