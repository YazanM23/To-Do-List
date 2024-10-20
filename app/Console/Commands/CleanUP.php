<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;
use App\Models\Tasks;
use Illuminate\Console\Command;

class CleanUP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-u-p';

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
        $date = \Carbon\Carbon::now()->subDays(60);
        $tasks = Tasks::where('updated_at', '<', $date)->where('status', 'Pending')->get();

        foreach ($tasks as $task) {
            $task->delete();
        }
    }
}
