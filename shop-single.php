<?php
// Start a session to keep track of the shopping cart
session_start();

// If someone clicks "Add to Cart" using a special request (AJAX), handle it here
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    // Get the product details from the form
    if (isset($_POST['product-title'], $_POST['product-size'], $_POST['product-quantity'], $_POST['product-price'])) {
        $product = [
            'title' => $_POST['product-title'],    // Product name
            'size' => $_POST['product-size'],      // Product size (S, M, L, XL)
            'quantity' => (int)$_POST['product-quantity'], // How many items
            'price' => (float)$_POST['product-price']     // Price of the item
        ];

        // Check if this product (with the same name and size) is already in the cart
        $found = false;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['title'] === $product['title'] && $item['size'] === $product['size']) {
                    $item['quantity'] += $product['quantity']; // Add to the existing quantity
                    $found = true;
                    break;
                }
            }
        }

        // If the product isn’t in the cart, add it as a new item
        if (!$found) {
            $_SESSION['cart'][] = $product;
        }

        // Send back the total number of items in the cart as a simple message
        header('Content-Type: application/json');
        echo json_encode(['cartCount' => array_sum(array_column($_SESSION['cart'], 'quantity'))]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "include/head.php"; ?> <!-- Include common head content (like styles) -->
</head>
<body>
    <!-- Header with navigation and cart icon -->
    <?php include "include/header.php"; ?>

    <!-- Product Display -->
    <div class="container py-5">
        <div class="row">
            <!-- Product Image -->
            <div class="col-md-6">
                <img src="activewear-image.jpg" alt="Oupidatat non" class="img-fluid" style="max-width: 100%;">
            </div>
            
            <!-- Product Details -->
            <div class="col-md-6">
                <h1>Oupidatat non</h1>
                <p class="lead">$225.00</p>
                <p>Great activewear for comfort during workouts.</p>
                
                <form method="POST" action="" id="product-form">
                    <input type="hidden" name="product-title" value="Oupidatat non">
                    <input type="hidden" name="product-price" value="225.00">
                    
                    <!-- Size Selection -->
                    <div class="mb-3">
                        <label for="product-size">Size:</label>
                        <select name="product-size" id="product-size" class="form-select" required>
                            <option value="S">Small</option>
                            <option value="M">Medium</option>
                            <option value="L">Large</option>
                            <option value="XL">Extra Large</option>
                        </select>
                    </div>

                    <!-- Quantity Buttons -->
                    <div class="mb-3">
                        <label>Quantity:</label>
                        <div style="display: flex; align-items: center;">
                            <button type="button" class="btn btn-success" id="btn-minus">-</button>
                            <span class="badge bg-secondary mx-2" id="var-value">1</span>
                            <button type="button" class="btn btn-success" id="btn-plus">+</button>
                            <input type="hidden" name="product-quantity" id="product-quantity" value="1">
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <button type="submit" class="btn btn-success btn-lg" name="submit" value="addtocard">Add To Cart</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Simple JavaScript for Quantity and Cart -->
    <script>
        // Add 1 to quantity when clicking the plus button
        document.getElementById('btn-plus').addEventListener('click', function(e) {
            e.preventDefault(); // Stop the button from doing anything else
            let qty = parseInt(document.getElementById('var-value').textContent); // Get current number
            qty++; // Increase by 1
            document.getElementById('var-value').textContent = qty; // Show new number
            document.getElementById('product-quantity').value = qty; // Update hidden input
        });

        // Subtract 1 from quantity when clicking the minus button (if more than 1)
        document.getElementById('btn-minus').addEventListener('click', function(e) {
            e.preventDefault(); // Stop the button from doing anything else
            let qty = parseInt(document.getElementById('var-value').textContent); // Get current number
            if (qty > 1) { // Only decrease if more than 1
                qty--; // Decrease by 1
                document.getElementById('var-value').textContent = qty; // Show new number
                document.getElementById('product-quantity').value = qty; // Update hidden input
            }
        });

        // Add product to cart without leaving the page
        document.getElementById('product-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Stay on this page
            const formData = new FormData(this); // Get all form data
            formData.append('action', 'add_to_cart'); // Tell the server it’s an add-to-cart request

            fetch('', { // Send data to the same page
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Get the response as JSON
            .then(data => {
                document.querySelector('.cart-count').textContent = data.cartCount; // Update cart number in header
            })
            .catch(error => console.error('Error:', error)); // Log any errors
        });
    </script>

    <?php include "include/footer.php"; ?> <!-- Include common footer content -->
</body>
</html>