<?php

namespace App\Livewire;

use Livewire\Component;

class Summary extends Component
{   

    public $addresses;

    protected $listeners = ['updateAddresses'];

    public function updateAddresses($addresses)
    {
        $this->addresses = $addresses;
    }
    public function render()
    {
        return view('livewire.summary');
    }


}
