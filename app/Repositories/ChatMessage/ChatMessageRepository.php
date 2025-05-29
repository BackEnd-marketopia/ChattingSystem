<?php

// app/Repositories/ChatMessageRepository.php

namespace App\Repositories\ChatMessage;

use App\Http\Requests\ClientPackageItemRequest;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Repositories\ClientPackageItem\ClientPackageItemRepositoryInterface;


class ChatMessageRepository implements ChatMessageRepositoryInterface
{

    // public function getMessagesByChat($chatId)
    // {
    //     $chat = Chat::findOrFail($chatId);

    //     $messages = ChatMessage::with(['sender', 'mediaFiles'])
    //         ->where('chat_id', $chat->id)
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(20);

    //     $messages = $messages->through(function ($message) {
    //         $messageArray = $message->toArray();


    //         $endpoint = rtrim(config('filesystems.disks.r2.endpoint'), '/');
    //         $bucket = config('filesystems.disks.r2.bucket');

    //         $messageArray['media'] = $message->mediaFiles->map(function ($media) use ($endpoint, $bucket) {
    //             return [
    //                 'url' => "{$endpoint}/{$bucket}/{$media->file_path}",
    //                 'type' => $media->file_type,
    //             ];
    //         });

    //         return $messageArray;
    //     });

    //     $messages = $messages->toArray();
    //     $messages['data'] = array_reverse($messages['data']);
    //     return $messages;
    // }


    // Get messages of a chat 
    public function getMessagesByChat($chatId)
    {
        $chat = Chat::findOrFail($chatId);

        $messages = ChatMessage::with(['sender', 'mediaFiles', 'clientPackageItem', 'chat.client'])
            ->where('chat_id', $chat->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // $messages = ChatMessage::with(['sender', 'mediaFiles', 'clientPackageItem'])
        //     ->where('chat_id', $chat->id)
        //     ->latest(); // Order by created_at desc to get the most recent messages first
        // ->orderBy('created_at', 'desc')
        // ->paginate(20);

        $publicUrl = rtrim(config('filesystems.disks.r2.public_url'), '/');

        $messages = $messages->through(function ($message) use ($publicUrl) {
            $messageArray = $message->toArray();

            $messageArray['media'] = $message->mediaFiles->map(function ($media) use ($publicUrl) {
                return [
                    'url' => "{$publicUrl}/{$media->file_path}",
                    'type' => $media->file_type,
                ];
            });

            return $messageArray;
        });

        $messages = $messages->toArray();
        $messages['data'] = array_reverse($messages['data']);

        return $messages;
    }



    // public function sendMessage(array $data)
    // {
    //     $message = Chat::findOrFail($data['chat_id']);

    //     if ($message) {
    //         $message = ChatMessage::create(
    //             [
    //                 'chat_id' => $data['chat_id'],
    //                 'sender_id' => $data['sender_id'],
    //                 'message' => $data['message'],
    //                 'client_package_item_id' => $data['client_package_item_id']
    //             ]
    //         );
    //     }

    //     if (!empty($data['media'])) {
    //         foreach ($data['media'] as $file) {
    //             $path = $file->store('chat-media', 'r2');
    //             $fileType = $file->getClientMimeType();

    //             $message->mediaFiles()->create([
    //                 'file_path' => $path,
    //                 'file_type' => $fileType,
    //             ]);
    //         }
    //     }

    //     return $message->load('mediaFiles');
    // }


    // Send a message to a chat
    public function sendMessage(array $data)
    {

        $message = Chat::findOrFail($data['chat_id']);
        $clientPackageItemId = null;

        if (isset($data['IsItem']) && $data['IsItem'] == 1) {

            $clientPackageItemData = [
                'item_type' => $data['item_type'],
                'package_item_id' => $data['package_item_id'] ?? null,
                'client_package_id' => $data['client_package_id'],
                'content' => $data['message'],
                'client_note' => $data['client_note'] ?? null,
                'status' => 'pending',
                'handeled_by' => $data['sender_id'] ?? null,
            ];

            $request = new ClientPackageItemRequest();
            $request->merge($clientPackageItemData);
            $request->setMethod('POST');

            $validator = app('validator')->make($request->all(), $request->rules());
            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }
            $validatedData = $validator->validated();

            $clientPackageExists = \App\Models\ClientPackage::where('id', $validatedData['client_package_id'])->exists();
            if (!$clientPackageExists) {
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Client package not found');
            }

            $validatedData['item_type'] = (string)$validatedData['item_type'];


            $repository = app()->make(ClientPackageItemRepositoryInterface::class);
            $clientPackageItem = $repository->store($validatedData['client_package_id'], $validatedData);

            if (!$clientPackageItem) {
                throw new \Exception('Failed to create client package item');
            }

            $clientPackageItemId = $clientPackageItem->id;
        }

        if ($message) {
            $message = ChatMessage::create([
                'chat_id' => $data['chat_id'],
                'sender_id' => $data['sender_id'],
                'message' => $data['message'],
                'client_package_item_id' => $clientPackageItemId,
            ]);
        }

        if (!empty($data['media'])) {
            foreach ($data['media'] as $file) {
                $path = $file->store('chat-media', ['disk' => 'r2', 'visibility' => 'public']);
                $fileType = $file->getClientMimeType();

                $message->mediaFiles()->create([
                    'file_path' => $path,
                    'file_type' => $fileType,
                ]);
            }
        }

        return $message->load(['mediaFiles', 'clientPackageItem']);
    }
}
