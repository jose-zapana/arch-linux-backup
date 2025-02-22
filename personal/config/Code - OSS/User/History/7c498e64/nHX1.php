<?php

namespace App\Livewire;

use Livewire\Component;

class Summary extends Component
{
    public $addresses = [];  // Propiedad para almacenar las direcciones

    // Escuchar el evento 'updateAddresses' desde el componente padre
    protected $listeners = ['updateAddresses' => 'handleUpdateAddresses'];

    // Este método actualizará las direcciones en el componente hijo
    public function handleUpdateAddresses($addresses)
    {
        // Si $addresses es un array, convierte en una colección de Eloquent
        $this->addresses = collect($addresses);  // Convierte el array en colección
    }

    public function render()
    {
        return view('livewire.summary');
    }
}
