<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class CkeditorController extends Controller
{
    public function upload(Request $request)
    {
        // Validar la imagen recibida
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Crear instancia de ImageManager para procesar la imagen
        $manager = new ImageManager();

        // Generar un nombre único para la imagen
        $imageName = hexdec(uniqid()) . '.webp';

        // Leer la imagen cargada
        $image = $manager->make($request->file('upload')->getRealPath());

        // Redimensionar la imagen si es necesario (opcional)
        $image->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        // Convertir la imagen a WebP y guardarla
        $image->encode('webp', 90); // Puedes ajustar la calidad aquí (0-100)

        // Guardar la imagen procesada en el almacenamiento
        $path = 'images/' . $imageName;
        $image->save(storage_path('app/public/' . $path));

        // Devolver la URL de la imagen cargada para usar en el CKEditor
        return [
            'url' => Storage::url($path),
        ];
    }
}
