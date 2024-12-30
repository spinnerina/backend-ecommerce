<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Products;

class OrderController extends Controller
{

    public function store(StoreOrderRequest $request)
    {
        // Create the order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => 0,
        ]);

        // Calculate the total amount
        $totalAmount = 0;
        foreach ($request->items as $item) {
            $product = Products::findOrFail($item['product_id']);
            $totalAmount += $product->price * $item['quantity'];

            $order->orderItem()->create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        //Update the total amount
        $order->update(['total_amount' => $totalAmount]);

        return response()->json($order, 201);
    }

    public function show($id)
    {
        $order = Order::with('orderItem.product')->findOrFail($id);
        if(!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        return response()->json($order);
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $order->update(['status' => 'canceled']);

        return response()->json($order);
    }

    public function getHistoryUser()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        if($orders->isEmpty()) {
            return response()->json(['error' => 'No orders found'], 404);
        }

        return response()->json($orders);
    }

}
