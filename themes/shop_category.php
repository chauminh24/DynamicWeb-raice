<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'website_raicenote';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch unique categories from the products table
$category_query = "SELECT DISTINCT category FROM products ORDER BY category";
$category_result = mysqli_query($conn, $category_query);

$categories = [
    'Korean Rice Wine',
    'Japanese Rice Wine',
    'Chinese Rice Wine',
    'Collections', // For all bundles
    'Others'       // For any ungrouped categories
];
$grouped_categories = [];

while ($category = mysqli_fetch_assoc($category_result)) {
    $current_category = $category['category'];
    if (strpos($current_category, 'Bundle') !== false) {
        $grouped_categories['Collections'][] = $current_category;
    } elseif (in_array($current_category, $categories)) {
        $grouped_categories[$current_category][] = $current_category;
    } else {
        $grouped_categories['Others'][] = $current_category;
    }
}

// Fetch unique alcohol percentages
$alcohol_query = "SELECT DISTINCT ROUND(alcohol_percentage, 1) AS alcohol_percentage FROM products ORDER BY alcohol_percentage";
$alcohol_result = mysqli_query($conn, $alcohol_query);
$alcohol_percentages = [];
while ($row = mysqli_fetch_assoc($alcohol_result)) {
    if ($row['alcohol_percentage'] !== null) {
        $alcohol_percentages[] = $row['alcohol_percentage'];
    }
}

// Fetch unique price tags
$price_query = "SELECT DISTINCT price FROM products ORDER BY price";
$price_result = mysqli_query($conn, $price_query);
$prices = [];
while ($row = mysqli_fetch_assoc($price_result)) {
    $prices[] = $row['price'];
}

$min_price = min($prices);
$max_price = max($prices);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../uploads/images/favicon.png" type="image/png">
    <title>Shop | RaicéNote Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <!-- jQuery from Google CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <style>
        h2 {
            font-weight: 800;
        }

        .footer-link a {
            padding-bottom: 30px;
        }

        .header {
            background-color: #E9E9EB !important;
            color: black !important;
        }

        .menu-toggle,
        .search-toggle,
        .burger {
            color: black !important;
        }

        .burger::before,
        .burger::after,
        .burger-line {
            background-color: black;
        }

        .nav-menu,
        .nav-menu a {
            background-color: #E6E6E8;
            color: black;
        }

        .navbar-dark {
            background-color: #E9E9EB;
        }

        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-body .mt-auto {
            margin-top: auto;
        }

        .card-img-top {
            object-fit: cover;
            height: 200px;
            width: 100%;
        }

        #categories-list option:checked {
            background-color: #A09380;
            /* Example color */
            color: white;
        }

        .list-group-item.active {
            background-color: #A09380;
            color: #fff;
            font-weight: bold;
            border-color: #A09380;
        }

        .list-group-item.active:hover {
            background-color: #A09380;
            color: #fff;
        }

        .price-slider {
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .price-slider input[type="range"] {
            width: 100%;
            margin: 10px 0;
        }

        .price-display {
            margin-top: 10px;
            font-size: 1.2em;
        }

        /* styles.css */
        .product-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 100%;
            height: 200px;
            /* Adjust as needed */
            object-fit: cover;
        }

        .card-body {
            text-align: center;
        }


        @media (max-width: 767px) {
            .filter-collapse {
                margin-bottom: 20px;
            }

            .card-text {
                font-size: small;
            }
        }
    </style>
</head>

