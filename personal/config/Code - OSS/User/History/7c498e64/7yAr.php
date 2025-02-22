<?php

namespace App\Livewire;

use Livewire\Component;

class Summary extends Component
{   

    public $addresses;  // Declarar la propiedad

    public function mount($addresses)
    {
        $this->addresses = $addresses;  // Recibir las direcciones pasadas desde el padre
    }
    public function render()
    {
        return view('livewire.summary');
    }


}
