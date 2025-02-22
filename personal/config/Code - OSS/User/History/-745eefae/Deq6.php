<?php

namespace App\Livewire;

use App\Livewire\Forms\Shipping\CreateAddressForm;
use App\Livewire\Forms\Shipping\EditAddressForm;
use App\Models\Address;
use Livewire\Component;

class ShippingAddresses extends Component
{
    public $addresses;
    public $newAddress = false;

    public CreateAddressForm $createAddress;
    public EditAddressForm $editAddress;

    // Definir el listener para actualizar las direcciones cuando se emite el evento
    protected $listeners = ['refreshAddresses' => 'updateAddresses'];

    public function mount()
    {
        // Cargar las direcciones del usuario
        $this->addresses = Address::where('user_id', auth()->id())->get();

        // Inicializar la información de recepción
        $this->createAddress->receiver_info = [
            'name' => auth()->user()->name,
            'last_name' => auth()->user()->last_name,
            'document_type' => auth()->user()->document_type,
            'document_number' => auth()->user()->document_number,
            'phone' => auth()->user()->phone
        ];
    }

    // Actualizar las direcciones en la vista
    public function updateAddresses()
    {
        $this->addresses = Address::where('user_id', auth()->id())->get();

        // Emitir el evento con las direcciones actualizadas
        $this->emitTo('summary', 'updateAddresses', $this->addresses->toArray());
    }

    // Guardar una nueva dirección
    public function store()
    {
        $this->createAddress->save();
        $this->addresses = Address::where('user_id', auth()->id())->get();
        $this->newAddress = false;

        // Emitir el evento con las direcciones actualizadas
        $this->emitTo('summary', 'updateAddresses', $this->addresses->toArray());
    }

    // Editar una dirección existente
    public function edit($id)
    {
        $address = Address::find($id);
        $this->editAddress->edit($address);
    }

    // Actualizar una dirección existente
    public function update()
    {
        $this->editAddress->update();
        $this->addresses = Address::where('user_id', auth()->id())->get();

        // Emitir el evento con las direcciones actualizadas
        $this->emitTo('summary', 'updateAddresses', $this->addresses->toArray());
    }

    // Eliminar una dirección
    public function deleteAddress($id)
    {
        Address::find($id)->delete();
        $this->addresses = Address::where('user_id', auth()->id())->get();

        // Si no hay una dirección predeterminada, marcar la primera dirección como predeterminada
        if ($this->addresses->where('default', true)->count() == 0 && $this->addresses->count() > 0) {
            $this->addresses->first()->update(['default' => true]);
        }

        // Emitir el evento con las direcciones actualizadas
        $this->emitTo('summary', 'updateAddresses', $this->addresses->toArray());
    }

    // Establecer la dirección predeterminada
    public function setDefaultAddress($id)
    {
        $this->addresses->each(function ($address) use ($id) {
            $address->update(['default' => $address->id == $id]);
        });

        // Emitir el evento con las direcciones actualizadas
        $this->emitTo('summary', 'updateAddresses', $this->addresses->toArray());
    }

    // Renderizar el componente
    public function render()
    {
        return view('livewire.shipping-addresses');
    }
}
