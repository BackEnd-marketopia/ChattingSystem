<?php

namespace App\Services;

use App\Repositories\PackageItemUsageRepository;
use App\Services\ChatMessageService;
use Illuminate\Validation\ValidationException;

class PackageItemUsageService
{
    protected $repo;
    protected $chatMessageService;

    public function __construct(
        PackageItemUsageRepository $repo,
        ChatMessageService $chatMessageService
    ) {
        $this->repo = $repo;
        $this->chatMessageService = $chatMessageService;
    }

    public function useItem($clientId, $packageId, $itemType, $itemId, $action, $note = null)
    {
        $clientPackage = $this->repo->getClientPackage($clientId, $packageId);

        if (!$clientPackage) {
            throw ValidationException::withMessages(['package' => 'Package is not associated with this client']);
        }

        $limit = $this->repo->getLimit($clientPackage->id, $itemType);

        if (!$limit || !isset($limit[$action . '_limit'])) {
            throw ValidationException::withMessages(['limit' => 'No limit exists for this action']);
        }

        $currentCount = $this->repo->countUsages($clientPackage->id, $itemType, $itemId, $action);

        if ($currentCount >= $limit[$action . '_limit']) {
            throw ValidationException::withMessages(['limit' => 'Action limit exceeded: ' . $action]);
        }

        $this->repo->logUsage($clientPackage->id, $itemType, $itemId, $action, $note);

        $this->chatMessageService->sendMessage(
            $clientPackage->chat_id,
            "Action $action has been executed on $itemType ID: $itemId"
        );

        return true;
    }
}
