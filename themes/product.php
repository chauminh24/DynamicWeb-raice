<<<<<<< HEAD
<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'website_raicenote';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the product ID from the URL
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

// Fetch product details from the database
$query = "SELECT * FROM products WHERE product_id = ? AND is_active = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Product not found!";
    exit;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../uploads/images/favicon.png" type="image/png">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <!-- jQuery from Google CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link href="css/style.css" rel="stylesheet">

    <style>
        .btn-outline-dark {
            color: white;
            border-color: white;
        }

        .product-image {
            max-height: 400px;
            object-fit: cover;
        }

        .product-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
        }

        .product-description {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
        }

        .product-price {
            font-size: 1.5rem;
        }

        .product-details {
            font-size: 1rem;
            line-height: 1.6;
        }

        .product-details strong {
            font-weight: 600;
        }

        .product-details .text-danger {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <header class="header" id="header" style="background-color: rgba(0, 0, 0, 0.886);">
        <button class="menu-toggle">
            <span class="burger">
                <span class="burger-line"></span>
            </span>
            <span class="toggle-text">Menu</span>
        </button>

        <div class="logo"><a href="shop_main.html"><img src="../uploads/images/Asset 3-8.png"></a></div>

        <div class="header-right" style="display: flex;">
            <div class="search-container">
                <button class="search-toggle">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>

            <!-- Shopping Cart Section -->
            <div class="cart-container">
                <a class="cart-table">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2 11h13l3-8H6"></path>
                    </svg>
                    <span class="cart-count">0</span>
                </a>
            </div>
        </div>
    </header>

    <div class="search-input-container">
        <input type="text" class="search-input" placeholder="Search...">
        <button class="search-close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <nav class="nav-menu">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="event.html">Events</a></li>
            <li><a href="shop_main.html">Shop</a></li>
            <li><a href="#contact">Contact</a></li>
            <li>
                <div class="auth-buttons">
                    <!-- This div's content will be updated by JavaScript -->
                </div>
            </li>
        </ul>
    </nav>
    <?php $placeHolderImage = '../uploads/placeholder.jpg'; ?>
    <div class="container py-5">
        <!-- Main Content -->
        <div class="main-content container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                        class="product-image"
                        onerror="this.onerror=null; this.src='<?php echo htmlspecialchars($placeHolderImage, ENT_QUOTES, 'UTF-8'); ?>';">
                </div>
                <div class="col-md-6 col-12 ps-4">
                    <h1 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                    <p class="product-description mb-4"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    <p class="card-text">$<?php echo number_format($product['price'], 2); ?></p>

                    <?php if ($product['stock_quantity'] > 0): ?>
                        <button class="add-to-cart btn btn-primary btn-lg"
                            data-product-id="<?php echo $product['product_id']; ?>">
                            Add to Cart
                        </button>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg" disabled>Out of Stock</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>


        <!-- Product Details -->
        <div class="product-details bg-light p-4 rounded shadow-sm">
            <p class="product-stock mb-3">
                <strong>Stock:</strong>
                <?php echo $product['stock_quantity'] > 0 ? $product['stock_quantity'] . ' available' : '<span class="text-danger">Out of stock</span>'; ?>
            </p>
            <p class="product-category mb-3">
                <strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?>
            </p>
            <p class="product-alcohol mb-3">
                <strong>Alcohol Percentage:</strong>
                <?php echo ($product['alcohol_percentage'] !== null) ?
                    htmlspecialchars($product['alcohol_percentage']) . '%' :
                    'For more details, please contact our hotline at 1-800-XXX-XXXX'; ?>
            </p>
            <p class="product-aging mb-3">
                <strong>Aging Period:</strong>
                <?php echo ($product['aging_period'] !== null) ?
                    htmlspecialchars($product['aging_period']) :
                    'For more details, please contact our hotline at 1-800-XXX-XXXX'; ?>
            </p>
            <p class="product-ingredients mb-3">
                <strong>Ingredients:</strong> <?php echo htmlspecialchars($product['ingredients']); ?>
            </p>
            <p class="product-guidelines mb-3">
                <strong>Production Guidelines:</strong> <?php echo nl2br(htmlspecialchars($product['production_guidelines'])); ?>
            </p>
            <?php if ($product['is_bundle']): ?>
                <p class="product-type mb-0">
                    <strong>Note:</strong> This product is part of a bundle.
                </p>
            <?php endif; ?>
        </div>
    </div>
    </div>
    </div>
</body>
<!-- Footer Section -->
<footer class="text-light py-5" style="background-color: black;">
    <div class="container">
        <div class="row">

            <!-- Column 1: Shop -->
            <div class="col-6 col-lg-3">
                <h5><a href="#" class="footer-link text-uppercase">SHOP</a></h5>
                <ul class="list-unstyled footer-list">
                    <li><a href="#" class="text-light">Best Sellers</a></li>
                    <li><a href="#" class="text-light">Seasonal Specials</a></li>
                    <li><a href="#" class="text-light">Korean Makgeolli</a></li>
                    <li><a href="#" class="text-light">Japanese Sake</a></li>
                </ul>

                <h5><a href="#" class="footer-link text-uppercase">Events</a></h5>
                <h5><a href="#" class="footer-link text-uppercase">Contact Us</a></h5>
                <h5><a href="#" class="footer-link text-uppercase">ABOUT US</a></h5>

            </div>


            <!-- Column 2: Address -->
            <div class="col-6 col-lg-4 ">
                <h5 class="text-uppercase mb-4">Our Location</h5>
                <p class="text-light" style="font-size: smaller;">123 Main Street, Suite 100, City, Country</p>
                <a href="https://www.google.com/maps" target="_blank" class="btn btn-light btn-sm mt-3">GET DIRECTIONS
                    &rarr;</a>
                <h5 class="mt-3"><a href="#" class="text-light">Social Media</h5>
                <div class="social-media-icons mt-3">
                    <a href="#" class="text-light me-3"><i class="bi bi-facebook" style="font-size: 20px;"></i></a>
                    <a href="#" class="text-light me-3"><i class="bi bi-instagram" style="font-size: 20px;"></i></a>
                    <a href="#" class="text-light me-3"><i class="bi bi-twitter" style="font-size: 20px;"></i></a>
                </div>

            </div>

            <!-- Column 3: Newsletter Subscription -->
            <div class="col-lg-5 mt-5">
                <h5 class="text-uppercase">want more of raicé?</h5>
                <p class="mb-4" style="font-size: smaller;">Get our email. Letters from our brewers, new products,
                    coming-up events, workshop, and more. Not too often - just enough</p>
                <form action="#" method="post">
                    <div class="input-group" style="height: 3em;">
                        <input type="email" class="form-control rounded-0 custom-input" placeholder="EMAIL"
                            aria-label="Email" required>
                        <button class="btn custom-button" type="submit">SIGN UP</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
    <div class="cart-sidebar" id="cartSidebar" style="color: black;">
        <div class="cart-header">
            <h4>Your Cart</h4>
            <button class="close-cart">&times;</button>
        </div>
        <div class="cart-items" id="cartItems">
            <!-- Dynamically populated cart items will go here -->
        </div>
        <div class="cart-summary">
            <div class="total">
                <span>Total:</span>
                <span id="cartTotal"></span>
            </div>
            <button class="btn btn-primary checkout-btn" id="checkoutButton" onclick="checkAuthStatusForCheckout()">Checkout</button>
            </div>
    </div>
</footer>

<script src="js/cart.js"></script>
<script src="js/styling.js"></script>
<script src="js/auth.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



=======
<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'website_raicenote';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the product ID from the URL
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

// Fetch product details from the database
$query = "SELECT * FROM products WHERE product_id = ? AND is_active = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Product not found!";
    exit;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../uploads/images/favicon.png" type="image/png">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <!-- jQuery from Google CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link href="css/style.css" rel="stylesheet">

    <style>
        .btn-outline-dark {
            color: white;
            border-color: white;
        }

        .product-image {
            max-height: 400px;
            object-fit: cover;
            max-width: 100%;
        }

        .product-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
        }

        .product-description {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
        }

        .product-price {
            font-size: 1.5rem;
        }

        .product-details {
            font-size: 1rem;
            line-height: 1.6;
        }

        .product-details strong {
            font-weight: 600;
        }

        .product-details .text-danger {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <header class="header" id="header" style="background-color: rgba(0, 0, 0, 0.886);">
        <button class="menu-toggle">
            <span class="burger">
                <span class="burger-line"></span>
            </span>
            <span class="toggle-text">Menu</span>
        </button>

        <div class="logo"><a href="shop_main.html"><img src="../uploads/images/Asset 3-8.png"></a></div>

        <div class="header-right" style="display: flex;">
            <div class="search-container">
                <button class="search-toggle">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>

            <!-- Shopping Cart Section -->
            <div class="cart-container">
                <a class="cart-table">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2 11h13l3-8H6"></path>
                    </svg>
                    <span class="cart-count">0</span>
                </a>
            </div>
        </div>
    </header>

    <div class="search-input-container">
        <input type="text" class="search-input" placeholder="Search...">
        <button class="search-close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <nav class="nav-menu">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="event.html">Events</a></li>
            <li><a href="shop_main.html">Shop</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li>
                <div class="auth-buttons">
                    <!-- This div's content will be updated by JavaScript -->
                </div>
            </li>
        </ul>
    </nav>
    <?php $placeHolderImage = '../uploads/placeholder.jpg'; ?>
    <div class="container py-5">
        <!-- Main Content -->
        <div class="main-content container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                        class="product-image "
                        onerror="this.onerror=null; this.src='<?php echo htmlspecialchars($placeHolderImage, ENT_QUOTES, 'UTF-8'); ?>';">
                </div>
                <div class="col-12 ps-4 col-md-6">
                    <h1 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                    <p class="product-description mb-4"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    <p class="card-text">$<?php echo number_format($product['price'], 2); ?></p>

                    <?php if ($product['stock_quantity'] > 0): ?>
                        <button class="add-to-cart btn btn-primary btn-lg"
                            data-product-id="<?php echo $product['product_id']; ?>">
                            Add to Cart
                        </button>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg" disabled>Out of Stock</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>


        <!-- Product Details -->
        <div class="product-details bg-light p-4 rounded shadow-sm">
            <p class="product-stock mb-3">
                <strong>Stock:</strong>
                <?php echo $product['stock_quantity'] > 0 ? $product['stock_quantity'] . ' available' : '<span class="text-danger">Out of stock</span>'; ?>
            </p>
            <p class="product-category mb-3">
                <strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?>
            </p>
            <p class="product-alcohol mb-3">
                <strong>Alcohol Percentage:</strong>
                <?php echo ($product['alcohol_percentage'] !== null) ?
                    htmlspecialchars($product['alcohol_percentage']) . '%' :
                    'For more details, please contact our hotline at 1-800-XXX-XXXX'; ?>
            </p>
            <p class="product-aging mb-3">
                <strong>Aging Period:</strong>
                <?php echo ($product['aging_period'] !== null) ?
                    htmlspecialchars($product['aging_period']) :
                    'For more details, please contact our hotline at 1-800-XXX-XXXX'; ?>
            </p>
            <p class="product-ingredients mb-3">
                <strong>Ingredients:</strong> <?php echo htmlspecialchars($product['ingredients']); ?>
            </p>
            <p class="product-guidelines mb-3">
                <strong>Production Guidelines:</strong> <?php echo nl2br(htmlspecialchars($product['production_guidelines'])); ?>
            </p>
            <?php if ($product['is_bundle']): ?>
                <p class="product-type mb-0">
                    <strong>Note:</strong> This product is part of a bundle.
                </p>
            <?php endif; ?>
        </div>
    </div>
    </div>
    </div>
</body>
<!-- Footer Section -->
<footer class="text-light py-5" style="background-color: black;">
    <div class="container">
        <div class="row">

            <!-- Column 1: Shop -->
            <div class="col-6 col-lg-3">
                <h5><a href="#" class="footer-link text-uppercase">SHOP</a></h5>
                <ul class="list-unstyled footer-list">
                    <li><a href="#" class="text-light">Best Sellers</a></li>
                    <li><a href="#" class="text-light">Seasonal Specials</a></li>
                    <li><a href="#" class="text-light">Korean Makgeolli</a></li>
                    <li><a href="#" class="text-light">Japanese Sake</a></li>
                </ul>

                <h5><a href="#" class="footer-link text-uppercase">Events</a></h5>
                <h5><a href="#" class="footer-link text-uppercase">Contact Us</a></h5>
                <h5><a href="#" class="footer-link text-uppercase">ABOUT US</a></h5>

            </div>


            <!-- Column 2: Address -->
            <div class="col-6 col-lg-4 ">
                <h5 class="text-uppercase mb-4">Our Location</h5>
                <p class="text-light" style="font-size: smaller;">123 Main Street, Suite 100, City, Country</p>
                <a href="https://www.google.com/maps" target="_blank" class="btn btn-light btn-sm mt-3">GET DIRECTIONS
                    &rarr;</a>
                <h5 class="mt-3"><a href="#" class="text-light">Social Media</h5>
                <div class="social-media-icons mt-3">
                    <a href="#" class="text-light me-3"><i class="bi bi-facebook" style="font-size: 20px;"></i></a>
                    <a href="#" class="text-light me-3"><i class="bi bi-instagram" style="font-size: 20px;"></i></a>
                    <a href="#" class="text-light me-3"><i class="bi bi-twitter" style="font-size: 20px;"></i></a>
                </div>

            </div>

            <!-- Column 3: Newsletter Subscription -->
            <div class="col-lg-5 mt-5">
                <h5 class="text-uppercase">want more of raicé?</h5>
                <p class="mb-4" style="font-size: smaller;">Get our email. Letters from our brewers, new products,
                    coming-up events, workshop, and more. Not too often - just enough</p>
                <form action="#" method="post">
                    <div class="input-group" style="height: 3em;">
                        <input type="email" class="form-control rounded-0 custom-input" placeholder="EMAIL"
                            aria-label="Email" required>
                        <button class="btn custom-button" type="submit">SIGN UP</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
    <div class="cart-sidebar" id="cartSidebar" style="color: black;">
        <div class="cart-header">
            <h4>Your Cart</h4>
            <button class="close-cart">&times;</button>
        </div>
        <div class="cart-items" id="cartItems">
            <!-- Dynamically populated cart items will go here -->
        </div>
        <div class="cart-summary">
            <div class="total">
                <span>Total:</span>
                <span id="cartTotal"></span>
            </div>
            <button class="btn btn-primary checkout-btn" id="checkoutButton" onclick="checkAuthStatusForCheckout()">Checkout</button>
            </div>
    </div>
</footer>

<script src="js/cart.js"></script>
<script src="js/styling.js"></script>
<script src="js/auth.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
</html>