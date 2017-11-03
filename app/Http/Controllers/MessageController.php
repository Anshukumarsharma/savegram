<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\InstagramController;
use Telegram;

class MessageController extends Controller
{	
	public function __construct($updates){
		$this->user_id = $updates['message']['from']['id'];
		$this->message = $updates['message']['text'];
		$this->chat_id = $updates['message']['chat']['id'];
	}

	public function validateUrl(){
		if(filter_var($this->message, FILTER_VALIDATE_URL)){
			$url = parse_url($this->message);

			if($url['host'] == 'www.instagram.com' || $url['host'] == 'instagram.com'){
				return true;
			}
		}

		return false;
	}	


	public function message(){
		$instagram = new InstagramController;

		if($this->validateUrl()){
			$message = $instagram->save($this->message, $this->user_id);

			if($message){
				$text = "$message has been saved!🔥🔥🔥🔥🔥🔥🔥🔥🔥";
			} else {
				$text = 'This post is private or doesnt exists';
			}

			return $text;

		} 

		if($this->message == 'My saved posts 💾'){
			$posts = new PostsController;
			$url = $posts->createUrl($this->user_id);

			$text = "You can find your saved posts on the following link: $url";

			return $text;
		}
		
	}

    public function reply(){
    	$message = $this->message();

    	if($message){
    		$params = [
				'chat_id' => $this->chat_id,
				'text' => $message
			];

	    	return Telegram::sendMessage($params);	
    	}
    }
}
