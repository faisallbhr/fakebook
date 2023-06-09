<?php

namespace App\Http\Controllers;

use App\Models\Following;
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
        // USER YANG BELUM DIFOLLOW START
        $users = User::whereNot('id', auth()->user()->id)
                    ->whereDoesntHave('followings', function ($query){
                        $query->where('following_id', auth()->user()->id);
                    })->get();
        // USER YANG BELUM DIFOLLOW END

        // USER YANG SUDAH DIFOLLOW START
        $followings = User::whereNot('id', auth()->user()->id)
                        ->whereHas('followings', function ($query){
                            $query->where('following_id', auth()->user()->id);
                        })->get();
        // USER YANG SUDAH DIFOLLOW END
                
        // POSTINGAN USER YANG SUDAH DIFOLLOW START
        $following_posts_id = User::whereHas('followings', function ($query){
            $query->where('following_id', auth()->user()->id);
        })->pluck('id');

        $posts = Post::whereIn('user_id', $following_posts_id)->latest()->get();
        // POSTINGAN USER YANG SUDAH DIFOLLOW END

        return view('home', [
            'users' => $users,
            'followings'=>$followings,
            'posts'=>$posts
        ]);
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'description'=>'required|max:255'
        ],[
            'description.required'=> 'Bidang deskripsi harus diisi',
            'description.max'=> 'Bidang deskripsi tidak boleh lebih dari 255 karakter',
        ]);
        \DB::beginTransaction();
        try{
            $validatedData['user_id'] = auth()->user()->id;
            Post::create($validatedData);
            \DB::commit();
            return redirect()->back()->with('success', 'Berhasil membuat postingan');
        }catch(\Exception $e){
            \DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function follow($id){
        $user = User::find($id);
        DB::beginTransaction();
        try{
            $followers = User::find(auth()->user()->id);
            $following = User::find($id);
            $followers->followings()->attach($following);
            DB::commit();
            return redirect()->back()->with('success', 'berhasil follow');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function indexProfile(){
        return view('my-profile.index');
    }
}
