<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class CoverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $covers = Cover::orderBy('order')->get();
        return view('admin.covers.index', compact('covers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return view('admin.covers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|max:255|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:star_at',
            'is_active' => 'required|boolean',
        ]);

        //$image = $request->file('image');

        // create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read($request->file('image'));

        $image->scaleDown(width: 200);

        Storage::put('covers/'.$image->basename.'.webp', (string) $image->encoded);

        $data['image_path'] = 'covers/'.$image->basename.'.webp';

        $data['order'] = Cover::max('order') + 1;

        dd($data);



        

        //$imageName = Str::random().'.webp';

        //$images = $image-> storeAs('covers', $imageName);

        //$data['image'] = $images;
        //$data['image_path'] = Storage::put('covers', $image);
        $cover = Cover::create($data);    

        Cache::flush();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Portada Creada',
            'text' => 'La portada se ha creado correctamente',
        ]);

        return redirect()->route('admin.covers.edit', $cover);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cover $cover)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cover $cover)
    {
        return view('admin.covers.edit', compact('cover'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cover $cover)
    {
        $data = $request->validate([
            'image' => 'nullable|image|max:1024',
            'title' => 'required|max:255|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:star_at',
            'is_active' => 'required|boolean',
        ]);

        if (isset($data['image'])) {
            Storage::delete($cover->image_path);
            $data['image_path'] = Storage::put('covers', $data['image']);
        }

        $cover->update($data);

        Cache::flush();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Portada Actualizada',
            'text' => 'La portada se ha actualizado correctamente',

        ]);

        return redirect()->route('admin.covers.edit', $cover);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cover $cover)
    {
        Storage::delete($cover->image_path);
        $cover->delete();
        Cache::flush();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Portada Eliminada',
            'text' => 'La portada se ha eliminado correctamente',
        ]);
        return redirect()->route('admin.covers.index');
    }
}