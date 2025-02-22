<?php

namespace App\Livewire\Forms\Shipping;

use Livewire\Attributes\Validate;
use Livewire\Form;

class EditAddressForm extends Form
{   
    public $id;
    public $type = '';
    public $description = '';
    public $district = '';
    public $reference = '';
    public $receiver = 1;
    public $receiver_info = [];
    public $default = false;

}
