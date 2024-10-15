<?php

namespace App\Console\Commands;

use App\Models\Tasks;
use App\Models\Reminders;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class removeReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-reminder';

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
        //
        $date = \Carbon\Carbon::now()->subDay()->format('Y-m-d');

        $tasks = Tasks::where('deadline', $date)->get();

        foreach ($tasks as $task) {
            $reminder = Reminders::where('task_id', $task->id)->first();

            if ($reminder) {
                $reminder->delete();
            }
        }
    }
}
