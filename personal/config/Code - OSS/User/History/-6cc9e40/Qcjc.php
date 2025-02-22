<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\CleanPosts; // Asegúrate de que el nombre sea el correcto
use Illuminate\Console\Scheduling\Schedule;

// Comando 'inspire' para mostrar una cita inspiradora
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Programar la tarea para eliminar archivos temporales
Artisan::starting(function () {
    Artisan::call(CleanPosts::class); // Usamos CleanPosts aquí en lugar de CleanTempImages
});

// Programar la tarea para que se ejecute cada hora
app(Schedule::class)->command('posts:clean')->hourly(); // Asegúrate de que este comando esté registrado
