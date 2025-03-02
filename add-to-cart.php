<?php

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Add item to cart
    $_SESSION['cart'][$product_id] = [
        'name' => $product_name,
        'price' => $price,
        'quantity' => $quantity
    ];

    echo "Item added to cart!";
}
echo "<h2>Shopping Cart</h2>";
foreach ($_SESSION['cart'] as $id => $item) {
    echo "{$item['name']} - {$item['price']} x {$item['quantity']} <br>";
}

?>