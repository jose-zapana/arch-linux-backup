<?php

namespace App\Livewire;

use Livewire\Component;

class Summary extends Component
{
    public function render()
    {
        return view('livewire.summary');
    }

    public function enableNextButton()
    {
        $this->emit('enableNextButton'); // Emitir el evento
    }
}
