<?php
Route::get('/', function () {
    return view('welcome');
});

//authenticate user before sending him to his profile  by using auth middleware

Route::group(['prefix' => '',  'middleware' => 'auth'], function()
{
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/get-suggessions', [App\Http\Controllers\FriendshipController::class, 'getSuggessions'])->name('getSuggessions');
    Route::get('/get-sent-requests', [App\Http\Controllers\FriendshipController::class, 'getSentRequests'])->name('getSentRequests');
    Route::get('/get-recieved-request', [App\Http\Controllers\FriendshipController::class, 'getRecievedRequests'])->name('getRecievedRequests');
    Route::get('/get-common-connections', [App\Http\Controllers\FriendshipController::class, 'getCommonConnections'])->name('getCommonConnections');


    Route::get('/get-connections', [App\Http\Controllers\FriendshipController::class, 'getConnections'])->name('getConnections');


    Route::get('/send-request', [App\Http\Controllers\FriendshipController::class, 'sendRequest'])->name('sendRequest');
    Route::get('/delete-request', [App\Http\Controllers\FriendshipController::class, 'deleteRequest'])->name('deleteRequest');
    Route::get('/accept-request', [App\Http\Controllers\FriendshipController::class, 'acceptRequest'])->name('acceptRequest');
    Route::get('/remove-connection', [App\Http\Controllers\FriendshipController::class, 'removeConnection'])->name('removeConnection');




});
