<?php
ini_set('xdebug.var_display_max_depth', 9999);
ini_set('xdebug.var_display_max_children', 9999);
ini_set('xdebug.var_display_max_data', 9999);

/*
|--------------------------------------------------------------------------
| Webhooks
|--------------------------------------------------------------------------
*/
Route::post(env('TELEGRAM_BOT_TOKEN'), 'WebhooksController@receive');


/*
|--------------------------------------------------------------------------
| App
|--------------------------------------------------------------------------
*/
Route::get('{user_id}/{uuid}', 'PostsController@posts')->middleware('expires');
Route::get('{user_id}/{uuid}/{post_id}', 'PostsController@post')->middleware('expires');

Route::get('expired', function(){
	return view('expired');
});


/*
|--------------------------------------------------------------------------
| Tests
|--------------------------------------------------------------------------
*/
Route::get('save', 'InstagramController@save');

