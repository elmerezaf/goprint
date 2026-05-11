<?php
// Database connection handler for GoPrint system
// Connect to goprint_db with UTF8MB4 encoding
class ProductModel {
    private $db_connection;
    
    // Constructor: Initialize database connection
    public function __construct() {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db_name = "goprint_db";

        $this->db_connection = new mysqli($host, $user, $pass, $db_name);
        
        // Set character set to support Traditional Chinese
        $this->db_connection->set_charset("utf8mb4");
        
        // Check connection status
        if ($this->db_connection->connect_error) {
            die("Database connection failed: " . $this->db_connection->connect_error);
        }
    }

    // Get all product data from product table
    public function getAllProducts() {
        // Fixed: Removed ORDER BY id ASC (your table doesn't have an 'id' column)
        $sql_query = "SELECT * FROM product";
        $result = $this->db_connection->query($sql_query);
        
        $product_list = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product_list[] = $row;
            }
        }
        return $product_list;
    }

    // Close database connection
    public function closeConnection() {
        $this->db_connection->close();
    }
}
?>