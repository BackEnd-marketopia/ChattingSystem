<?php

namespace App\Repositories\ClientPackage;

use App\Models\ClientPackage;
use App\Models\ItemUsageLog;
use App\Models\ItemStatusHistory;
use Illuminate\Support\Facades\Auth;


class ClientPackageRepository implements ClientPackageInterface
{
    public function all()
    {
        $user = Auth::user();

        if ($user->roles->contains('name', 'admin')) {
            return ClientPackage::all();
        }

        if ($user->roles->contains('name', 'team')) {
            return ClientPackage::whereHas('chat.teamMembers', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })->get();
        }

        if ($user->roles->contains('name', 'client')) {
            return ClientPackage::where('client_id', $user->id)->get();
        }
    }

    public function getByChat($id)
    {
        return ClientPackage::where('chat_id', $id)->first();
    }

    public function find($id)
    {
        return ClientPackage::with([
            'clientPackageItems',
            'clientLimits',
            'package',
            'package.packageItems'
        ])
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        return ClientPackage::create($data);
    }

    public function update($id, array $data)
    {
        $package = ClientPackage::findOrFail($id);
        $package->update($data);
        return $package;
    }

    public function delete($id)
    {
        return ClientPackage::destroy($id);
    }
}
