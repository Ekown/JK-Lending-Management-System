<?php

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('loanChannel.{loanId}', function () {
    return true;
});

Broadcast::channel('loanMasterListChannel', function () {
    return true;
});

Broadcast::channel('updateActiveLoans', function () {
    return true;
});

Broadcast::channel('borrowerChannel.{id}', function () {
    return true;
});

Broadcast::channel('borrowerMasterListChannel', function () {
    return true;
});

Broadcast::channel('cashAdvanceMasterListChannel', function () {
    return true;
});

Broadcast::channel('companyChannel.{companyId}', function () {
    return true;
});

Broadcast::channel('companyMasterListChannel', function () {
    return true;
});