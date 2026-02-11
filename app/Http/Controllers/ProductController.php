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
        $products = Product::with('orderLogistics')->paginate(15);
        return view('purchasing.productStock')->with('products', $products);
    }

   public function create(){
        return view('purchasing.createProduct');
   }

   public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255|unique:products,product_name',
            'stock' => 'required|integer|min:0|max:999999',
            'price' => 'required|numeric|min:0|max:999999.99',
            'type' => 'required|in:beans,parts,machines',
        ]);

        $newProduct = new Product();
        $newProduct->product_name = $validated['product_name'];
        $newProduct->stock = $validated['stock'];
        $newProduct->price = $validated['price'];
        $newProduct->type = $validated['type'];
        $newProduct->save();

        return redirect()->route('product.stock')->with('success', 'Product aangemaakt.');
    }

    // Show order form where user can enter quantities to order
    public function orderForm()
    {
        $products = Product::with('orderLogistics')->paginate(15);
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
        $logs = OrderLogistic::with('product')->orderBy('created_at', 'desc')->paginate(15);
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

        $validated = $request->validate([
            'product_name' => 'required|string|max:255|unique:products,product_name,' . $product->id,
            'stock' => 'required|integer|min:0|max:999999',
            'price' => 'required|numeric|min:0|max:999999.99',
            'type' => 'required|in:beans,parts,machines',
        ]);

        $product->product_name = $validated['product_name'];
        $product->stock = $validated['stock'];
        $product->price = $validated['price'];
        $product->type = $validated['type'];
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
