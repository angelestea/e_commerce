<?php

class Product {

    private $id;
    private $id_category;
    private $name;
    private $description;
    private $price;
    private $stock;
    private $ofert;
    private $date;
    private $image;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getId_category() {
        return $this->id_category;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getPrice() {
        return $this->price;
    }

    function getStock() {
        return $this->stock;
    }

    function getOfert() {
        return $this->ofert;
    }

    function getDate() {
        return $this->date;
    }

    function getImage() {
        return $this->image;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setId_category($id_category) {
        $this->id_category = $id_category;
    }

    function setName($name) {
        $this->name = $this->db->real_escape_string($name);
    }

    function setDescription($description) {
        $this->description = $this->db->real_escape_string($description);
    }

    function setPrice($price) {
        $this->price = $this->db->real_escape_string($price);
    }

    function setStock($stock) {
        $this->stock = $this->db->real_escape_string($stock);
    }

    function setOfert($ofert) {
        $this->ofert = $this->db->real_escape_string($ofert);
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setImage($image) {
        $this->image = $image;
    }

    public function getAll() {
        $products = $this->db->query("SELECT * FROM products ORDER BY id DESC");
        return $products;
    }

    public function getProductByOrderLines(){
        $consult = "SELECT * FROM products p INNER JOIN order_lines ol ON ol.id_product = p.id WHERE p.id={$this->getId()}";
        //echo $consult;
        $product = $this->db->query($consult);
        return $product;
    }
    
    public function getAllProductsCategory() {
        $sql = "SELECT p.*, c.name AS 'category name' FROM products p "
                . "INNER JOIN categories c ON c.id = p.id_category "
                . "WHERE p.id_category = {$this->getId_category()} "
                . "ORDER BY id DESC";
        $products = $this->db->query($sql);
        return $products;
    }

    public function getRandom($limit) {
        $products = $this->db->query("SELECT * FROM products ORDER BY RAND() LIMIT $limit");
        return $products;
    }

    public function getOne() {
        $consult = "SELECT * FROM products WHERE id = {$this->getId()}";
        $product = $this->db->query($consult);
//        echo $consult;
//        var_dump($product);
//        die();
        return $product->fetch_object();
    }

    public function save() {

        $sql = "INSERT INTO products VALUES(NULL, {$this->getId_category()}, '{$this->getName()}', '{$this->getDescription()}', {$this->getPrice()}, {$this->getStock()}, NULL, CURDATE(), '{$this->getImage()}');";
        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
        $sql = "UPDATE products SET name='{$this->getName()}', description='{$this->getDescription()}', price={$this->getPrice()}, stock={$this->getStock()}, id_category={$this->getId_category()}  ";

        if ($this->getImage() != null) {
            $sql .= ", image='{$this->getImage()}'";
        }

        $sql .= " WHERE id={$this->id};";

        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function delete() {
        $sql = "DELETE FROM products WHERE id={$this->id}";
        $delete = $this->db->query($sql);

        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }
}
