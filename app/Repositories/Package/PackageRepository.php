<?php

namespace App\Repositories\Package;

use App\Models\Package;
use App\Repositories\Package\PackageRepositoryInterface;

class PackageRepository implements PackageRepositoryInterface
{

    public function getAll()
    {
        return Package::all();
    }

    public function findById($id)
    {
        $package = Package::findOrFail($id);
        $package->load(['packageItems']);
        $package->packageItems->each(function ($item) {
            $item->load(['allowedItem']);
        });
        return $package;
    }

    public function create(array $data)
    {
        return Package::create($data);
    }

    public function update($id, array $data)
    {
        $package = Package::findOrFail($id);
        if ($package) {
            $package->update($data);
            return $package;
        }
        return null;
    }

    public function delete($id)
    {
        $package = Package::findOrFail($id);
        if ($package) {
            $package->delete();
            return true;
        }
        return false;
    }
}
