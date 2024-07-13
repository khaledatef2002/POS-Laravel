<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:create-order', only: ['create', 'store']),
        ];
    }

    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.create', compact('client', 'categories'));
    }

    public function store(Request $req, Client $client)
    {
        $req->validate([
            'products' => 'required|array',
            'products.*' => 'required|exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'required|numeric',
        ]);

        $data = $req->only(['products', 'quantities']);

        if(count($data['products']) != count($data['quantities']))
        {
            abort(400);
        }

        $total_price = 0;

        foreach($data['products'] as $i => $product)
        {
            $product_info = Product::find($product);
            if($product_info->stock < ($data['quantities'][$i]))
                abort(400);
            else
                $total_price += ($product_info->sell_price * $data['quantities'][$i]);
        }

        $order = Order::create([
            'user_id' => $client->id,
            'total_price' => $total_price,
        ]);

        foreach($data['products'] as $i => $product)
        {
            $order->products()->create([
                'product_id' => $product,
                'quantity' => $data['quantities'][$i]
            ]);

            $productDefault = Product::find($product);
            $productDefault->update([
                'stock' => $productDefault->stock - $data['quantities'][$i]
            ]);
        }
        
        return to_route('dashboard.orders.index')->with('success', __('site.record.added'));
    }
}
