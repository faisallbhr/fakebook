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
            ]);
            $validatedData['user_id'] = auth()->user()->id;
            $validatedData['photo'] = $request->file('photo')->store('post-photo');
            Post::create($validatedData);
            \DB::commit();
            return redirect()->back()->with('success', 'Berhasil membuat postingan');
        }catch(\Exception $e){
            \DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat postingan, sesuaikan format anda');
        }
    }
    public function update(Request $request, $id){
        \DB::beginTransaction();
        try{
            $validatedData = $request->validate([
                'description'=>'required|max:255',
                'photo'=> 'image'
            ]);
            $validatedData['user_id'] = auth()->user()->id;
            if($request->hasFile('photo')){
                $validatedData['photo'] = $request->file('photo')->store('post-photo');
            }
            Post::where('id', $id)->update($validatedData);
            \DB::commit();
            return redirect()->back();
        }catch(\Exception $e){
            \DB::rollBack();
            return redirect()->back();
        }
    }
    public function destroy($id){
        Post::destroy($id);
        return redirect()->back();
    }
}
