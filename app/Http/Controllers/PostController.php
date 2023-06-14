<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $user = User::find(auth()->user()->id);
        $followers = $user->followers()->get();
        $followings = $user->followings()->get();
        $posts = Post::where('user_id', auth()->user()->id)->latest()->get();

        // USER YANG BELUM DIFOLLOW START
        $users = User::whereNot('id', $user->id)
                    ->whereNotIn('id', function ($query) use ($user){
                    $query->select('followings.following_id')
                        ->from('followings')
                        ->where('followings.user_id', $user->id);
                })->get();
        // USER YANG BELUM DIFOLLOW END
        
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
            if($request->file('photo')){
                $validatedData['photo'] = $request->file('photo')->store('post-photo');
            }
            Post::create($validatedData);
            \DB::commit();
            return redirect()->back()->with('success', 'Berhasil membuat postingan');
        }catch(\Exception $e){
            \DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat postingan, sesuaikan format anda');
        }
    }
    public function show($id){
        $user = User::find(auth()->user()->id);
        $post = Post::find($id);

        // hanya bisa melihat post user yang sudah difollow
        if(in_array($post->user_id, $user->followings()->pluck('users.id')->toArray()) || $post->user_id == $user->id){
            $users = User::whereNot('id', $user->id)
            ->whereNotIn('id', function ($query) use ($user){
                $query->select('followings.following_id')
                ->from('followings')
                ->where('followings.user_id', $user->id);
            })->get();
            $followings = $user->followings()->get();
            
            return view('show', [
                'post'=>$post,
                'users'=>$users,
                'followings'=>$followings
            ]);
        }else{
            abort(403);
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
        return redirect('my-profile');
    }
}
