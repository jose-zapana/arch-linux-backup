<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;

class CleanTemporaryImages extends Command
{
    protected $signature = 'clean:temporary-images';
    protected $description = 'Elimina imágenes temporales no asociadas a ningún post y limpia carpetas vacías';

    public function handle()
    {
        $this->info('Iniciando la limpieza de imágenes temporales...');

        // Eliminar imágenes temporales
        $temporaryMedia = Media::where('model_type', Post::class)
                               ->where('model_id', 0)
                               ->where('custom_properties->temp', true)
                               ->where('created_at', '<', now()->subHours(1))
                               ->get();

        foreach ($temporaryMedia as $media) {
            $media->delete();
        }

        $this->info('Imágenes temporales eliminadas.');

        // Eliminar carpetas vacías residuales
        $mediaRoot = storage_path('app/media');
        $this->deleteEmptyDirectories($mediaRoot);

        $this->info('Carpetas vacías eliminadas.');
    }

    private function deleteEmptyDirectories($path)
    {
        $directories = array_filter(glob($path . '/*'), 'is_dir');

        foreach ($directories as $directory) {
            $this->deleteEmptyDirectories($directory); // Elimina subdirectorios

            if (count(glob($directory . '/*')) === 0) {
                rmdir($directory); // Elimina el directorio vacío
            }
        }
    }
}
