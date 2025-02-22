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
        $excludedPaths = [
            storage_path('framework'),
            storage_path('framework/views'),
            storage_path('framework/cache'),
            storage_path('logs'),
        ];
    
        if (in_array($path, $excludedPaths)) {
            return; // No eliminar directorios críticos
        }
    
        $directories = array_filter(glob($path . '/*'), 'is_dir');
        $files = array_filter(glob($path . '/*'), 'is_file');
        
        // Elimina todos los archivos en el directorio
        foreach ($files as $file) {
            unlink($file);
        }
    
        // Recurre sobre los subdirectorios
        foreach ($directories as $directory) {
            $this->deleteEmptyDirectories($directory);
    
            // Si el directorio está vacío después de limpiar, elimínalo
            if (count(glob($directory . '/*')) === 0) {
                rmdir($directory);
            }
        }
    }
}
