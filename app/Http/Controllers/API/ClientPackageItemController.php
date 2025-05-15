<?php

namespace App\Http\Controllers\Api;

use App\Services\ClientPackageItemService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientPackageItemController extends Controller
{
    protected $service;

    public function __construct(ClientPackageItemService $service)
    {
        $this->service = $service;
    }

    public function edit(Request $request, $id)
    {
        $data = $request->only(['note']);
        $item = $this->service->editItem($id, $data);
        return response()->json(['data' => $item]);
    }

    public function accept($id)
    {
        $item = $this->service->acceptItem($id);
        return response()->json(['data' => $item]);
    }

    public function decline(Request $request, $id)
    {
        $data = $request->only(['note']);
        $item = $this->service->declineItem($id, $data);
        return response()->json(['data' => $item]);
    }
}
