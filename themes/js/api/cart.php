<<<<<<< HEAD
<?php
// Ensure we're sending JSON response
header('Content-Type: application/json');

// Start session
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if it's an AJAX request
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request method'
    ]);
    exit;
}

// Get the raw POST data
$rawData = file_get_contents('php://input');

// Decode JSON data
$data = json_decode($rawData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid JSON data'
    ]);
    exit;
}

$action = $data['action'] ?? '';

switch ($action) {
    case 'add':
        addToCart($data);
        break;
    case 'remove':
        removeFromCart($data);
        break;
    case 'update':
        updateQuantity($data);
        break;
    case 'get':
        getCart();
        break;
    default:
        echo json_encode([
            'success' => false,
            'error' => 'Invalid action'
        ]);
        exit;
}

function addToCart($data) {
    if (!isset($data['productId']) || empty($data['productId'])) {
        echo json_encode([
            'success' => false,
            'error' => 'Product ID is required'
        ]);
        return;
    }

    $productId = $data['productId'];
    $productName = $data['productName'] ?? '';
    $productPrice = floatval($data['productPrice'] ?? 0);
    $productImage = $data['productImage'] ?? '';

    // Check if product already exists in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['productId'] === $productId) {
            $item['quantity']++;
            $found = true;
            break;
        }
    }

    // Add new product if not found
    if (!$found) {
        $_SESSION['cart'][] = [
            'productId' => $productId,
            'productName' => $productName,
            'productPrice' => $productPrice,
            'productImage' => $productImage,
            'quantity' => 1
        ];
    }

    echo json_encode([
        'success' => true,
        'cart' => $_SESSION['cart'],
        'cartTotal' => calculateCartTotal(),
        'cartCount' => calculateCartCount()
    ]);
}

function removeFromCart($data) {
    $productId = $data['productId'] ?? '';

    $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($productId) {
        return $item['productId'] !== $productId;
    });

    // Reindex array after filtering
    $_SESSION['cart'] = array_values($_SESSION['cart']);

    echo json_encode([
        'success' => true,
        'cart' => $_SESSION['cart'],
        'cartTotal' => calculateCartTotal(),
        'cartCount' => calculateCartCount()
    ]);
}

function updateQuantity($data) {
    $productId = $data['productId'] ?? '';
    $quantity = intval($data['quantity'] ?? 0);

    if ($quantity <= 0) {
        removeFromCart(['productId' => $productId]);
        return;
    }

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['productId'] === $productId) {
            $item['quantity'] = $quantity;
            break;
        }
    }

    echo json_encode([
        'success' => true,
        'cart' => $_SESSION['cart'],
        'cartTotal' => calculateCartTotal(),
        'cartCount' => calculateCartCount()
    ]);
}

function getCart() {
    echo json_encode([
        'success' => true,
        'cart' => $_SESSION['cart'],
        'cartTotal' => calculateCartTotal(),
        'cartCount' => calculateCartCount()
    ]);
}

function calculateCartTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['productPrice'] * $item['quantity'];
    }
    return number_format($total, 2, '.', '');
}

function calculateCartCount() {
    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['quantity'];
    }
    return $count;
=======
<?php
// Ensure we're sending JSON response
header('Content-Type: application/json');

// Start session
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if it's an AJAX request
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request method'
    ]);
    exit;
}

// Get the raw POST data
$rawData = file_get_contents('php://input');

// Decode JSON data
$data = json_decode($rawData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid JSON data'
    ]);
    exit;
}

$action = $data['action'] ?? '';

switch ($action) {
    case 'add':
        addToCart($data);
        break;
    case 'remove':
        removeFromCart($data);
        break;
    case 'update':
        updateQuantity($data);
        break;
    case 'get':
        getCart();
        break;
    default:
        echo json_encode([
            'success' => false,
            'error' => 'Invalid action'
        ]);
        exit;
}

function addToCart($data) {
    if (!isset($data['productId']) || empty($data['productId'])) {
        echo json_encode([
            'success' => false,
            'error' => 'Product ID is required'
        ]);
        return;
    }

    $productId = $data['productId'];
    $productName = $data['productName'] ?? '';
    $productPrice = floatval($data['productPrice'] ?? 0);
    $productImage = $data['productImage'] ?? '';

    // Check if product already exists in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['productId'] === $productId) {
            $item['quantity']++;
            $found = true;
            break;
        }
    }

    // Add new product if not found
    if (!$found) {
        $_SESSION['cart'][] = [
            'productId' => $productId,
            'productName' => $productName,
            'productPrice' => $productPrice,
            'productImage' => $productImage,
            'quantity' => 1
        ];
    }

    echo json_encode([
        'success' => true,
        'cart' => $_SESSION['cart'],
        'cartTotal' => calculateCartTotal(),
        'cartCount' => calculateCartCount()
    ]);
}

function removeFromCart($data) {
    $productId = $data['productId'] ?? '';

    $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($productId) {
        return $item['productId'] !== $productId;
    });

    // Reindex array after filtering
    $_SESSION['cart'] = array_values($_SESSION['cart']);

    echo json_encode([
        'success' => true,
        'cart' => $_SESSION['cart'],
        'cartTotal' => calculateCartTotal(),
        'cartCount' => calculateCartCount()
    ]);
}

function updateQuantity($data) {
    $productId = $data['productId'] ?? '';
    $quantity = intval($data['quantity'] ?? 0);

    if ($quantity <= 0) {
        removeFromCart(['productId' => $productId]);
        return;
    }

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['productId'] === $productId) {
            $item['quantity'] = $quantity;
            break;
        }
    }

    echo json_encode([
        'success' => true,
        'cart' => $_SESSION['cart'],
        'cartTotal' => calculateCartTotal(),
        'cartCount' => calculateCartCount()
    ]);
}

function getCart() {
    echo json_encode([
        'success' => true,
        'cart' => $_SESSION['cart'],
        'cartTotal' => calculateCartTotal(),
        'cartCount' => calculateCartCount()
    ]);
}

function calculateCartTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['productPrice'] * $item['quantity'];
    }
    return number_format($total, 2, '.', '');
}

function calculateCartCount() {
    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['quantity'];
    }
    return $count;
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
}