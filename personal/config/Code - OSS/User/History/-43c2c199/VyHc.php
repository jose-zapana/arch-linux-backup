<?php

namespace App\Console\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CleanTempImages extends Command
{
    protected $signature = 'clean:temporary-images';
    protected $description = 'Elimina imágenes temporales no asociadas a ningún post';

    public function handle()
    {
        $temporaryMedia = Media::where('model_type', Post::class)
                               ->where('model_id', 0)
                               ->where('custom_properties->temp', true)
                               ->where('created_at', '<', now()->subHours(1))
                               ->get();

        foreach ($temporaryMedia as $media) {
            $media->delete();
        }

        $this->info('Imágenes temporales eliminadas correctamente.');
    }
}
