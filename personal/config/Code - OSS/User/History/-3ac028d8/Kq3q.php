<div>
    @@switch($data->status)
        @case(\App\Enums\QuotationStatus::Pending)

            <button>
                Listo para despachar
            </button>
            
            @break
        @case(2)
            
            @break
        @default
            
    @endswitch
</div>