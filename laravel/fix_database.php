<?php
// Connect to database to create missing tables
$host = '127.0.0.1';
$dbname = 'goprint_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully!\n";

    // Create category table
    $sql1 = "CREATE TABLE IF NOT EXISTS category (
        cat_id int(11) NOT NULL PRIMARY KEY,
        cat_name varchar(50) NOT NULL,
        cat_desc text DEFAULT NULL,
        create_time datetime DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Product Categories'";
    $pdo->exec($sql1);
    echo "Category table created!\n";

    // Create product table
    $sql2 = "CREATE TABLE IF NOT EXISTS product (
        pro_id int(11) NOT NULL PRIMARY KEY,
        cat_id int(11) NOT NULL,
        pro_name varchar(100) NOT NULL,
        pro_price decimal(10,2) NOT NULL,
        pro_stock int(11) DEFAULT 999,
        pro_desc text DEFAULT NULL,
        create_time datetime DEFAULT current_timestamp(),
        pro_image varchar(255) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Product List'";
    $pdo->exec($sql2);
    echo "Product table created!\n";

    // Insert sample data
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM category");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO category (cat_id, cat_name, cat_desc) VALUES
            (1, 'Business Printing', 'Business cards, flyers, brochures, books'),
            (2, 'Packaging Design', 'Gift boxes, bags, labels, cartons')");
        echo "Categories inserted!\n";
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM product");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO product (pro_id, cat_id, pro_name, pro_price, pro_stock, pro_desc) VALUES
            (1, 1, 'Premium Business Cards', 98.00, 999, '300g coated paper, double-sided color printing'),
            (2, 1, 'A4 Flyer Printing', 150.00, 999, '1000 sheets high definition fast printing'),
            (3, 2, 'Product Packaging Box', 299.00, 999, 'Custom corrugated packaging free design'),
            (4, 1, 'A4 Color Flyers', 200.00, 1000, '157g coated paper, full color, same day delivery'),
            (5, 2, 'Corporate Business Cards', 150.00, 500, '300g coated paper, double-sided, free design')");
        echo "Products inserted!\n";
    }

    echo "All done!\n";

} catch(PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}