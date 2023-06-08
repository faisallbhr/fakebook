<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        if(! auth()->check()){
            return view('welcome');
        }
        $users = User::whereNot('id', auth()->user()->id)
                    ->doesntHave('follows')->get();
        return view('home', [
            'users' => $users
        ]);
    }
    public function follow($id){
        // $user = User::find(auth()->user()->id);
        $user = User::where('id', $id)->get();
        DB::beginTransaction();
        try{
            $following = Follow::create(['name'=>$user[0]->name]);
            $following->users()->attach($id);
            DB::commit();
            return redirect()->back()->with('success', 'berhasil follow');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
