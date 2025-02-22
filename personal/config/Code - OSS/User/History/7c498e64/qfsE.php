<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\Address;
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

    public function mount()
    {
    
        $this->addresses = Address::where('user_id', auth()->id())->get();
    }

    public function render()
    {
        return view('livewire.summary');
    }
}