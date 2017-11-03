<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;

class KeyboardController extends Controller
{
	public function show($updates){
		$text = $this->message = $updates['message']['text'];

		if($text == '/start'){
			$keyboard = [
			    ['My saved posts 💾']
			];

			$reply_markup = Telegram::replyKeyboardMarkup([
				'keyboard' => $keyboard, 
				'resize_keyboard' => true, 
				'one_time_keyboard' => false
			]);

			$response = Telegram::sendMessage([
				'text' => 'Paste any Instagram posts here',
				'chat_id' => $updates['message']['chat']['id'], 
				'reply_markup' => $reply_markup
			]);

			$messageId = $response->getMessageId();
		}
	}


}
