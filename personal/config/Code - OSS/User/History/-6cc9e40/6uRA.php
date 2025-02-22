<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\CleanTemporaryImages;
use Illuminate\Console\Scheduling\Schedule;



Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



// Programar la limpieza diaria
app(Schedule::class)->command('clean:temporary-images')->daily();