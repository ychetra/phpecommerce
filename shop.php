<?php
session_start(); // Add at the very top

// Handle AJAX request for adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    if (isset($_POST['product-title'], $_POST['product-size'], $_POST['product-quantity'], $_POST['product-price'])) {
        $product = [
            'title' => $_POST['product-title'],
            'size' => $_POST['product-size'],
            'quantity' => (int)$_POST['product-quantity'],
            'price' => (float)$_POST['product-price']
        ];

        // Check if product already exists in cart to update quantity
        $found = false;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['title'] === $product['title'] && $item['size'] === $product['size']) {
                    $item['quantity'] += $product['quantity']; // Add to existing quantity
                    $found = true;
                    break;
                }
            }
        }

        // If product not found, add it to cart
        if (!$found) {
            $_SESSION['cart'][] = $product;
        }

        // Return the total cart quantity as JSON
        header('Content-Type: application/json');
        echo json_encode(['cartCount' => array_sum(array_column($_SESSION['cart'], 'quantity'))]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include "include/head.php" ?>
</head>
<body>

<?php include "include/header.php" ?>
    <!-- ... (existing content) ... -->
    <div class="col-md-2">
        <div class="card mb-4 product-wap rounded-0">
            <div class="card rounded-0">
                <a href="shop-single.php" class="product-image-link" style="display: block; text-decoration: none;">
                    <div class="product-image-container" style="background-color: #f0f8ff; display: flex; justify-content: center; align-items: center; padding: 20px; transition: opacity 0.3s ease;">
                        <img class="card-img rounded-0 img-fluid" src="assets/img/shop_01.jpg" alt="Product Image" style="max-width: 200px;">
                    </div>
                </a>
                <div class="card-body text-center" style="padding: 15px;">
                    <a href="shop-single.php" class="card-title" style="text-decoration: none;"><h5>Oupidatat non</h5></a>
                    <p class="card-text">
                        <span style="color: #ff0000; font-weight: bold;">SALE!</span><br>
                        225.00$
                    </p>
                    <form method="POST" action="" id="product-form">
                        <input type="hidden" name="product-title" value="Oupidatat non">
                        <select name="product-size" class="form-select mb-3" required>
                            <option value="S">Small</option>
                            <option value="M">Medium</option>
                            <option value="L">Large</option>
                            <option value="XL">Extra Large</option>
                        </select>
                        <input type="hidden" name="product-quantity" value="1">
                        <input type="hidden" name="product-price" value="225.00">
                        <button type="submit" class="btn btn-outline-dark mt-2" name="submit" value="addtocard" style="border-radius: 0; padding: 8px 20px;">
                            Add to cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<style>
    .product-image-link:hover .product-image-container {
        opacity: 0.4; /* Slightly fade the image on hover */
    }
    .product-image-link:hover .card-img {
        cursor: pointer; /* Show pointer cursor on hover */
    }
</style>

    </div>
                <div div="row">
                    <ul class="pagination pagination-lg justify-content-end">
                        <li class="page-item disabled">
                            <a class="page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0" href="#" tabindex="-1">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link rounded-0 shadow-sm border-top-0 border-left-0 text-dark" href="#">3</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

     <!-- Start Brands -->
     <!-- <section class="bg-light py-5"> -->
        <div class="container my-4">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="h1">Our Brands</h1>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        Lorem ipsum dolor sit amet.
                    </p>
                </div>
                <div class="col-lg-9 m-auto tempaltemo-carousel">
                    <div class="row d-flex flex-row">
                        <!--Controls-->
                        <div class="col-1 align-self-center">
                            <a class="h1" href="#multi-item-example" role="button" data-bs-slide="prev">
                                <i class="text-light fas fa-chevron-left"></i>
                            </a>
                        </div>
                        <!--End Controls-->

                        <!--Carousel Wrapper-->
                        <div class="col">
                            <div class="carousel slide carousel-multi-item pt-2 pt-md-0" id="multi-item-example" data-bs-ride="carousel">
                                <!--Slides-->
                                <div class="carousel-inner product-links-wap" role="listbox">

                                    <!--First slide-->
                                    <div class="carousel-item active">
                                        <div class="row">
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_01.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_02.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_03.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_04.png" alt="Brand Logo"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End First slide-->

                                    <!--Second slide-->
                                    <div class="carousel-item">
                                        <div class="row">
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_01.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_02.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_03.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_04.png" alt="Brand Logo"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End Second slide-->

                                    <!--Third slide-->
                                    <div class="carousel-item">
                                        <div class="row">
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_01.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_02.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_03.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_04.png" alt="Brand Logo"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End Third slide-->

                                </div>
                                <!--End Slides-->
                            </div>
                        </div>
                        <!--End Carousel Wrapper-->

                        <!--Controls-->
                        <div class="col-1 align-self-center">
                            <a class="h1" href="#multi-item-example" role="button" data-bs-slide="next">
                                <i class="text-light fas fa-chevron-right"></i>
                            </a>
                        </div>
                        <!--End Controls-->
                    </div>
                </div>
            </div>
        </div>
    <!-- </section> -->
    <!--End Brands -->

    <?php include "include/footer.php" ?>
     
    <!-- Start Script -->
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>
    
    <!-- Quantity and Cart Update Script -->
    <script>
        // Handle Add to Cart via AJAX (no redirect, no alert)
        document.querySelector('#product-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent page redirect
            const formData = new FormData(this);
            formData.append('action', 'add_to_cart');

            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.querySelector('.cart-count').textContent = data.cartCount; // Update cart count in header
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
    <!-- End Script -->
</body>
</html>