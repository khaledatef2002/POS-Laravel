<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:read-order', only: ['index', 'getOrderDetails']),
            new Middleware('permission:remove-order', only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $orders = Order::when($req->search, function ($q) use ($req) {
            return $q->whereHas('client', function($query) use ($req) {
                return $query->where('name', 'LIKE', "%{$req->search}%");
            })->orWhere('total_price', 'LIKE', "%{$req->search}%");
        })
        ->latest()->paginate(10);
        return view('dashboard.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        
    }

    public function getOrderDetails(Order $order)
    {
        return view('dashboard.orders.order', compact('order'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $categories = Category::with('products')->get();
        return view('dashboard.orders.edit', compact('categories', 'order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, Order $order)
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
            $stock = $order->products->pluck('product_id')->contains($product_info->id) ? $product_info->stock + $order->products->firstWhere('product_id', $product_info->id)->quantity : $product_info->stock;
            if($stock < ($data['quantities'][$i]))
                abort(400);
            else
                $total_price += ($product_info->sell_price * $data['quantities'][$i]);
        }

        $order->total_price = $total_price;

        $this->deattachProducts($order);

        $order->save();

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

        return to_route('dashboard.orders.index')->with('success', __('site.record.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $this->deattachProducts($order);

        $order->delete();
        return back()->with('success', __('site.record.deleted'));
    }

    private function deattachProducts(Order $order)
    {
        foreach($order->products as $product)
        {
            $originalProduct = Product::find($product->product_id);
            $originalProduct->stock = $originalProduct->stock + $product->quantity;
            $originalProduct->save();
        }
        $order->products()->delete();
    }
}
