<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\CleanTempImages;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::starting(function () {
    Artisan::resolve(CleanTempImages::class);
});

// Programar la tarea
app(Schedule::class)->command('clean:temporary-images')->hourly();