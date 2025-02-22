<?php

namespace App\Livewire;

use Livewire\Component;

class Summary extends Component
{
    public function enableNextButton()
    {
        $this->emit('enableNextButton');
    }
    public function render()
    {
        return view('livewire.summary');
    }


}
