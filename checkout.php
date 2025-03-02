<?php
session_start();

// Redirect if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Process form submission
$order_success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input fields
    $required_fields = ['name', 'email', 'address', 'city', 'state', 'zip', 'country'];
    $valid = true;
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $valid = false;
            break;
        }
    }

    // In the checkout page, modify the success handling section:
if ($valid) {
    $total = array_sum(array_map(function($item) {
        return $item['price'] * $item['quantity'];
    }, $_SESSION['cart']));

    // Store order in session for demonstration
    $_SESSION['order'] = [
        'customer' => [
            'name' => htmlspecialchars($_POST['name']),
            'email' => htmlspecialchars($_POST['email']),
            'address' => htmlspecialchars($_POST['address']),
            'city' => htmlspecialchars($_POST['city']),
            'state' => htmlspecialchars($_POST['state']),
            'zip' => htmlspecialchars($_POST['zip']),
            'country' => htmlspecialchars($_POST['country'])
        ],
        'items' => $_SESSION['cart'],
        'total' => $total
    ];

    // Store total separately for Pay.php
    $_SESSION['order_total'] = $total;

    // Clear cart
    unset($_SESSION['cart']);
    $order_success = true;
    header('Location: Pay.php');
    exit;
}
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "include/head.php" ?>
<body>
    <?php include "include/header.php" ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="mb-4">Checkout</h1>
                
                <!-- Checkout Form -->
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <h3>Contact Information</h3>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="col-12">
                            <h3 class="mt-4">Shipping Address</h3>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        <div class="col-md-4">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>

                        <div class="col-md-4">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" required>
                        </div>

                        <div class="col-md-4">
                            <label for="zip" class="form-label">Zip Code</label>
                            <input type="text" class="form-control" id="zip" name="zip" required>
                        </div>

                        <div class="col-md-12">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-select" id="country" name="country" required>
                                <option value="">Choose...</option>
                                <option value="US">United States</option>
                                <option value="UK">United Kingdom</option>
                                <option value="CA">Cambodia</option>
                                <!-- Add more countries as needed -->
                            </select>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success btn-lg w-100">Complete Order</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Order Summary</h4>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span><?= htmlspecialchars($item['title']) ?> (<?= $item['size'] ?>)</span>
                                <span>$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                            </div>
                        <?php endforeach; ?>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span>$<?= number_format(array_sum(array_map(function($item) {
                                return $item['price'] * $item['quantity'];
                            }, $_SESSION['cart'])), 2) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "include/footer.php" ?>
</body>
</html>