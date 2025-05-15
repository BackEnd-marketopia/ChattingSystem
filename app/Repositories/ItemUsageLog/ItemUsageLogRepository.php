<?php

namespace App\Repositories;

use App\Models\ItemUsageLog;
use App\Repositories\Interfaces\ItemUsageLogRepositoryInterface;

class ItemUsageLogRepository implements ItemUsageLogRepositoryInterface
{
    public function all() {
        return ItemUsageLog::all();
    }

    public function find($id) {
        return ItemUsageLog::findOrFail($id);
    }

    public function create(array $data) {
        return ItemUsageLog::create($data);
    }

    public function update($id, array $data) {
        $log = $this->find($id);
        $log->update($data);
        return $log;
    }

    public function delete($id) {
        return ItemUsageLog::destroy($id);
    }

    public function getByClientPackage($clientPackageId) {
        return ItemUsageLog::where('client_package_id', $clientPackageId)->get();
    }
}