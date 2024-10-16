<?php

namespace App\Console\Commands;

use App\Models\Tasks;
use App\Models\Reminders;
use Illuminate\Support\Facades\Log;

use Illuminate\Console\Command;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $date = \Carbon\Carbon::now()->addDay()->format('Y-m-d');
        $tasks = Tasks::where('deadline', $date)->where('status', 'Pending')->get();

        foreach ($tasks as $task) {
            $reminder = new Reminders;
            $reminder->task_id = $task->id;
            $reminder->user_id = $task->user_id;
            $reminder->save();
        }
    }
}
