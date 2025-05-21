<?php

namespace App\Repositories\ClientPackageItem;

use App\Models\ClientPackageItem;
use App\Models\ItemStatusHistory;

class ClientPackageItemRepository implements ClientPackageItemRepositoryInterface
{

    public function getByClientPackage($clientPackageId)
    {
        return ClientPackageItem::where('client_package_id', $clientPackageId)->get();
    }

    public function show($clientPackageId, $id)
    {
        return ClientPackageItem::where('client_package_id', $clientPackageId)->findOrFail($id);
    }

    public function store($clientPackageId, array $data)
    {
        $data['client_package_id'] = $clientPackageId;
        return ClientPackageItem::create($data);
    }

    public function update($clientPackageId, $id, array $data)
    {
        $item = $this->show($clientPackageId, $id);
        $item->update($data);
        return $item;
    }

    public function destroy($clientPackageId, $id)
    {
        $item = $this->show($clientPackageId, $id);
        return $item->delete();
    }

    // public function accept($id)
    // {
    //     $item = ClientPackageItem::findOrFail($id);
    //     $item->status = 'accepted';
    //     $item->save();
    //     return $item;
    // }

    // public function decline($id)
    // {
    //     $item = ClientPackageItem::findOrFail($id);
    //     $item->status = 'declined';
    //     $item->save();
    //     return $item;
    // }

    // public function edit($id)
    // {
    //     $item = ClientPackageItem::findOrFail($id);
    //     $item->status = 'edited';
    //     $item->save();
    //     return $item;
    // }
}
