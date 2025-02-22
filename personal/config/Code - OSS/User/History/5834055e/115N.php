<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function review(User $user, Product $product)
    {
        $orders = Order::where('user_id', $user->id)->select('content')->get()->map(function($order) {
            return json_decode($order->content,true);
        });

        $products = $orders->collapse();

        return $products->contains('id', $product->id);
    }
}
