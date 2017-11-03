<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Posts;
use Uuid;
use Telegram;
use GuzzleHttp\Exception\ClientException;


class InstagramController extends Controller
{	
	public function saveDB($user_id, $post_id, $type){
		$post = new Posts; 
		$post->user_id = $user_id;
		$post->post_id = $post_id;
		$post->type = $type;
		$post->save();
	}

	public function createPath($type, $post_id, $display_url){
		$path = "/app/public/posts/$type/$post_id";

		mkdir(storage_path($path), 0700);		
		file_put_contents(storage_path("$path/display.jpg"), fopen($display_url, 'r'));
	}



	public function getPost($url){
		function parseObj($content){
			$start = preg_quote('<script type="text/javascript">', '/');
			$end = preg_quote('</script>', '/');

			preg_match("/$start(.*?)$end/", $content, $matches);

			$remove = ['window._sharedData = ', ';'];
			$obj = $matches[1];

			foreach ($remove as $k => $v) {
				$obj = str_replace($v, "", $obj);	
			}

			return json_decode($obj, true)['entry_data'];
		}

		$headers = [
    		
	    ];

	    $client = new Client([
    		'headers' => $headers,
    		'cookies' => new \GuzzleHttp\Cookie\CookieJar
    	]);

	    try {
		    $response = $client->request('GET', $url);
		    $obj = parseObj((String) $response->getBody());
		    return $obj;

		} catch (ClientException $e) {
		    return null;
		}
	}

	public function image($obj, $user_id){
		$type = 'image';
		$display_url = $obj['display_url'];	
		$post_id = Uuid::generate();
		
		$this->createPath($type, $post_id, $display_url);
		$this->saveDB($user_id, $post_id, $type);

		return $type;
	}

	public function video($obj, $user_id){
		$type = 'video';
		$display_url = $obj['display_url'];	
		$video_url = $obj['video_url'];
		$post_id = Uuid::generate();
		
		$this->createPath($type, $post_id, $display_url);
		file_put_contents(storage_path("/app/public/posts/$type/$post_id/video.mp4"), file_get_contents($video_url, 'r'));
		$this->saveDB($user_id, $post_id, $type);

		return $type;
	}

	public function carousel($obj, $user_id){
		$type = 'carousel';
		$display_url = $obj['display_url'];	
		$carousel_images = $obj['edge_sidecar_to_children']['edges'];
		$post_id = Uuid::generate();
		
		$this->createPath($type, $post_id, $display_url);

		$x = 1;

		foreach ($carousel_images as $k => $v) {
			file_put_contents(storage_path("/app/public/posts/$type/$post_id/$x.jpg"), fopen($v['node']['display_url'], 'r'));

			$x++;
		}

		$this->saveDB($user_id, $post_id, $type);

		return $type;
	}


	public function save($url, $user_id){		
		$obj = $this->getPost($url);

		if($obj){
			$obj = $obj['PostPage'][0]['graphql']['shortcode_media'];	

			$types = [
				'image' => 'GraphImage', 
				'video' => 'GraphVideo', 
				'carousel' => 'GraphSidecar'
			];

			foreach($types as $k => $v){
				if($obj['__typename'] == $v){
					return $this->$k($obj, $user_id);
				}
			}
		}

		return null;
	}
}
