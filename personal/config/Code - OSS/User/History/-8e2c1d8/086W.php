<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class CkeditorController extends Controller
{
    public function upload(Request $request)
    {
        // Validación de la imagen cargada
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        try {
            // Obtener la imagen cargada
            $file = $request->file('upload');

            // Almacenar la imagen en la carpeta 'ckeditor' dentro del almacenamiento público
            $path = $file->store('ckeditor', 'public');

            // Crear una nueva instancia de Product (o el modelo que desees) y asignar la imagen a la media library
            $product = new Product(); // O cargar un producto existente si es necesario
            $media = $product->addMedia(storage_path('app/public/' . $path))
                             ->toMediaCollection('images', 'public');

            // Devolver la URL de la imagen para que CKEditor la utilice
            return response()->json([
                'url' => Storage::url($media->getPath())
            ]);
        } catch (\Exception $e) {
            // Manejar error si no se puede cargar el archivo
            return response()->json([
                'error' => 'Could not upload file: ' . $e->getMessage()
            ], 500);
        }
    }
}
