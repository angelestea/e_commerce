<?php

require_once 'models/category.php';
require_once 'models/product.php';

class CategoryController {

    public function index() {/*
        Utils::isAdmin();
        $category = new Category();
        $categories = $category->getAll();*/

        require_once 'views/category/index.php';
    }

    public function ver() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Conseguir categoria
            $categoria = new Categoria();
            $categoria->setId($id);
            $categoria = $categoria->getOne();

            // Conseguir productos;
            $producto = new Producto();
            $producto->setCategoria_id($id);
            $productos = $producto->getAllCategory();
        }

        require_once 'views/category/ver.php';
    }

    public function crear() {
        Utils::isAdmin();
        require_once 'views/categoria/crear.php';
    }

    public function save() {
        Utils::isAdmin();
        if (isset($_POST) && isset($_POST['nombre'])) {
            // Guardar la categoria en bd
            $categoria = new Categoria();
            $categoria->setNombre($_POST['nombre']);
            $save = $categoria->save();
        }
        header("Location:" . base_url . "categoria/index");
    }

}
