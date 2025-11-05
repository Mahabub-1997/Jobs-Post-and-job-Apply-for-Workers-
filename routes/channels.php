<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('job-post-channel', function ($user) {
    // Only allow tradepersons to listen (adjust 'role' field as per your User model)
    return $user->role === 'tradeperson' || $user->role === 'admin';
});

// Private user-specific channel (optional)
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
