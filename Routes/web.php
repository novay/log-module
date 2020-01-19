<?php

/*
|--------------------------------------------------------------------------
| Log Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('activity')->middleware(['activity'])->group(function() {

    // Dashboards
    Route::get('/', 'LogController@showAccessLog')->name('activity');
    Route::get('/cleared', ['uses' => 'LogController@showClearedActivityLog'])->name('cleared');

    // Drill Downs
    Route::get('/log/{id}', 'LogController@showAccessLogEntry');
    Route::get('/cleared/log/{id}', 'LogController@showClearedAccessLogEntry');

    // Forms
    Route::delete('/clear-activity', ['uses' => 'LogController@clearActivityLog'])->name('clear-activity');
    Route::delete('/destroy-activity', ['uses' => 'LogController@destroyActivityLog'])->name('destroy-activity');
    Route::post('/restore-log', ['uses' => 'LogController@restoreClearedActivityLog'])->name('restore-activity');
    
});