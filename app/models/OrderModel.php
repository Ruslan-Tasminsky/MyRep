<?php

namespace app\models;

use ishop\App;

class OrderModel extends AppModel
{
    public static function saveOrder($data){
        $order = \R::dispense('order');
        $order->user_id = $data['user_id'];
        $order->note = $data['note'];
        $order->currency = $_SESSION['cart.currency']['code'];
        $order_id = \R::store($order);
        self::saveOrderProduct($order_id);
        return $order_id;
    }

    public static function saveOrderProduct($order_id){
        $sql_part = '';
        foreach($_SESSION['cart'] as $product_id => $product){
            $product_id = (int)$product_id;
            $sql_part .= "($order_id, $product_id, {$product['qty']}, '{$product['title']}', {$product['price']}),";
        }
        $sql_part = rtrim($sql_part, ',');
        \R::exec("INSERT INTO order_product (order_id, product_id, qty, title, price) VALUES $sql_part");
    }

    public static function mailOrder($order_id, $user_email){
        ob_start();
        require APP . '/views/mail/mail_order1.php';
        $body = ob_get_clean();
        mail($user_email, "Вы совершили заказ №{$order_id} на сайте " . App::$app->getProperty('shop_name'), $body);
        mail(App::$app->getProperty("admin_email"), "Клиент {$_SESSION["user"]["name"]} совершил заказ №{$order_id} на сайте " . App::$app->getProperty('shop_name'), $body);
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.currency']);
        $_SESSION['success'] = 'Спасибо за Ваш заказ. В ближайшее время с Вами свяжется менеджер для согласования заказа';
    }
}
