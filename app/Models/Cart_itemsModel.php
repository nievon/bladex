<?php

namespace App\Models;

use Core\Model;
use RedBeanPHP\R;


class Cart_itemsModel extends Model
{
    // Add your model logic here
    protected static string $table = 'cartitems';

    public static function getItemsWithProduct($userId)
    {
        $items = R::findAll('cartitems', 'user_id = ?', [$userId]);

        foreach ($items as $item) {
            // подгружаем вручную связанный продукт
            $item->product = R::load('products', $item->product_id);
        }

        return $items;
    }
}