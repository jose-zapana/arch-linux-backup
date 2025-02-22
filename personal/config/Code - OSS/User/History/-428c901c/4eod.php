<?php

namespace App\Livewire\Admin\Users;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class UserCreate extends Component
{
    public $document_type, $document_number, $name, $last_name, $phone, $email;

    public function mount()
    {
        $this->document_type = '';
    }

    public function searchCustomer()
    {
        $number = $this->document_number;
        $document_type = $this->document_type;
        $token = config('services.sunat.token');

        if ($document_type == 1) {
            $this->validate([
                'document_number' => 'required|digits:8',
                'document_type' => 'required',

            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://apis.net.pe/consulta-dni-api',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ])
                ->get('https://api.apis.net.pe/v2/reniec/dni', [
                    'numero' => $number
                ]);

            $customer = $response->json();
            $this->name = $customer['nombres'];
            $this->last_name = $customer['apellidoPaterno'] . ' ' . $customer['apellidoMaterno'];
        } elseif ($document_type == 3) {
            $this->validate([
                'document_number' => 'required|digits:11',
                'document_type' => 'required',
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://apis.net.pe/api-consulta-ruc',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ])
                ->get('https://api.apis.net.pe/v2/sunat/ruc', [
                    'numero' => $number
                ]);
            $customer = $response->json();
            $this->name = $customer['razonSocial'];
        }
    }

    public function render()
    {
        return view('livewire.admin.users.user-create');
    }
}