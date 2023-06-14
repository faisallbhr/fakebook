<?php

namespace App\View\Components;

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
        ]);
    }
}