<body>
    <header class="header" id="header">
        <button class="menu-toggle">
            <span class="burger">
                <span class="burger-line"></span>
            </span>
            <span class="toggle-text">Shop</span>
        </button>

        <div class="logo"><a href="index.html"><img src="../uploads/images/Asset 4-8.png"></a></div>

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
            <li><a href="events.html">Events</a></li>
            <li><a href="shop_main.html">Shop</a></li>
            <li><a href="#contact">Contact</a></li>
            <li>
                <div class="auth-buttons">
                    <!-- This div's content will be updated by JavaScript -->
                </div>
            </li>
        </ul>
    </nav>
    <div class="landscape-media">
        <img alt="RaicéNote Commercial" data-testid="prism-image" draggable="false" fetchpriority="high" loading="eager"
            src="/uploads/video/raice10s.gif"
            style="object-position:center center;width: 100%; height: 40vw; object-fit: cover;" />
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Filter Sidebar (Collapsible on Small Screens) -->
            <div class="col-md-3">
                <div class="filter-collapse">
                    <button class="btn btn-outline-primary w-100 d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterSidebar" aria-expanded="false" aria-controls="filterSidebar">
                        Filter Categories <i class="bi bi-funnel"></i>
                    </button>
                    <div class="collapse d-md-block filter-sidebar" id="filterSidebar">
                        <div class="card card-body">
                            <form id='product_form' action="/submit">
                                <h5>Categories</h5>
                                <div class="list-group">
                                    <select id="categories-list" class="categories-list" name="categories-list" size="6" style="overflow: hidden;" onchange="updateProductStatus()">
                                        <option class="list-group-item list-group-item-action" data-category="all" selected>All Categories</option>
                                        <?php foreach ($categories as $display_category): ?>
                                            <option class="list-group-item list-group-item-action" data-category="<?= htmlspecialchars($display_category, ENT_QUOTES, 'UTF-8') ?>">
                                                <?= htmlspecialchars($display_category, ENT_QUOTES, 'UTF-8') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>

                                <hr>

                                <h5>Filters</h5>
                                <div class="accordion" id="filterAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="priceHeader">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#priceFilter">
                                                Price Range
                                            </button>
                                        </h2>
                                        <div id="priceFilter">
                                            <div class="price-slider">
                                                <input type="range" id="minPrice" name="minPrice" onchange="updateProductStatus()" min="<?php echo $min_price; ?>" max="<?php echo $max_price; ?>" value="<?php echo $min_price; ?>">
                                                <input type="range" id="maxPrice" name="maxPrice" onchange="updateProductStatus()" min="<?php echo $min_price; ?>" max="<?php echo $max_price; ?>" value="<?php echo $max_price; ?>">
                                                <div class="price-display">
                                                    <span id="minPriceValue"></span> - <span id="maxPriceValue"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Add this inside the #filterAccordion div, after the price filter -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="alcoholHeader">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#alcoholFilter">
                                                Alcohol Percentage
                                            </button>
                                        </h2>
                                        <div id="alcoholFilter" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <select class="alcoholPercentage" id="alcoholPercentage" name="alcoholPercentage" style="width: 100%;" onchange="updateProductStatus()">
                                                    <option value="" selected>All Alcohol Percentages</option>
                                                    <?php foreach ($alcohol_percentages as $percentage): ?>
                                                        <option value="<?php echo htmlspecialchars($percentage, ENT_QUOTES, 'UTF-8'); ?>">
                                                            <?php echo htmlspecialchars($percentage, ENT_QUOTES, 'UTF-8'); ?>%
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Product Grid -->
            <div class="col-md-9">
                <div class="row mt-4" id="product-list">
                    <?php
                    $placeHolderImage = '../uploads/placeholder.jpg';
                    // Assuming your database connection and query here
                    $sql = "SELECT product_id, name, price, image_url FROM products";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-sm-6 col-md-4 col-lg-4 mb-4">
                    <div class="card product-card">
                        <img 
                            src="' . htmlspecialchars($row['image_url'], ENT_QUOTES, 'UTF-8') . '"
                            alt="' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '"
                            class="card-img-top product-image"
                            onerror="this.onerror=null; this.src=\'' . htmlspecialchars($placeHolderImage, ENT_QUOTES, 'UTF-8') . '\'; this.className+=\' placeholder\'"
                        >
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</h5>
                            <p class="card-text">$' . number_format((float)$row['price'], 2, '.', '') . '</p>
                            <button class="btn btn-primary add-to-cart" data-product-id="' . htmlspecialchars($row['product_id'], ENT_QUOTES, 'UTF-8') . '">Add to Cart</button>
                        </div>
                    </div>
                  </div>';
                        }
                    } else {
                        echo "No products found.";
                    }

                    $conn->close();
                    ?>
                </div>

            </div>
        </div>
    </div>
    <div class="cart-sidebar" id="cartSidebar">
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
                <span id="cartTotal">€0.00</span>
            </div>
            <button class="btn btn-primary checkout-btn" id="checkoutButton" onclick="isLogIn()">Checkout</button>
        </div>
    </div>
</body>
<footer class="text-light py-5" style="background-color: black;">
    <div id="footer-logo" class="d-flex justify-content-center align-items-center my-4"><img src="../uploads/images/Asset 6-8.png" class="mb-5" style="width: auto; height: 8em;"></div>
    <div class="container">
        <div class="eyebrow mt-4">
            <div class="line" style="background-color: white !important;"></div>
        </div>
        <div class="row">

            <!-- Column 1: Shop -->
            <div class="col-6 col-lg-3">
                <h5><a href="#" class="footer-link text-uppercase">SHOP</a></h5>
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
</footer>
<script src="js/cart.js"></script>
<script src="js/styling.js"></script>
<script src="js/auth.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add click event listener to the filter toggle button
        const filterToggleBtn = document.querySelector('[data-bs-target="#filterSidebar"]');
        const filterSidebar = document.getElementById('filterSidebar');

        if (filterToggleBtn && filterSidebar) {
            filterToggleBtn.addEventListener('click', function() {
                filterSidebar.classList.toggle('show');
            });
        }

        const minPriceSlider = document.getElementById('minPrice');
        const maxPriceSlider = document.getElementById('maxPrice');
        const minPriceValue = document.getElementById('minPriceValue');
        const maxPriceValue = document.getElementById('maxPriceValue');

        const updatePriceDisplay = () => {
            const minPrice = Math.min(parseInt(minPriceSlider.value), parseInt(maxPriceSlider.value));
            const maxPrice = Math.max(parseInt(minPriceSlider.value), parseInt(maxPriceSlider.value));
            minPriceSlider.value = minPrice;
            maxPriceSlider.value = maxPrice;
            minPriceValue.textContent = `€${minPrice}`;
            maxPriceValue.textContent = `€${maxPrice}`;
        };

        minPriceSlider.addEventListener('input', updatePriceDisplay);
        maxPriceSlider.addEventListener('input', updatePriceDisplay);

        // Initialize display
        updatePriceDisplay();
    });

    function updateProductStatus() {
        const formData = new FormData(document.getElementById('product_form'));

        fetch('js/api/filter.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Network response was not ok');
            })
            .then(data => {
                document.getElementById('product-list').innerHTML = data;
            })
            .catch((error) => {
                console.error('Error:', error);
            });

    }
</script>
</html>