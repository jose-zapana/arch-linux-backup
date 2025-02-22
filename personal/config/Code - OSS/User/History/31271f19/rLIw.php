<x-app-layout>

    @push('head')
    <script type="text/javascript"
        src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
        kr-public-key="89289758:testpublickey_TxzPjl9xKlhM0a6tfSVNilcLTOUZ0ndsTogGTByPUATcE"
        kr-post-url-success="paid.php";
        kr-language="en-EN">
    </script>

      <!--  theme CLASSIC should be loaded in the HEAD section   -->
<link rel="stylesheet" href="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic-reset.min.css">
<script src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.js">
 </script>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
