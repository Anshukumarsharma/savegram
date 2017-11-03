<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\KeyboardController;
use Telegram;

class WebhooksController extends Controller
{	
    public function receive(KeyboardController $keyboard){
		$updates = json_decode(Telegram::getWebhookUpdates(), true);
		$message = new MessageController($updates);
		$keyboard->show($updates);
		
		return $message->reply();
	}
}
