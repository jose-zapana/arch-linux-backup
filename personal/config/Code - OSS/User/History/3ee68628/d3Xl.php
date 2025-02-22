<div class="card dark:bg-gray-800 dark:text-white">
    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-validation-errors class="mb-4" />
  
        <figure class="mb-4 relative">
          <div class="absolute top-8 right-8">
              <label class="flex items-center px-4 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 cursor-pointer text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                  <i class="fas fa-camera mr-2"></i>
                  Actualizar imagen
                  <input type="file" id="file" class="hidden" accept="image/*"> <!-- Añadir el ID aquí -->
              </label>
          </div>
          <img id="picture" class="aspect-[16/9] object-cover object-center w-1/2 mx-auto rounded-lg shadow-md dark:shadow-lg" src="{{ asset('img/no-image.png') }}" alt="Imagen no disponible">
      </figure>
  
        <div class="mb-4">
            <x-input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
            <x-label for="name" class="mb-2 dark:text-gray-300">Nombre</x-label>
            <x-input id="name" name="name" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Escribe un título" value="{{ old('name') }}" autocomplete="off" required />
        </div>
        <div class="mb-4">
            <x-label for="slug" class="mb-2 dark:text-gray-300">Slug</x-label>
            <x-input id="slug" name="slug" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el slug de la entrada" value="{{ old('slug') }}" readonly />
        </div>
        <div class="mb-4">
            <x-label for="blogcategory_id" class="mb-2 dark:text-gray-300">Categorías</x-label>
            <x-select id="blogcategory_id" name="blogcategory_id" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                <option value="">Seleccionar categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('blogcategory_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </x-select>
        </div>
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">Etiquetas</x-label>
            <div class="flex flex-wrap space-x-4">
                @foreach ($tags as $tag)
                    <div>
                        <input type="checkbox" id="tag{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, old('tags', [])))>
                        <label for="tag{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
  
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">Status</x-label>
            <div class="flex items-center space-x-2">
                <div class="flex items-center space-x-2">
                    <input type="radio" name="status" id="status1" value="1" @checked(old('status', 1) == 1) aria-labelledby="status1">
                    <label for="status1">Borrador</label>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="radio" name="status" id="status2" value="2" @checked(old('status', 1) == 2) aria-labelledby="status2">
                    <label for="status2">Publicar</label>
                </div>
            </div>
        </div>
  
        <div class="mb-4">
            <x-label for="extract" class="mb-2 dark:text-gray-300">Extracto</x-label>
            <x-textarea id="extract" name="extract" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Escribe el extracto" required>{{ old('extract') }}</x-textarea>
        </div>
        <div class="mb-4">
            <x-label for="body" class="mb-2 dark:text-gray-300">Cuerpo</x-label>
            <x-textarea id="body" name="body" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Escribe el contenido" required>{{ old('body') }}</x-textarea>
        </div>
        <div>
            <x-button type="submit" class="bg-blue-600 hover:bg-blue-700">Guardar entrada</x-button>
        </div>
    </form>
  </div>
  