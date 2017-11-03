@extends('layout.master')

@section('main-content')
  <div class="container cn-small">
    @if($content['type'] == 'image')        
       <img src="{{ $content['img_url'] }}">
    @endif

    @if($content['type'] == 'carousel')
    <div class="my-slider">
       <ul>
          @foreach($content['img_urls'] as $img)
          <li><img src="{{ $img }}"></li>
          @endforeach
       </ul>
    </div>
    @endif

    @if($content['type'] == 'video')        
    <div class="video-wrapper">
       <video width="100%"  controls>
          <source src="{{ $content['video_url'] }}" type="video/mp4"></source>
       </video>
       <div class="video-controls">
          <button data-media="play-pause"></button>
          <button data-media="mute-unmute"></button>
       </div>
    </div>
    @endif
  </div>
@endsection