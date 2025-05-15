<?php

namespace App\Events;

use App\Models\ItemStatusHistory;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ItemStatusUpdatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $history;

    public function __construct(ItemStatusHistory $history)
    {
        $this->history = $history->load('item', 'updatedBy');
    }

    public function broadcastOn(): Channel
    {
        return new Channel('item.status.' . $this->history->client_package_item_id);
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->history->id,
            'client_package_item_id' => $this->history->client_package_item_id,
            'status' => $this->history->status,
            'note' => $this->history->note,
            'updated_by' => [
                'id' => $this->history->updatedBy->id,
                'name' => $this->history->updatedBy->name,
                'role' => $this->history->updatedBy->role,
            ],
            'created_at' => $this->history->created_at->toDateTimeString(),
        ];
    }
}
