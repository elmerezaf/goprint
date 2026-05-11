<?php
// Controller layer: Coordinate model and view
// Core logic handler for product module
require_once __DIR__ . '/../model/ProductModel.php';
require_once __DIR__ . '/../view/ProductView.php';

class ProductController {
    private $product_model;
    private $product_view;

    // Initialize model and view
    public function __construct() {
        $this->product_model = new ProductModel();
        $this->product_view = new ProductView();
    }

    // Execute business logic: Get data and display page
    public function showAllProducts() {
        $product_data = $this->product_model->getAllProducts();
        $this->product_view->renderProductList($product_data);
        $this->product_model->closeConnection();
    }
}

// Initialize controller and run function
$controller = new ProductController();
$controller->showAllProducts();
?>