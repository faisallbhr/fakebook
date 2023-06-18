<?php

namespace App\View\Components;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\View\View;
use App\Models\Notification;
use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $user = User::find(auth()->user()->id);
        $posts_id = $user->posts()->pluck('id');
        $notifications = Notification::whereIn('post_id', $posts_id)->latest()->get();
        $not_read = Notification::whereIn('post_id', $posts_id)->where('read_at', null)->count();

        return view('layouts.app', [
            'notifications'=>$notifications,
            'not_read'=>$not_read,
            'likes1'=> \DB::table('liked_post')->whereIn('post_id', $posts_id)->whereMonth('date', '1')->count('post_id'),
            'likes2'=> \DB::table('liked_post')->whereIn('post_id', $posts_id)->whereMonth('date', '2')->count('post_id'),
            'likes3'=> \DB::table('liked_post')->whereIn('post_id', $posts_id)->whereMonth('date', '3')->count('post_id'),
            'likes4'=> \DB::table('liked_post')->whereIn('post_id', $posts_id)->whereMonth('date', '4')->count('post_id'),
            'likes5'=> \DB::table('liked_post')->whereIn('post_id', $posts_id)->whereMonth('date', '5')->count('post_id'),
            'likes6'=> \DB::table('liked_post')->whereIn('post_id', $posts_id)->whereMonth('date', '6')->count('post_id'),
            'likes7'=> \DB::table('liked_post')->whereIn('post_id', $posts_id)->whereMonth('date', '7')->count('post_id'),
            'likes8'=> \DB::table('liked_post')->whereIn('post_id', $posts_id)->whereMonth('date', '8')->count('post_id'),
            'likes9'=> \DB::table('liked_post')->whereIn('post_id', $posts_id)->whereMonth('date', '9')->count('post_id'),
            'likes10'=> \DB::table('liked_post')->whereIn('post_id', $posts_id)->whereMonth('date', '10')->count('post_id'),
            'likes11'=> \DB::table('liked_post')->whereIn('post_id', $posts_id)->whereMonth('date', '11')->count('post_id'),
            'likes12'=> \DB::table('liked_post')->whereIn('post_id', $posts_id)->whereMonth('date', '12')->count('post_id'),
            'comments1'=>Comment::whereIn('post_id', $posts_id)->whereMonth('created_at', '1')->count(),
            'comments2'=>Comment::whereIn('post_id', $posts_id)->whereMonth('created_at', '2')->count(),
            'comments3'=>Comment::whereIn('post_id', $posts_id)->whereMonth('created_at', '3')->count(),
            'comments4'=>Comment::whereIn('post_id', $posts_id)->whereMonth('created_at', '4')->count(),
            'comments5'=>Comment::whereIn('post_id', $posts_id)->whereMonth('created_at', '5')->count(),
            'comments6'=>Comment::whereIn('post_id', $posts_id)->whereMonth('created_at', '6')->count(),
            'comments7'=>Comment::whereIn('post_id', $posts_id)->whereMonth('created_at', '7')->count(),
            'comments8'=>Comment::whereIn('post_id', $posts_id)->whereMonth('created_at', '8')->count(),
            'comments9'=>Comment::whereIn('post_id', $posts_id)->whereMonth('created_at', '9')->count(),
            'comments10'=>Comment::whereIn('post_id', $posts_id)->whereMonth('created_at', '10')->count(),
            'comments11'=>Comment::whereIn('post_id', $posts_id)->whereMonth('created_at', '11')->count(),
            'comments12'=>Comment::whereIn('post_id', $posts_id)->whereMonth('created_at', '12')->count(),
        ]);
    }
}
