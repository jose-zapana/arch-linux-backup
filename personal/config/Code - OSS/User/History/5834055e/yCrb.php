<?php

namespace App\Policies;

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
        $orders = Order::where('user_id', $user->id)->select('content')->get()->map(function ($order) {
            retrun json_decode($order->content,true);
        });
    }
}
