<?php

namespace App\Listeners;

use CodersFree\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;

class RestoreCartItems
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        
        Cart::instance('shopping')->restore();

    }


}
