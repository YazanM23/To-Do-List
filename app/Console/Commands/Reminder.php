<?php

namespace App\Console\Commands;

use App\Models\Tasks;
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
        //
        $date = \Carbon\Carbon::now()->subDays(1)->format('Y-m-d');

        $tasks = Tasks::where('deadline', $date);
        foreach ($tasks as $task) {
            $this->info("Reminder: {$task->title} is due today");
        }
    }
}