<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class CkeditorController extends Controller
{
    public function upload(Request $request)
    {
        // Validación de la imagen
        $data = $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Obtener la imagen subida
        $image = $request->file('upload');

        // Generar un nombre único para la imagen
        $imageName = hexdec(uniqid()) . '.webp';

        // Usar Intervention Image para redimensionar la imagen
        $imagePath = storage_path('app/public/images/' . $imageName);

        // Redimensionar la imagen (ajustar tamaño si es necesario)
        Image::make($image)
            ->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->encode('webp', 90)  // Convertir a formato WebP con calidad 90
            ->save($imagePath);

        // Guardar la URL de la imagen procesada
        $path = 'images/' . $imageName;

        return [
            'url' => Storage::url($path)
        ];
    }
}
