<?php

namespace App\Console\Commands;

use App\Http\Controllers\ArchiveController;
use Illuminate\Console\Command;
use App\Models\Archive;
use App\Models\Tasks;


class ArchiveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:archive';

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
        $date = \Carbon\Carbon::now()->subDays(30)->format('Y-m-d');
        $tasks = Tasks::where('updated_at', '<', $date)->where('status', 'Completed')->get();
        foreach ($tasks as $task) {
            $archive = new Archive;
            $archive->user_id = $task->user_id;
            $archive->title = $task->title;
            $archive->description = $task->description;
            $archive->status = $task->status;
            $archive->deadline = $task->deadline;
            $archive->save();
            $task->delete();
        }
    }
}
