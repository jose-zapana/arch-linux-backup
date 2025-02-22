<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\OrderStatus;
use App\Models\Driver;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class OrderTable extends DataTableComponent
{
    protected $model = Order::class;

    public $drivers;

    public $new_shipment = [
        'openModal' => true,
        'order_id' => '',
        'driver' => '',
    ];

    public function mount()
    {
        $this->drivers = Driver::all();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("N° orden", "id")
                ->sortable(),

            Column::make("Ticket")
                ->label(function ($row) {
                    return view('admin.orders.ticket', ['order' => $row]);
                }),
            Column::make("F. Orden", "created_at")
                ->format(fn ($value) => $value->format('d/m/Y'))
                ->sortable(),
            Column::make("Total")
                ->format(fn ($value) => $value . ' USD')
                ->sortable(),
            Column::make("Cantidad", "content")
                ->format(function ($value){
                    return count($value);
                })
                ->sortable(),
            Column::make("Estado", "status")
                ->format(function ($value){
                    return $value->name;
                })
                ->sortable(),
            Column::make("Actions")
                ->label(function ($row) {
                    return view('admin.orders.actions', ['order' => $row]);
                }),
        ];
    }

    public function downloadTicket(Order $order)
    {
        return Storage::download($order->pdf_path);
    }

    public function markAsDelivered(Order $order)
    {
        $order->status= OrderStatus::Processing;
        $order->save();
    }

    public function assignDriver(Order $order)
    {   
        $this->new_shipment['order_id'] = $order->id;
        $this->new_shipment['openModal'] = true;
    }

    public function saveShipment()
    {
        $this->validate([
            'new_shipment.driver_id' => 'required|exists:drivers,id',
        ]);
    }
    public function customView(): string
    {
        return 'admin.orders.modal';
    }


}
 