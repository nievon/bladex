<?php

namespace App\Controllers;

use App\Models\OrdersModel;
use App\Models\ProductsModel;
use App\Models\Cart_itemsModel;
use App\Models\UsersModel;
use App\Models\Order_itemsModel;
use Core\View;
use RedBeanPHP\R;

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
    public function addToCart()
    {

        $userId = $_SESSION['user']['id'];

        // Получаем данные из $_POST
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if (!$productId) {
            // Обработка ошибки, например, редирект с сообщением
            $_SESSION['error'] = 'Не указан ID продукта';
            header('Location: /catalog');
            exit;
        }

        $existingItem = R::findOne('cartitems', 'user_id = ? AND product_id = ?', [$userId, $productId]);

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->save();
        } else {
            Cart_itemsModel::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        $_SESSION['success'] = 'Товар добавлен в корзину';
        header('Location: /cart');
        exit;
    }

    // Корзина пользователя
    public function cart()
    {
        $session = $_SESSION['user'];
        $userId = $session['id'];
        $cartItems = Cart_itemsModel::getItemsWithProduct($userId);

        return view('cart/index', ['cartItems' => $cartItems]);
    }

    // Удалить товар из корзины
    public function removeFromCart($itemId)
    {
        $userId = $_SESSION['user']['id'];
        $item = R::getAll('SELECT * FROM cartitems WHERE user_id = ? AND product_id = ?', [$userId, $itemId]);

        if (!empty($item)) {

            foreach ($item as $row) {

                $bean = R::load('cartitems', $row['id']);
                R::trash($bean); // Удаляем объект
            }
        }

        return redirect('/cart');
    }
}