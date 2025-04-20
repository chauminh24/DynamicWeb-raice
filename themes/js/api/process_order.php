<<<<<<< HEAD
<?php
// Database connection settings
$host = 'localhost';
$dbname = 'website_raicenote';
$username = 'root';
$password = '';

// Response function
function sendResponse($success, $message = '', $data = null) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    sendResponse(false, 'Database connection error: ' . $e->getMessage());
}

// Get JSON data from request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate input
if (!$data || !isset($data['items']) || empty($data['items'])) {
    sendResponse(false, 'Invalid order data');
}

try {
    // Start transaction
    $pdo->beginTransaction();

    // Insert order
    $stmt = $pdo->prepare(
        "INSERT INTO orders (
            user_id, full_name, order_date, total_amount, 
            status, shipping_address, payment_status, 
            tracking_number
        ) VALUES (
            :user_id, :full_name, NOW(), :total_amount, 
            'Pending', :shipping_address, 'Unpaid', 
            :tracking_number
        )"
    );

    // Assume user_id 1 for now - replace with actual user authentication
    $stmt->execute([
        ':user_id' => 1,
        ':full_name' => $data['fullName'],
        ':total_amount' => $data['totalAmount'],
        ':shipping_address' => implode(', ', [
            $data['address'], 
            $data['city'], 
            $data['postalCode'], 
            $data['country']
        ]),
        ':tracking_number' => $data['trackingNumber']
    ]);

    // Get the last inserted order ID
    $orderId = $pdo->lastInsertId();

    // Insert order items and update product stock
    $orderItemStmt = $pdo->prepare(
        "INSERT INTO order_items (
            order_id, product_id, quantity, 
            unit_price, subtotal
        ) VALUES (
            :order_id, :product_id, :quantity, 
            :unit_price, :subtotal
        )"
    );

    $stockUpdateStmt = $pdo->prepare(
        "UPDATE products 
         SET stock_quantity = stock_quantity - :quantity 
         WHERE product_id = :product_id AND stock_quantity >= :quantity"
    );

    foreach ($data['items'] as $item) {
        // Insert order item
        $orderItemStmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $item['productId'],
            ':quantity' => $item['productQuantity'],
            ':unit_price' => $item['productPrice'],
            ':subtotal' => $item['productPrice'] * $item['productQuantity']
        ]);

        // Update product stock
        $stockUpdateStmt->execute([
            ':product_id' => $item['productId'],
            ':quantity' => $item['productQuantity']
        ]);

        // Check if stock update failed (insufficient stock)
        if ($stockUpdateStmt->rowCount() == 0) {
            throw new Exception("Insufficient stock for product ID: {$item['productId']}");
        }
    }

    // Commit transaction
    $pdo->commit();

    // Send success response
    sendResponse(true, 'Order processed successfully', [
        'orderId' => $orderId,
        'trackingNumber' => $data['trackingNumber']
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $pdo->rollBack();
    sendResponse(false, 'Order processing failed: ' . $e->getMessage());
=======
<?php
// Database connection settings
$host = 'localhost';
$dbname = 'website_raicenote';
$username = 'root';
$password = '';

// Response function
function sendResponse($success, $message = '', $data = null) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    sendResponse(false, 'Database connection error: ' . $e->getMessage());
}

// Get JSON data from request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate input
if (!$data || !isset($data['items']) || empty($data['items'])) {
    sendResponse(false, 'Invalid order data');
}

try {
    // Start transaction
    $pdo->beginTransaction();

    // Insert order
    $stmt = $pdo->prepare(
        "INSERT INTO orders (
            user_id, full_name, order_date, total_amount, 
            status, shipping_address, payment_status, 
            tracking_number
        ) VALUES (
            :user_id, :full_name, NOW(), :total_amount, 
            'Pending', :shipping_address, 'Unpaid', 
            :tracking_number
        )"
    );

    // Assume user_id 1 for now - replace with actual user authentication
    $stmt->execute([
        ':user_id' => 1,
        ':full_name' => $data['fullName'],
        ':total_amount' => $data['totalAmount'],
        ':shipping_address' => implode(', ', [
            $data['address'], 
            $data['city'], 
            $data['postalCode'], 
            $data['country']
        ]),
        ':tracking_number' => $data['trackingNumber']
    ]);

    // Get the last inserted order ID
    $orderId = $pdo->lastInsertId();

    // Insert order items and update product stock
    $orderItemStmt = $pdo->prepare(
        "INSERT INTO order_items (
            order_id, product_id, quantity, 
            unit_price, subtotal
        ) VALUES (
            :order_id, :product_id, :quantity, 
            :unit_price, :subtotal
        )"
    );

    $stockUpdateStmt = $pdo->prepare(
        "UPDATE products 
         SET stock_quantity = stock_quantity - :quantity 
         WHERE product_id = :product_id AND stock_quantity >= :quantity"
    );

    foreach ($data['items'] as $item) {
        // Insert order item
        $orderItemStmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $item['productId'],
            ':quantity' => $item['productQuantity'],
            ':unit_price' => $item['productPrice'],
            ':subtotal' => $item['productPrice'] * $item['productQuantity']
        ]);

        // Update product stock
        $stockUpdateStmt->execute([
            ':product_id' => $item['productId'],
            ':quantity' => $item['productQuantity']
        ]);

        // Check if stock update failed (insufficient stock)
        if ($stockUpdateStmt->rowCount() == 0) {
            throw new Exception("Insufficient stock for product ID: {$item['productId']}");
        }
    }

    // Commit transaction
    $pdo->commit();

    // Send success response
    sendResponse(true, 'Order processed successfully', [
        'orderId' => $orderId,
        'trackingNumber' => $data['trackingNumber']
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $pdo->rollBack();
    sendResponse(false, 'Order processing failed: ' . $e->getMessage());
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
}