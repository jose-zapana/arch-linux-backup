<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use Livewire\Component;

class Summary extends Component
{

    public function mount()
    {
    
        $this->addresses = Address::where('user_id', auth()->id())->get();
    }

    public function render()
    {
        return view('livewire.summary');
    }
}