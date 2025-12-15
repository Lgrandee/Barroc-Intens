<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\OrderLogistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function showStock()
    {
        $products = Product::all();
        return view('purchasing.productStock')->with('products', $products);
    }

   public function create(){
        return view('purchasing.createProduct');
   }

   public function store(Request $request)
    {
        $newProduct = new Product();
        $newProduct->product_name = $request->product_name;
        $newProduct->stock = $request->stock;
        $newProduct->price = $request->price;
        $newProduct->type = $request->type;
        $newProduct->save();

        return redirect()->route('product.stock');
    }

    // Show order form where user can enter quantities to order
    public function orderForm()
    {
        $products = Product::all();
        return view('purchasing.orderProduct', compact('products'));
    }

    // Process order: add ordered quantities to stock
    public function order(Request $request)
    {
        $data = $request->validate([
            'quantities' => 'array',
            'quantities.*' => 'nullable|integer|min:0',
        ]);

        $quantities = $data['quantities'] ?? [];

        DB::transaction(function () use ($quantities) {
            foreach ($quantities as $productId => $qty) {
                $qty = (int) $qty;
                if ($qty <= 0) continue;
                $product = Product::find($productId);
                if (!$product) continue;
                $product->stock = ($product->stock ?? 0) + $qty;
                $product->save();
                // Maak een backlog/order-log entry voor deze bestelling
                try {
                    OrderLogistic::create([
                        'product_id' => $product->id,
                        'amount' => $qty,
                        'price' => $product->price ?? 0,
                    ]);
                } catch (\Exception $e) {
                    // Als het niet lukt om de log-entry aan te maken, rollback explicit niet nodig
                    // omdat we binnen een DB::transaction zitten; rethrow om de transactie te laten falen
                    throw $e;
                }
            }
        });

        return redirect()->route('products.order')->with('success', 'Bestelling geplaatst en voorraad geüpdatet.');
    }

    // Backlog / overzicht van bestellingen
    public function orderLogistics()
    {
        $logs = OrderLogistic::with('product')->orderBy('created_at', 'desc')->get();
        return view('purchasing.orderLogistics', compact('logs'));
    }
}
