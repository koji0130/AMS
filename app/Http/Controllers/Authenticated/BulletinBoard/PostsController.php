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
use App\Http\Requests\CreateMainCategoryRequest;
use App\Http\Requests\CreateSubCategoryRequest;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\PostEditRequest;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
        // $likes_count = Post::withCount('likes')->get();
        if(!empty($request->keyword)){
            $keyword = $request->keyword;
            $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%'.$keyword.'%')
            ->orWhere('post', 'like', '%'.$keyword.'%')
            ->orWhereHas('subCategories',function($q) use ($keyword){
                $q->where('sub_categories.sub_category',$keyword);
            })->get();
        }else if($request->category_word){
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments','subCategories')
            ->whereHas('subCategories',function($q) use ($sub_category){
                $q->where('sub_categories.sub_category',$sub_category);
            })->get();
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }

        return view('authenticated.bulletinboard.posts', compact('posts', 'categories' ,'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        \Debugbar::info($post);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    public function postCreate(PostFormRequest $request){
        $sub_category = $request->post_category_id;
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        //中間テーブルである、post_sub_categoriesにattach
        $posts = Post::findOrFail($post->id);
        $posts->subCategories()->attach($sub_category);
        return redirect()->route('post.show');
    }

    public function postEdit(PostEditRequest $request){
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
    public function mainCategoryCreate(CreateMainCategoryRequest $request){
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    // 下記追加
    public function subCategoryCreate(CreateSubCategoryRequest $request){
        $id = $request->input('main_category_id');
        $subCategory = $request->input('sub_category_name');

        SubCategory::create([
            'main_category_id' => $id,
            'sub_category' => $subCategory,
        ]);
        return redirect()->route('post.input');
    }

    public function commentCreate(CreateCommentRequest $request){
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
        // Auth::user()->likes()->attach($request->post_id);
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;
        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();
        return response()->json();
    }

    public function postUnLike(Request $request){
        // Auth::user()->likes()->detach($request->post_id);
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;
        $like->where('like_user_id', $user_id)->where('like_post_id', $post_id)->delete();
        return response()->json();
    }
}
