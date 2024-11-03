<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CreateTask;
use App\Models\Userlog; // Ensure this path is correct based on your project structure
use Illuminate\Support\Facades\Auth;

class Listener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        $action = class_basename($event);
        $log = new Userlog();
        $log->user_id = Auth::user()->id;
        $log->action_type = $action;
        $log->save();
    }
}
