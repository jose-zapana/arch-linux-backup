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
        // Verificar que las direcciones estén bien formateadas
        if (is_array($addresses)) {
            $this->addresses = collect($addresses);  // Convierte el array en una colección
        } else {
            $this->addresses = collect();  // En caso de que no se pase nada o no sea un array
        }
    }

    public function mount()
    {
        // Si ya tienes direcciones al cargar la página
        $this->addresses = Address::where('user_id', auth()->id())->get();
    }

    public function render()
    {
        return view('livewire.summary');
    }
}
