<?php

namespace App\Http\Controllers;

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
}
