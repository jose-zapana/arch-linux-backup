<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CkeditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/uploads', $filename);

            $url = Storage::url($path);

            return response()->json([
                'url' => $url
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
