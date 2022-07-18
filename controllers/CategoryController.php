<?php

require_once 'models/category.php';
require_once 'models/product.php';

class CategoryController {

    public function index() {
        Utils::isAdmin();
        $category = new Category();
        $categories = $category->getAll();

        require_once 'views/category/index.php';
    }

    public function see() {
        if(isset($_SESSION['re_login'])){
            unset($_SESSION['re_login']);
        }
        
        if (isset($_GET['id'])) {
            
            $id = $_GET['id'];

            // Conseguir categoria
            $category = new Category();
            $category->setId($id);
            $category = $category->getOne();
            
//            var_dump($category);
//            die();

            // Conseguir productos;
            $product = new Product();
            $product->setId_category($id);
            $products = $product->getAllProductsCategory();
        }
        require_once 'views/category/see.php';
    }

    public function create() {
        Utils::isAdmin();
        require_once 'views/category/create.php';
    }

    public function save() {
        Utils::isAdmin();
        
        if (isset($_POST) && isset($_POST['name'])) {
            // Guardar la categoria en bd
            $category = new Category();
            $category->setName($_POST['name']);
            $save = $category->save();
            
        }
        header("Location:". base_url . "category/index");
    }
}
