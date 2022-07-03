<?php

class Order {

    private $id;
    private $id_user;
    private $province;
    private $location;
    private $address;
    private $price;
    private $state;
    private $date;
    private $hour;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getId_user() {
        return $this->id_user;
    }

    function getProvince() {
        return $this->province;
    }

    function getLocation() {
        return $this->location;
    }

    function getAddress() {
        return $this->address;
    }

    function getPrice() {
        return $this->price;
    }

    function getState() {
        return $this->state;
    }

    function getDate() {
        return $this->date;
    }

    function getHour() {
        return $this->hour;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setId_user($id_user) {
        $this->id_user = $id_user;
    }

    function setProvince($province) {
        $this->province = $this->db->real_escape_string($province);
    }

    function setLocation($location) {
        $this->location = $this->db->real_escape_string($location);
    }

    function setAddress($address) {
        $this->address = $this->db->real_escape_string($address);
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setState($state) {
        $this->state = $state;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setHour($hour) {
        $this->hour = $hour;
    }

    public function getAll() {
        $products = $this->db->query("SELECT * FROM orders ORDER BY id DESC");
        return $products;
    }

    public function getOne() {
        $product = $this->db->query("SELECT * FROM orders WHERE id = {$this->getId()}");
        return $product->fetch_object();
    }

    public function getOneByUser() {
        $sql = "SELECT o.id, o.price FROM orders o "
                //. "INNER JOIN order_lines ol ON ol.id_order = o.id "
                . "WHERE o.id_user = {$this->getId_user()} ORDER BY id DESC LIMIT 1";

//        echo $sql;
//        die();
                
        $order = $this->db->query($sql);

//        echo $this->db->error;
//        die();
        return $order->fetch_object();
    }

    public function getAllByUser() {
        $sql = "SELECT o.* FROM order o "
                . "WHERE o.id_user = {$this->getId_user()} ORDER BY id DESC";

        $order = $this->db->query($sql);

        return $order;
    }

    public function getProductsByOrder($id) {

        $sql = "SELECT pr.*, ol.unities FROM products pr "
                . "INNER JOIN order_lines ol ON pr.id = ol.id_product "
                . "WHERE ol.id_order={$id}";
                
//      echo $sql;
//      die();
        $products = $this->db->query($sql);

        return $products;
    }

    public function save() {
        $sql = "INSERT INTO orders VALUES(NULL, {$this->getId_user()}, '{$this->getProvince()}', '{$this->getLocation()}', '{$this->getAddress()}', {$this->getPrice()}, 'confirm', CURDATE(), CURTIME());";
        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function save_line() {
        $sql = "SELECT LAST_INSERT_ID() as 'order';";
        $query = $this->db->query($sql);
        $id_order = $query->fetch_object()->order;
        
//        var_dump($id_order);
//        die();

        foreach ($_SESSION['car'] as $element) {
            $product = $element['product'];

            $insert = "INSERT INTO order_lines VALUES(NULL, {$id_order}, {$product->id}, {$element['unities']})";
            $save = $this->db->query($insert);

//            var_dump($product);
//            var_dump($insert);
//            echo $this->db->error;
//            die();
        }

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
        $sql = "UPDATE pedidos SET estado='{$this->getEstado()}' ";
        $sql .= " WHERE id={$this->getId()};";

        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

}
