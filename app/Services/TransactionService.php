<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionService
{
    public function getCartData()
    {
        $cashier_id = auth()->user()->id;

        $query = Cart::with(['product'])->where('cashier_id', $cashier_id);
        return $query->get();
    }

    public function getProductData($request)
    {
        $category_id = $request->category_id;

        $query = Product::query();

        // Filtering data
        $query->when(request('category_id', false), function ($q) use ($category_id) {
            $q->where('category_id', $category_id);
        });

        return $query->pluck('name', 'id');
    }

    public function addProductToCart($request)
    {
        $inputs = $request->only(['product_id', 'qty']);
        $inputs['cashier_id'] = auth()->user()->id;

        // Calculating Qty if Cart Exists
        $cart = Cart::where('product_id', $request->product_id)->where('cashier_id', $inputs['cashier_id'])->first();
        $cart ? $inputs['qty'] += $cart->qty : $inputs['qty'];

        // Check Product Stock
        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $inputs['qty']) {
            throw new \Exception('Out of stock product');
        }

        // Calculate price and insert it to cart table
        $inputs['price'] = $product->price * $inputs['qty'];
        $carts = Cart::updateOrCreate([
            'product_id' => $request->product_id,
            'cashier_id' => $inputs['cashier_id'],
        ], $inputs);
        return $carts;
    }

    public function updateQtyProductCart($id, $request)
    {
        $inputs = $request->only(['qty']);
        $cart = Cart::findOrFail($id);

        // Check Product Stock
        $product = Product::findOrFail($cart->product_id);
        if ($product->stock < $inputs['qty']) {
            throw new \Exception('Out of stock product');
        }

        $inputs['price'] = $product->price * $inputs['qty'];
        $cart->update($inputs);
        return $cart;
    }

    public function deleteProductFromCart($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return $cart;
    }

    public function payOrder($request)
    {
        // Check If Order Valid
        if($request->cash < $request->grand_total) {
            throw new \Exception('Cash must be greater than grand total');
        }

        // Generate Invoice Code
        $length = 10;
        $random = "";
        $characters = array_merge(range('A', 'Z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $random .= $characters[$rand];
        }
        $invoice_code = "POS-".$random;

        // Create Transaction
        $inputs = $request->only(['cash', 'grand_total', 'change']);
        $inputs['invoice_code'] = $invoice_code;
        $inputs['cashier_id'] = auth()->user()->id;
        $transaction = Transaction::create($inputs);

        // Create Transaction Detail and Delete Current Carts
        $carts = Cart::where('cashier_id', auth()->user()->id)->get();
        foreach ($carts as $cart) {
            // Get Product Data
            $product = Product::where('id', $cart->product_id)->first(['id', 'category_id', 'name', 'image', 'description', 'price', 'stock']);

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product' => $product,
                'qty' => $cart->qty,
                'price' => $cart->price
            ]);

            // Reduce the product stock
            $current_stock = $product->stock - $cart->qty;
            $product->update([
                'stock' => $current_stock
            ]);

            // Delete cart after all process
            $cart->delete();
        }

        return $transaction;
    }

    public function getTransaction($id)
    {
        $transaction = Transaction::with('transaction_details', 'cashier')->findOrFail($id);
        return $transaction;
    }
}
