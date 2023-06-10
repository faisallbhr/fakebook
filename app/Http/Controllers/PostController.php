<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $user = User::find(auth()->user()->id);
        $followings = $user->followings()->count();
        $followers =\DB::table('followings')->from('followings')->where('following_id', auth()->user()->id)->count();
        $posts = Post::where('user_id', auth()->user()->id)->latest()->get();
        
        return view('my-profile.index', [
            'user' => $user,
            'followers'=>$followers,
            'followings'=>$followings,
            'posts'=>$posts
        ]);
    }
    public function store(Request $request){
        \DB::beginTransaction();
        try{
            $validatedData = $request->validate([
                'description'=>'required|max:255',
                'photo'=> 'image'
            ],[
                'description.required'=> 'Bidang deskripsi harus diisi',
                'description.max'=> 'Bidang deskripsi tidak boleh lebih dari 255 karakter',
            ]);
            $validatedData['user_id'] = auth()->user()->id;
            $validatedData['photo'] = $request->file('photo')->store('post-photo');
            Post::create($validatedData);
            \DB::commit();
            return redirect('/')->with('success', 'Berhasil membuat postingan');
        }catch(\Exception $e){
            \DB::rollBack();
            return redirect('/')->with('error', 'Gagal membuat postingan, sesuaikan format anda');
        }
    }
}
