<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanPosts extends Command
{
    /**
     * El nombre y la firma del comando.
     *
     * @var string
     */
    protected $signature = 'posts:clean'; // Esta es la forma de llamar el comando desde la consola

    /**
     * La descripción del comando.
     *
     * @var string
     */
    protected $description = 'Eliminar todos los archivos en el directorio posts';

    /**
     * Crear una nueva instancia del comando.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ejecutar el comando.
     *
     * @return void
     */
    public function handle()
    {
        // Obtener todos los archivos dentro del directorio 'posts'
        $files = Storage::files('posts');

        // Eliminar todos los archivos en el directorio 'posts'
        Storage::delete($files);

        // Mensaje de éxito
        $this->info('Archivos en el directorio posts eliminados.');
    }
}
