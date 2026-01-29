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
        $hasProduct = false;
        foreach ($quantities as $qty) {
            if ((int)$qty > 0) {
                $hasProduct = true;
                break;
            }
        }
        if (!$hasProduct) {
            return redirect()->route('products.order')
                ->withErrors(['order' => 'Selecteer minstens één product om te bestellen.'])
                ->withInput();
        }

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
    // Show the edit form for a product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('purchasing.editProduct', compact('product'));
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->product_name = $request->product_name;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->type = $request->type;
        $product->save();

        return redirect()->route('product.stock')->with('success', 'Product bijgewerkt.');
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.stock')->with('success', 'Product verwijderd.');
    }
}
