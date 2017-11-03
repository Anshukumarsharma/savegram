@extends('layout.master')

@section('main-content')
  <div class="container ">
    @foreach($posts_arr as $row)
      <div class="grid">

        @foreach($row as $post)

          <a href="{{$path . $post['post_id']}}" class="grid-item">
            <div class="type-icon {{ $post['type'] }}"></div>

            <img src="{{ $post['display'] }}">
          </a>

        @endforeach

      </div>
    @endforeach
  </div>
@endsection