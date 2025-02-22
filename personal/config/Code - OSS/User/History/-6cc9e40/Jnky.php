<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\CleanTempImages;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::starting(function () {
    Artisan::resolve(CleanTempImages::class);
});

// Programar la tarea
app(Schedule::class)->command('clean:temporary-images')->hourly();

// Definir tareas programadas
app(Schedule::class)->call(function () {
    // Obtener todos los archivos en la carpeta 'media'
    $files = Storage::files('media');

    // Obtener las rutas de los archivos asociados en la tabla MediaLibrary
    $mediaFiles = Media::pluck('file_name')->toArray();

    // Filtrar los archivos no asociados
    $unlinkedFiles = array_diff($files, $mediaFiles);

    // Eliminar los archivos no asociados
    Storage::delete($unlinkedFiles);

    // Opcional: registrar un log para depuración
    info('Archivos no vinculados eliminados:', $unlinkedFiles);
})->daily(); // Programar la tarea para ejecutarse diariamente