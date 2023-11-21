<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('order.{hashed_id}', function ( User $user, $hashed_id) {
    return ['order_id' => $hashed_id, 'name' => $user->name, 'ably-capability' => ["subscribe", "history", "channel-metadata", "presence"]];
    //return false;
});
