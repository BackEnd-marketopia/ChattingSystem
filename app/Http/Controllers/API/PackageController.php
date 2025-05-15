<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use App\Http\Requests\packageUpdateRequest;
use App\Services\PackageService;
use Illuminate\Support\Facades\Response;

class PackageController extends Controller
{

    protected $service;

    public function __construct(PackageService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return Response::api('Packages fetched successfully', 200, true, 200, $this->service->listPackages());
    }

    public function show($id)
    {
        return Response::api('Package fetched successfully', 200, true, 200, $this->service->getPackage($id));
    }

    public function store(PackageRequest $request)
    {
        $validated = $request->validated();
        return Response::api('Package created successfully', 201, true, 201, $this->service->createPackage($validated));
    }

    public function update(packageUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        return Response::api('Package updated successfully', 200, true, 200, $this->service->updatePackage($id, $validated));
    }

    public function destroy($id)
    {
        return Response::api('Package deleted successfully', 200, true, 200, ['deleted' => $this->service->deletePackage($id)]);
    }
}
