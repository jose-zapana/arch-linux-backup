<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class CkeditorController extends Controller
{
    public function upload(Request $request)
    {
        // Validación de la imagen
        $data = $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Crear el manejador de imágenes con el driver deseado
        $manager = new ImageManager(new Driver());

        // Generar un nombre único para la imagen
        $imageName = hexdec(uniqid()) . '.webp';

        // Leer la imagen desde el sistema de archivos
        $image = $manager->read($request->file('upload'));

        // Redimensionar la imagen manteniendo la relación de aspecto
        $image = $image->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        // Convertir la imagen a WebP con calidad 90 y guardarla en el directorio correspondiente
        $image->toWebp(70)->save(storage_path('app/public/images/' . $imageName));

        // Guardar la ruta de la imagen procesada
        $save_url = 'images/' . $imageName;

        // Responder con la URL de la imagen
        return [
            'url' => Storage::url($save_url)
        ];
    }
}
