<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        if(! auth()->check()){
            return view('welcome');
        }
        $user_id = auth()->user()->id;
        // USER YANG BELUM DIFOLLOW START
        $user = User::find($user_id);
        $users = User::whereNot('id', $user_id)
                    ->whereNotIn('id', function ($query) use ($user_id){
                    $query->select('followings.following_id')
                        ->from('followings')
                        ->where('followings.user_id', $user_id);
                })->get();
        // USER YANG BELUM DIFOLLOW END

        // USER YANG SUDAH DIFOLLOW START
        $followings = $user->followings()->get();
        // USER YANG SUDAH DIFOLLOW END

        // POSTINGAN USER YANG SUDAH DIFOLLOW START
        $following_posts_id = $user->followings()->pluck('users.id');
        $posts = Post::whereIn('user_id', $following_posts_id)->latest()->get();
        // POSTINGAN USER YANG SUDAH DIFOLLOW END

        return view('home', [
            'users' => $users,
            'followings'=>$followings,
            'posts'=>$posts
        ]);
    }
    public function follow($id){
        DB::beginTransaction();
        try{
            $followers = User::find(auth()->user()->id);
            $following = User::find($id);
            $followers->followings()->attach($following);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back();
        }
    }
    public function deleteFollower($id){
        $user = auth()->user();
        $user->followers()->detach($id);
        return redirect()->back();
    }
    public function unfollow($id){
        $user = auth()->user();
        $user->followings()->detach($id);
        return redirect()->back();
    }
    public function like($id){
        $user = User::find(auth()->user()->id);
        $post = Post::find($id);
        \DB::beginTransaction();
        if(in_array($user->id, $post->likers->pluck('id')->toArray())){
            $user->likedPosts()->detach($id); //unliked
            \DB::commit();
            return response()->json([
                'likes'=>$post->likers->count()-1
            ]);
        }else{
            $user->likedPosts()->attach($id); //liked
            \DB::commit();
            return response()->json([
                'likes'=>$post->likers->count()+1
            ]);
        }
    }
    public function comment(Request $request, $id){
        $user = User::find(auth()->user()->id);
        \DB::beginTransaction();
        try{
            $request->validate([
                'comment'=> 'required'
            ]);
            Comment::create([
                'user_id'=>$user->id,
                'post_id'=>$id,
                'comment'=>$request->comment
            ]);
            DB::commit();
        }catch(\Exception $e){
            \DB::rollBack();
        }
        return redirect()->back();
    }
    public function uncomment($id){
        Comment::destroy($id);
        return redirect()->back();
    }
}
