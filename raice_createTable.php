<?php
// Database configuration
$host = 'localhost';
$username = 'root';  // default WAMP username
$password = '';      // default WAMP password
$database = 'website_raicenote';

try {
    // Create database connection
    $conn = new mysqli($host, $username, $password);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $database";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully<br>";
    } else {
        echo "Error creating database: " . $conn->error . "<br>";
    }
    
    // Select the database
    $conn->select_db($database);
    
    // Create tables
    $tables = array();
    
    $tables[] = "CREATE TABLE IF NOT EXISTS users (
        user_id INT NOT NULL AUTO_INCREMENT,
        email VARCHAR(255) NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        phone VARCHAR(15),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        is_admin BOOLEAN DEFAULT FALSE,
        address TEXT,
        date_of_birth DATE,
        PRIMARY KEY (user_id)
    )";

    $tables[] = "CREATE TABLE IF NOT EXISTS products (
        product_id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10, 2) NOT NULL,
        stock_quantity INT DEFAULT 0,
        category VARCHAR(100),
        is_active BOOLEAN DEFAULT TRUE,
        ingredients TEXT,
        alcohol_percentage FLOAT,
        aging_period INT,
        production_guidelines TEXT,
        is_bundle BOOLEAN DEFAULT FALSE,
        product_type VARCHAR(100),
        PRIMARY KEY (product_id)
    )";

    $tables[] = "CREATE TABLE IF NOT EXISTS bundle_items (
        bundle_item_id INT NOT NULL AUTO_INCREMENT,
        bundle_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT DEFAULT 1,
        individual_price DECIMAL(10, 2),
        notes TEXT,
        PRIMARY KEY (bundle_item_id),
        FOREIGN KEY (bundle_id) REFERENCES products(product_id),
        FOREIGN KEY (product_id) REFERENCES products(product_id)
    )";

    $tables[] = "CREATE TABLE IF NOT EXISTS orders (
        order_id INT NOT NULL AUTO_INCREMENT,
        user_id INT NOT NULL,
        order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        total_amount DECIMAL(10, 2) NOT NULL,
        status VARCHAR(50),
        shipping_address TEXT,
        payment_status VARCHAR(50),
        tracking_number VARCHAR(100),
        PRIMARY KEY (order_id),
        FOREIGN KEY (user_id) REFERENCES users(user_id)
    )";

    $tables[] = "CREATE TABLE IF NOT EXISTS order_items (
        order_item_id INT NOT NULL AUTO_INCREMENT,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT DEFAULT 1,
        unit_price DECIMAL(10, 2),
        subtotal DECIMAL(10, 2),
        PRIMARY KEY (order_item_id),
        FOREIGN KEY (order_id) REFERENCES orders(order_id),
        FOREIGN KEY (product_id) REFERENCES products(product_id)
    )";

    $tables[] = "CREATE TABLE IF NOT EXISTS events (
        event_id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        start_time DATETIME NOT NULL,
        end_time DATETIME,
        capacity INT,
        price DECIMAL(10, 2),
        location VARCHAR(255),
        event_type VARCHAR(100),
        requirements TEXT,
        is_active BOOLEAN DEFAULT TRUE,
        PRIMARY KEY (event_id)
    )";

    $tables[] = "CREATE TABLE IF NOT EXISTS bookings (
        booking_id INT NOT NULL AUTO_INCREMENT,
        user_id INT NOT NULL,
        event_id INT NOT NULL,
        number_of_participants INT DEFAULT 1,
        total_amount DECIMAL(10, 2),
        status VARCHAR(50),
        booking_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        special_requests TEXT,
        PRIMARY KEY (booking_id),
        FOREIGN KEY (user_id) REFERENCES users(user_id),
        FOREIGN KEY (event_id) REFERENCES events(event_id)
    )";

    $tables[] = "CREATE TABLE IF NOT EXISTS production_batches (
        batch_id INT NOT NULL AUTO_INCREMENT,
        product_id INT NOT NULL,
        start_date DATE,
        expected_completion DATE,
        quantity_produced INT,
        status VARCHAR(50),
        batch_number VARCHAR(100),
        notes TEXT,
        target_alcohol_percentage FLOAT,
        recipe_variation TEXT,
        expected_yield INT,
        quality_grade VARCHAR(50),
        PRIMARY KEY (batch_id),
        FOREIGN KEY (product_id) REFERENCES products(product_id)
    )";

    $tables[] = "CREATE TABLE IF NOT EXISTS production_logs (
        log_id INT NOT NULL AUTO_INCREMENT,
        batch_id INT NOT NULL,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
        action VARCHAR(100),
        description TEXT,
        recorded_by VARCHAR(100),
        temperature FLOAT,
        humidity FLOAT,
        quality_checks TEXT,
        phase VARCHAR(50),
        adjustments_made TEXT,
        PRIMARY KEY (log_id),
        FOREIGN KEY (batch_id) REFERENCES production_batches(batch_id)
    )";

    $tables[] = "CREATE TABLE IF NOT EXISTS inventory (
        inventory_id INT NOT NULL AUTO_INCREMENT,
        product_id INT NOT NULL,
        batch_id INT NOT NULL,
        quantity INT,
        storage_location VARCHAR(255),
        expiry_date DATE,
        batch_number VARCHAR(100),
        status VARCHAR(50),
        production_date DATE,
        quality_status VARCHAR(50),
        PRIMARY KEY (inventory_id),
        FOREIGN KEY (product_id) REFERENCES products(product_id),
        FOREIGN KEY (batch_id) REFERENCES production_batches(batch_id)
    )";

    $tables[] = "CREATE TABLE IF NOT EXISTS reviews (
        review_id INT NOT NULL AUTO_INCREMENT,
        user_id INT NOT NULL,
        reference_id INT,
        review_type VARCHAR(50),
        rating INT CHECK (rating >= 1 AND rating <= 5),
        comment TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        is_verified BOOLEAN DEFAULT FALSE,
        pros TEXT,
        cons TEXT,
        experience_level VARCHAR(50),
        PRIMARY KEY (review_id),
        FOREIGN KEY (user_id) REFERENCES users(user_id)
    )";

    $tables[] = "CREATE TABLE IF NOT EXISTS recipes (
        recipe_id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        instructions TEXT,
        ingredients TEXT,
        difficulty_level INT CHECK (difficulty_level >= 1 AND difficulty_level <= 5),
        duration_days INT,
        notes TEXT,
        is_public BOOLEAN DEFAULT FALSE,
        PRIMARY KEY (recipe_id)
    )";

    // Execute each table creation query
    foreach ($tables as $table) {
        if ($conn->query($table) === TRUE) {
            echo "Table created successfully<br>";
        } else {
            echo "Error creating table: " . $conn->error . "<br>";
        }
    }

    echo "All tables created successfully!";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>