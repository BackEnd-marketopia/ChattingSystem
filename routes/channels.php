<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('item.status.{client_package_item_id}', function ($user, $client_package_item_id) {

    $item = \App\Models\ClientPackageItem::find($client_package_item_id);
    return $user->id === $item->client_id || $user->team_id === $item->team_id;
});

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return true;
});
