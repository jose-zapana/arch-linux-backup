<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CkeditorController extends Controller
{
    public function upload(Request $request)
    {
        // Validación para asegurarse de que se haya subido un archivo
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Subir el archivo al almacenamiento público
        $file = $request->file('upload');

        // Almacena la imagen en la carpeta "images" dentro del almacenamiento
        $path = Storage::put('public/images', $file);

        // Opcional: puedes utilizar MediaLibrary para almacenar el archivo si necesitas una relación con un modelo
        // Aquí no estamos asociando a ningún modelo específico, simplemente utilizamos la base de datos de MediaLibrary para el almacenamiento

        // Crear un registro en la tabla de media sin asociar a un modelo
        $media = Media::create([
            'model_type' => 'App\Models\User', // Aquí usas un modelo si lo tienes. Para no usarlo puedes poner cualquier tipo de modelo o eliminar esta línea.
            'model_id' => 1, // Este es un campo que debes adaptar a tus necesidades
            'collection_name' => 'ckeditor', // Nombre de la colección
            'name' => $file->getClientOriginalName(),
            'file_name' => basename($path),
            'mime_type' => $file->getClientMimeType(),
            'disk' => 'public',
            'size' => $file->getSize(),
            'custom_properties' => [],
            'order_column' => 1
        ]);

        // Retorna la URL de la imagen cargada para CKEditor
        return response()->json([
            'url' => Storage::url('images/'.$media->file_name)
        ]);
    }
}
