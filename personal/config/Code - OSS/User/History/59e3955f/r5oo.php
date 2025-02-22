<?php

namespace App\Http\Middleware;

use App\Models\Variant;
use Closure;
use CodersFree\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyStock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        Cart::instance('shopping');
    
        foreach (Cart::content() as $item) {
            $options = $item->options;
    
            // Buscar la variante en la base de datos
            $variant = Variant::where('sku', $options['sku'])->first();
    
            // Validar que la variante exista
            if ($variant) {
                $options['stock'] = $variant->stock;
    
                // Actualizar el carrito con la nueva opción
                Cart::update($item->rowId, [
                    'options' => $options
                ]);
            } else {
                // Manejar el caso donde la variante no exista
                // Puedes eliminar el item del carrito o lanzar un error
                Cart::remove($item->rowId); // Ejemplo: eliminar el artículo
            }
        }
    
        return $next($request);
    }
}
