<<<<<<< HEAD
<?php
// website_raicenote/themes/js/api/recent-products.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    $db = new PDO('mysql:host=localhost;dbname=website_raicenote', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    
    $query = "SELECT product_id as id, name, price, image_url, created_at FROM products WHERE is_bundle = true ORDER BY  name";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'status' => 'success',
        'data' => $products
    ]);
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
=======
<?php
// website_raicenote/themes/js/api/recent-products.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    $db = new PDO('mysql:host=localhost;dbname=website_raicenote', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    
    $query = "SELECT product_id as id, name, price, image_url, created_at FROM products WHERE is_bundle = true ORDER BY  name";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'status' => 'success',
        'data' => $products
    ]);
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
}