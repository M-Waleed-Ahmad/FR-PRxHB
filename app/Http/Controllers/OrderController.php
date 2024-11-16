<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Display a listing of orders
    public function index() {
        $orders = Order::where('user_id', auth()->id())->with('book:id,title,price')->get();
        return response()->json(['orders' => $orders]);
    }
    

    // Show the form for creating a new order
    public function create()
    {
        $books = Book::all();
        $users = User::where('type', 'user')->get();
        return view('orders.create', compact('books', 'users'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        Order::create($request->all());

        return response()->json(['message' => 'Order created successfully']);
    }
    // Store a newly created order
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        Order::create($request->all());

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    // Show the details of a specific order
    public function show($id)
    {
        $order = Order::with(['user', 'book'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    // Remove the specified order
    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order cancelled successfully']);
    }
}
