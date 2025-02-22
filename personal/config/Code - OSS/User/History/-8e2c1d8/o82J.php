<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CkeditorController extends Controller
{
    public function upload(Request $request){

        //images/nombre_del_archivo.extension
        $path = Storage::put('images', $request->file('upload'));

        return [
            'url' => Storage::url($path)
        ];

    }
}
