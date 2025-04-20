<<<<<<< HEAD
<?php
$category = isset($_POST['categories-list']) ? $_POST['categories-list'] : 'all';
$minPrice = isset($_POST['minPrice']) ? floatval($_POST['minPrice']) : 0;
$maxPrice = isset($_POST['maxPrice']) ? floatval($_POST['maxPrice']) : PHP_FLOAT_MAX;
$alcoholPercentage = isset($_POST['alcoholPercentage']) && $_POST['alcoholPercentage'] !== '' ? 
    floatval($_POST['alcoholPercentage']) : null;

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'website_raicenote';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the WHERE clause array
$conditions = array();

// Category filtering
if ($category !== 'all') {
    switch ($category) {
        case 'korean-makgeolli':
            $conditions[] = "category = 'Korean Rice Wine'";
            break;
        case 'japanese-sake':
            $conditions[] = "category = 'Japanese Rice Wine'";
            break;
        case 'chinese-rice-wine':
            $conditions[] = "category = 'Chinese Rice Wine'";
            break;
        case 'collection':
            $conditions[] = "category LIKE '%Bundle%'";
            break;
        case 'others':
            $conditions[] = "category NOT IN ('Korean Rice Wine', 'Japanese Rice Wine', 'Chinese Rice Wine') AND category NOT LIKE '%Bundle%'";
            break;
    }
}

// Price filtering
if ($minPrice !== '' && $maxPrice !== '') {
    $conditions[] = "price BETWEEN $minPrice AND $maxPrice";
}

// Alcohol percentage filtering
if ($alcoholPercentage !== null) {
    $conditions[] = "alcohol_percentage = $alcoholPercentage";
}

// Construct the final SQL query
$sql = "SELECT product_id, name, category, price, image_url FROM products";
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$result = $conn->query($sql);
$placeHolderImage = '../uploads/placeholder.jpg';

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productId = htmlspecialchars($row['product_id'], ENT_QUOTES, 'UTF-8');
        $productName = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
        $productPrice = number_format((float)$row['price'], 2, '.', '');
        $productImage = htmlspecialchars($row['image_url'], ENT_QUOTES, 'UTF-8') ?: $placeHolderImage;

        echo "
        <div class='col-sm-6 col-md-4 col-lg-4 mb-4'>
            <div class='card product-card'>
                <a href='product.php?product_id={$productId}'>
                    <img 
                        src='{$productImage}'
                        alt='{$productName}'
                        class='card-img-top product-image'
                        onerror='this.onerror=null; this.src=\"{$placeHolderImage}\"; this.className+=\" placeholder\"'
                    >
                </a>
                <div class='card-body'>
                    <h5 class='card-title'>{$productName}</h5>
                    <p class='card-text'>$ {$productPrice}</p>
                    <button class='btn btn-primary add-to-cart' data-product-id='{$productId}'>Add to Cart</button>
                </div>
            </div>
        </div>";
    }
} else {
    echo "<p class='text-center'>No products found. Please adjust your filters and try again.</p>";
}

$conn->close();
=======
<?php
$category = isset($_POST['categories-list']) ? $_POST['categories-list'] : 'all';
$minPrice = isset($_POST['minPrice']) ? floatval($_POST['minPrice']) : 0;
$maxPrice = isset($_POST['maxPrice']) ? floatval($_POST['maxPrice']) : PHP_FLOAT_MAX;
$alcoholPercentage = isset($_POST['alcoholPercentage']) && $_POST['alcoholPercentage'] !== '' ? 
    floatval($_POST['alcoholPercentage']) : null;

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'website_raicenote';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the WHERE clause array
$conditions = array();

// Category filtering
if ($category !== 'all') {
    switch ($category) {
        case 'korean-makgeolli':
            $conditions[] = "category = 'Korean Rice Wine'";
            break;
        case 'japanese-sake':
            $conditions[] = "category = 'Japanese Rice Wine'";
            break;
        case 'chinese-rice-wine':
            $conditions[] = "category = 'Chinese Rice Wine'";
            break;
        case 'collection':
            $conditions[] = "category LIKE '%Bundle%'";
            break;
        case 'others':
            $conditions[] = "category NOT IN ('Korean Rice Wine', 'Japanese Rice Wine', 'Chinese Rice Wine') AND category NOT LIKE '%Bundle%'";
            break;
    }
}

// Price filtering
if ($minPrice !== '' && $maxPrice !== '') {
    $conditions[] = "price BETWEEN $minPrice AND $maxPrice";
}

// Alcohol percentage filtering
if ($alcoholPercentage !== null) {
    $conditions[] = "alcohol_percentage = $alcoholPercentage";
}

// Construct the final SQL query
$sql = "SELECT product_id, name, category, price, image_url FROM products";
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$result = $conn->query($sql);
$placeHolderImage = '../uploads/placeholder.jpg';

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productId = htmlspecialchars($row['product_id'], ENT_QUOTES, 'UTF-8');
        $productName = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
        $productPrice = number_format((float)$row['price'], 2, '.', '');
        $productImage = htmlspecialchars($row['image_url'], ENT_QUOTES, 'UTF-8') ?: $placeHolderImage;

        echo "
        <div class='col-sm-6 col-md-4 col-lg-4 mb-4'>
            <div class='card product-card'>
                <a href='product.php?product_id={$productId}'>
                    <img 
                        src='{$productImage}'
                        alt='{$productName}'
                        class='card-img-top product-image'
                        onerror='this.onerror=null; this.src=\"{$placeHolderImage}\"; this.className+=\" placeholder\"'
                    >
                </a>
                <div class='card-body'>
                    <h5 class='card-title'>{$productName}</h5>
                    <p class='card-text'>$ {$productPrice}</p>
                    <button class='btn btn-primary add-to-cart' data-product-id='{$productId}'>Add to Cart</button>
                </div>
            </div>
        </div>";
    }
} else {
    echo "<p class='text-center'>No products found. Please adjust your filters and try again.</p>";
}

$conn->close();
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
?>