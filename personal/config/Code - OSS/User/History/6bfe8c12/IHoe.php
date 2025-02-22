<button wire:click="downloadPdf({{ $quotaId->id }})">
  <img src="{{ asset('img/pdf.png') }}" alt="" style="width: 40px; height: 40px;">
</button>


<x-dropdown-link href="{{ route('admin.quotes.generatepdf', $quotaId) }}" target="_blank">
  <i class="fa fa-print"></i>
  Imprimir
</x-dropdown-link>