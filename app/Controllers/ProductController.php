<?php

namespace App\Controllers;

use App\Models\OrdersModel;
use App\Models\ProductsModel;
use App\Models\Cart_itemsModel;
use App\Models\UsersModel;
use App\Models\Order_itemsModel;
use Core\View;

class ProductController
{
    // Главная страница с товарами
    public function index()
    {
        $products = ProductsModel::all();
        return view('products/index', ['products' => $products]);
    }

    // Страница одного товара
    public function show($id)
    {

        $product = ProductsModel::find($id);

        if (!$product['title']) {
            return view('errors/400', ['title' => '404', 'text' => 'The page you are looking for doesnt exist or has been moved.']);

        }

        return view('products/show', ['product' => $product]);
    }

    // Добавление товара в корзину
    public function addToCart(Request $request)
    {
        $userId = Auth::id(); // предполагаем, что пользователь авторизован

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $existingItem = CartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->save();
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        Session::flash('success', 'Товар добавлен в корзину');
        return redirect('/cart');
    }

    // Корзина пользователя
    public function cart()
    {
        $userId = Auth::id();
        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        return view('cart/index', ['cartItems' => $cartItems]);
    }

    // Удалить товар из корзины
    public function removeFromCart($itemId)
    {
        $userId = Auth::id();
        $item = Cart_itemsModel::where('id', $itemId)->where('user_id', $userId)->first();

        if ($item) {
            $item->delete();
        }

        Session::flash('success', 'Товар удалён из корзины');
        return redirect('/cart');
    }
}