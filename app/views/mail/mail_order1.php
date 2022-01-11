<?php foreach($_SESSION["cart"] as $item) : ?>
Название: <?= $item["title"]?>

Количество: <?= $item["qty"]?>

Цена: <?= $item["price"]?>

Общая цена: <?= $item["price"] * $item["qty"]?>

-------------------------------------------------------
<?php endforeach; ?>

Итого: <?= $_SESSION["cart.qty"]?>

Сумма: <?= $_SESSION['cart.currency']['symbol_left'] . $_SESSION['cart.sum'] . " {$_SESSION['cart.currency']['symbol_right']}"?>
