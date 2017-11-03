<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Urls;
use App\Posts;
use Carbon\Carbon;
use Uuid;

class PostsController extends Controller
{
    public function createUrl($user_id){
    	$url = new Urls; 
		$uuid = Uuid::generate();

		$url->uuid = $uuid;
		$url->user_id = $user_id;
		$url->save();

		$url = env('APP_URL') . "/$user_id/$uuid";

		return $url;
    }

    public function posts($user_id, $uuid){
    	$posts = Posts::where('user_id', $user_id)->orderBy('id', 'desc')->get()->toArray();
        $path = "/$user_id/$uuid/";

        $posts_arr = [];

        foreach ($posts as $k => $v) {
            $type = $v['type'];
            $post_id = $v['post_id'];

            $posts_arr[] = [
                'type' => $type,
                'post_id' => $post_id,
                'display' => "/storage/posts/$type/$post_id/display.jpg"
            ];
        }

        $posts_arr = array_chunk($posts_arr, 3);

        return view('posts', compact('posts_arr', 'path'));
    }


    public function image($user_id, $uuid, $post_id){
        $content = [
            'type' => 'image',
            'img_url' => "/storage/posts/image/$post_id/display.jpg"
        ];

        return $content;
    }

    public function video($user_id, $uuid, $post_id){
        $content = [
            'type' => 'video',
            'video_url' => "/storage/posts/video/$post_id/video.mp4"
        ];

        return $content;
    }

    public function carousel($user_id, $uuid, $post_id){
        $find_images = scandir(storage_path("app/public/posts/carousel/$post_id"));

        $images = [];

        foreach ($find_images as $k => $v) {
            if(preg_match('/jpg/', $v) && !preg_match('/display/', $v)){
                $images[] = "/storage/posts/carousel/$post_id/$v";
            }
        }

        $content = [
            'type' => 'carousel',
            'img_urls' => $images
        ];

        return $content;
    }

    public function post($user_id, $uuid, $post_id){
        $post = Posts::where('post_id', $post_id)->first();   

        $types = [
            'image', 
            'video',
            'carousel'
        ];

        foreach ($types as $type) {
            if($type == $post->type){
                $content = $this->$type($user_id, $uuid, $post_id);
            }
        }

        // var_dump($content);

        return view('post', compact('content'));
    }
}
