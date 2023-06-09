<?php

namespace App\Http\Controllers;

use App\Models\Following;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        if(! auth()->check()){
            return view('welcome');
        }
        $users = User::whereNot('id', auth()->user()->id)
                    ->whereDoesntHave('followings', function ($query){
                        $query->where('following_id', auth()->user()->id);
                    })->get();
        $followers = User::whereNot('id', auth()->user()->id)
                    ->whereHas('followers', function ($query){
                        $query->where('user_id', auth()->user()->id);
                    })->get();
                    
        return view('home', [
            'users' => $users,
            'followers'=>$followers
        ]);
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
}
