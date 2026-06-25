<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;
use App\Models\Admin;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    // Cek apakah user adalah admin
    if (auth()->guard('admin')->check()) {
        return [
            'id' => 'admin-' . auth()->guard('admin')->user()->id,
            'name' => auth()->guard('admin')->user()->name,
            'is_admin' => true,
        ];
    }

    $conv = Conversation::find($conversationId);
    if (!$conv) return false;

    // Cek apakah user adalah pemilik percakapan (customer yang login)
    if ($user && $conv->user_id === $user->id) {
        return [
            'id' => $user->id,
            'name' => $user->name ?? $user->email,
            'is_admin' => false,
        ];
    }

    // Cek guest via UUID cookie
    $uuid = request()->cookie('chat_uuid');
    if ($uuid && $conv->uuid === $uuid && !$conv->user_id) {
        return [
            'id' => $uuid,
            'name' => 'Guest',
            'is_admin' => false,
        ];
    }

    return false;
});

Broadcast::channel('online.admins', function ($user) {
    // Hanya admin yang bisa join presence channel ini
    if (auth()->guard('admin')->check()) {
        $admin = auth()->guard('admin')->user();
        return [
            'id' => 'admin-' . $admin->id,
            'name' => $admin->name,
            'avatar' => null,
        ];
    }
    return false;
});
