<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\ExampleCommand;
use App\Console\Commands\CleanUP;
use App\Console\Commands\ArchiveCommand;
use App\Console\Commands\Reminder;
use App\Console\Commands\removeReminder;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



Schedule::command(CleanUp::class)->daily();
Schedule::command(ArchiveCommand::class)->daily();
Schedule::command(Reminder::class)->daily();
Schedule::command(removeReminder::class)->daily();
