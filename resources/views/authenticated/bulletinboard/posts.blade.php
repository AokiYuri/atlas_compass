@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      @foreach($post->subCategories as $subCategory)
        <p class="category_btn">{{ $subCategory->sub_category }}</p>
      @endforeach
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i>
            <span class="comment_counts">{{ $post->commentCounts($post->id)->count() }}</span>
          </div>
          <div>
          @if(Auth::user()->is_Like($post->id))
          <p class="m-0">
            <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i>
            <span class="like_counts{{ $post->id }}">{{ $post->likes()->count() }}</span>
          </p>
          @else
          <p class="m-0">
            <i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i>
            <span class="like_counts{{ $post->id }}">{{ $post->likes()->count() }}</span>
          </p>
          @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="other_area border w-25">
    <div class="border m-4">
      <div class="post_btn"><a href="{{ route('post.input') }}">投稿</a></div>
      <div class="search_post">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" class="search_btn" value="検索" form="postSearchRequest">
      </div>
      <input type="submit" name="like_posts" class="category_btn_good" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="category_btn_mine" value="自分の投稿" form="postSearchRequest">
      <p class="search_form">カテゴリー検索</p>
        @foreach($categories as $category)
          <div class="category-header" onclick="toggleSubCategories(this)">
            <span>{{ $category->main_category }}</span>
            <span class="icon">▼</span>
          </div>
          <div class="sub-categories" style="display: none;">
            @foreach($category->subCategories as $subCategory)
              <input type="submit" name="categories_posts" value="{{ $subCategory->sub_category }}" form="postSearchRequest">
            @endforeach
          </div>
        @endforeach
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection
