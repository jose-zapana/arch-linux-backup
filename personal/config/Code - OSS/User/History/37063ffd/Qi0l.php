<x-admin-layout :breadcrumbs="[
    ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
    ['name' => 'Entradas del blog', 'route' => route('admin.blogs.index')],
    ['name' => 'Nuevo']
]">
    <div class="card dark:bg-gray-800 dark:text-white">
        <form action="{{ route('admin.blogs.store') }}" method="POST">
            @csrf
            <x-validation-errors class="mb-4" />
            <div class="mb-4">
                <x-input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                <x-label for="name" class="mb-2 dark:text-gray-300">
                    Nombre
                </x-label>
                <x-input id="name" name="name" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Escribe un título" value="{{ old('name') }}" autocomplete="off"/>
            </div>
            <div class="mb-4">
                <x-label for="slug" class="mb-2 dark:text-gray-300">
                    Slug
                </x-label>
                <x-input id="slug" name="slug" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el slug de la categoría" value="{{ old('slug') }}" readonly/>
            </div>
            <div class="mb-4">
                <x-label for="blogcategory_id" class="mb-2 dark:text-gray-300">
                    Categorías
                </x-label>
                <x-select id="blocategory_id" name="blogcategory_id" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>
            <div class="mb-4">
              <x-label class="mb-2 dark:text-gray-300">
                  Etiquetas
              </x-label>
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

            <x-label class="mb-2 dark:text-gray-300">
                Status
            </x-label>

            <div class="flex items-center space-x-2">

                <div class="flex items-center space-x-2">
                    <input type="radio" name="status" id="status1" value="1" @checked(old('status', 1) == 1) aria-labelledby="status1">
                    <label for="status1">Borrador</label>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="radio" name="status" id="status2" value="2" @checked(old('status', 1) == 2) aria-labelledby="status2">
                    <label for="status2">Publicado</label>
                </div>
            </div>

        </div>


          

            <div class="mb-4 text-gray-700">
                <x-label class="mb-2 dark:text-gray-300">
                    Extracto
                </x-label>
                <x-textarea name="extract" id="extract" class="w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:placeholder-gray-400">{{ old('extract') }}</x-textarea>
            </div>
            
            <div class="mb-4 text-gray-700">
                <x-label class="mb-2 dark:text-gray-300">
                    Cuerpo del post
                </x-label>
                <x-textarea name="body" id="body" class="w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:placeholder-gray-400">{{ old('body') }}</x-textarea>
            </div>
            

          
          <div class="flex justify-end">
                <x-button>
                    Crear Entrada
                </x-button>
          </div>
        </form>
    </div>
    @push('js')

    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            nameInput.addEventListener('keyup', function() {
                let title = nameInput.value;
                let slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
                slugInput.value = slug;
            });
        });

        ClassicEditor
            .create( document.querySelector( '#extract' ) )
            .catch( error => {
                console.error( error );
        });

        ClassicEditor
            .create( document.querySelector( '#body' ) )
            .catch( error => {
                console.error( error );
        });

    </script>

    @endpush
</x-admin-layout>
