<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $user = User::find(auth()->user()->id);
        $followers =\DB::table('followings')->from('followings')->where('following_id', auth()->user()->id)->count();
        $posts = Post::where('user_id', auth()->user()->id)->latest()->get();

        // USER YANG BELUM DIFOLLOW START
        $users = User::whereNot('id', $user->id)
                    ->whereNotIn('id', function ($query) use ($user){
                    $query->select('followings.following_id')
                        ->from('followings')
                        ->where('followings.user_id', $user->id);
                })->get();
        // USER YANG BELUM DIFOLLOW END
        
        // USER YANG SUDAH DIFOLLOW START
        $followings = $user->followings()->get();
        // USER YANG SUDAH DIFOLLOW END
        
        return view('my-profile.index', [
            'users'=>$users,
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
    public function like($id){
        $user = User::find(auth()->user()->id);
        $user->likedPosts()->attach($id);
        return redirect()->back();
    }
}
