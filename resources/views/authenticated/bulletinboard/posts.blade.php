@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p>
        <span>{{ $post->user->over_name }}</span>
        <span class="ml-3">{{ $post->user->under_name }}</span>さん
        <span class="post-date">{{ $post->created_at }}</span>
      </p>
      <p>
        <a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a>
      </p>
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="">{{ $post->postComments->count() }}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            <!-- iクラスはハート本体、like_countsは数字、post_id,class(JSで使う)は投稿の区別の命名 -->
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @endif
          </div>
        </div>
      </div>
      @foreach($post->subCategories as $category)
      <span class="category_btn sub_category_btn">{{ $category->sub_category }}</span>
      @endforeach
    </div>
    @endforeach
  </div>
  <div class="other_area border w-25">
    <div class="border m-4">
      <div class="new_post"><a href="{{ route('post.input') }}">投稿</a></div>
      <input type="text" placeholder="キーワードを入力" name="keyword" form="postSearchRequest">
      <input type="submit" value="検索" form="postSearchRequest">
      <div class="button_area">
        <input type="submit" name="like_posts" class="category_btn like_post" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="category_btn my_post" value="自分の投稿" form="postSearchRequest">
      </div>
      <ul>
        @foreach($categories as $category)
        <li class="main_categories" category_id="{{ $category->id }}">
          <span class="slide-button slide_num{{ $category->id }}"></span>
          <span>{{ $category->main_category }}</span>
        </li>
        @foreach($category->subCategories as $sub_category)
        <p class="sub_categories category_num{{ $sub_category->main_category_id }}">
          <input type="submit" class="sub_categories_name" name="category_word" value="{{ $sub_category->sub_category }}" form="postSearchRequest">
        </p>
        @endforeach
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection
