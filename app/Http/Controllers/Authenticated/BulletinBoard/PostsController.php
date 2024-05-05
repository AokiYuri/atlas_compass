<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
        if(!empty($request->keyword)){
            $keyword = $request->keyword;
            $posts = Post::with('user', 'postComments', 'subCategories')
            ->where(function ($query) use ($keyword) {
            $query->where('post_title', 'like', '%'.$keyword.'%')
              ->orWhere('post', 'like', '%'.$keyword.'%');
            })
            ->orWhereHas('subCategories', function ($q) use ($keyword) {
                $q->where('sub_category', 'like', '%' . $keyword . '%');
            })->get();
        }else if($request->category_word){
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')->get();
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }else if($request->categories_posts){
            $keyword = $request->keyword;
            // dd($request);
            $categories_posts = $request->categories_posts;
            // dd($categories_posts);
            $posts = Post::with('user', 'postComments')
            ->whereHas('subCategories', function($q) use ($categories_posts,$keyword){
              $q->where('sub_categories.sub_category', $categories_posts);
            }) ->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::get();
        $sub_categories = SubCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories','sub_categories'));
    }

    public function postCreate(PostFormRequest $request){
        //dd($request->sub_category_id);
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        // サブカテゴリーの ID を取得
        $subCategoryId = $request->sub_category_id;
        // ポストとサブカテゴリーの中間テーブルに保存
        $post->subCategories()->attach($subCategoryId);
        return redirect()->route('post.show');
    }

    public function postEdit(Request $request){
        $messages = [
            'post_title.required' => 'タイトルは入力必須です。',
            'post_title.max' => 'タイトルは100文字以内で入力してください。',
            'post_body.required' => '投稿内容は入力必須です。',
            'post_body.max' => '最大文字数は5000文字です。',
        ];
        $request->validate([
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
        ], $messages);
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    public function mainCategoryCreate(Request $request){
        $messages = [
            'main_category_name.required' => 'メインカテゴリ名は必須項目です。',
            'main_category_name.max' => 'メインカテゴリ名は100文字以内で入力してください。',
            'main_category_name.unique' => '指定されたメインカテゴリ名は既に存在しています。',
        ];
        $request->validate([
            'main_category_name' => 'required|string|max:100|unique:main_categories,main_category',
        ], $messages);
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    public function subCategoryCreate(Request $request){
        $messages = [
            'sub_category_name.required' => 'サブカテゴリ名は必須項目です。',
            'sub_category_name.max' => 'サブカテゴリ名は100文字以内で入力してくだ さい。',
            'sub_category_name.unique' => '指定されたサブカテゴリ名は既に存在しています。',
        ];
        $request->validate([
            'sub_category_name' => 'required|string|max:100|unique:sub_categories,sub_category',
        ], $messages);
        SubCategory::create([
            'sub_category' => $request->sub_category_name,
            'main_category_id' => $request->main_category_id,
        ]);
        return redirect()->route('post.input');
    }

    public function commentCreate(Request $request){
        $messages = [
            'comment.required' => 'コメントは必須項目です。',
            'comment.max' => 'コメントは2500文字以内で入力してください。',
        ];

        $request->validate([
            'comment' => 'required|string|max:2500',
        ], $messages);
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
