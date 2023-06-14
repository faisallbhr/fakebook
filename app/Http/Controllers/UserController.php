<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewLikeNotification;
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
        DB::beginTransaction();
        if(in_array($user->id, $post->likers->pluck('id')->toArray())){
            $user->likedPosts()->detach($id); //unliked
            Notification::where('type', 'like')->where('user_id', $user->id)->where('post_id', $id)->delete();
            DB::commit();
            return response()->json([
                'likes'=>$post->likers->count()-1,
            ]);
        }else{
            $user->likedPosts()->attach($id); //liked
            Notification::create([
                'type'=>'like',
                'user_id'=>$user->id,
                'post_id'=>$id,
                'url'=>'posts/'.$id,
                'data'=>$user->name." telah menyukai postingan anda."
            ]);
            DB::commit();
            return response()->json([
                'likes'=>$post->likers->count()+1,
            ]);
        }
    }
    public function comment(Request $request, $id){
        $user = User::find(auth()->user()->id);
        DB::beginTransaction();
        try{
            $request->validate([
                'comment'=> 'required'
            ]);
            Comment::create([
                'user_id'=>$user->id,
                'post_id'=>$id,
                'comment'=>$request->comment
            ]);
            Notification::create([
                'type'=>'comment',
                'user_id'=>$user->id,
                'post_id'=>$id,
                'url'=>'posts/'.$id,
                'data'=>$user->name." telah mengomentari postingan anda."
            ]);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
        }
        return redirect()->back();
    }
    public function uncomment(Request $request, $id){
        DB::beginTransaction();
        try{
            Comment::destroy($id);
            Notification::where('type', 'comment')->where('user_id', auth()->user()->id)->where('post_id', $request->post_id)->delete();
            DB::commit();
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }
    public function notifications($id){
        $user = User::find($id);
        $posts_id = $user->posts()->pluck('id');
        Notification::whereIn('post_id', $posts_id)->update(['read_at'=>now()]);
        return response()->json([
            'not_read' => 0
        ]);
    }
}
