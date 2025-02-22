<?php

namespace App\Livewire;

use Livewire\Component;

class Summary extends Component
{
    public $addresses;  // Propiedad para almacenar las direcciones

    // Escuchar el evento 'updateAddresses' desde el componente padre
    protected $listeners = ['updateAddresses' => 'handleUpdateAddresses'];

    // Este método actualizará las direcciones en el componente hijo
    public function handleUpdateAddresses($addresses)
    {
        $this->addresses = $addresses;  // Actualiza la propiedad $addresses
    }

    public function render()
    {
        return view('livewire.summary');
    }
}