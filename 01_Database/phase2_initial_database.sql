-- GoPrint Hong Kong Printing E-commerce Core Database Tables
CREATE TABLE goprint_products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(255) NOT NULL,
    product_category ENUM('Business Card', 'Flyer', 'Poster', 'Brochure', 'Banner') NOT NULL,
    base_price DECIMAL(10,2) NOT NULL,
    paper_material VARCHAR(150),
    print_size VARCHAR(150),
    description TEXT,
    create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE goprint_customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(30),
    delivery_address TEXT,
    register_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE goprint_orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    shipping_type ENUM('In-store Pickup', 'Local Home Delivery') NOT NULL,
    order_status ENUM('Pending', 'Processing', 'Printing', 'Completed') DEFAULT 'Pending',
    order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES goprint_customers(id)
);