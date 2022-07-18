<?php

require_once 'models/car.php';

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
        $sql = "SELECT o.* FROM orders o "
                . "WHERE o.id_user = {$this->getId_user()} ORDER BY id DESC";

        $order = $this->db->query($sql);

//        echo $sql; die();

        return $order;
    }

    public function getProductsByUser($id_user) {

        $sql = "SELECT pr.*, c.unities FROM products pr "
                . "INNER JOIN cars c ON pr.id = c.id_product "
                . "WHERE c.id_user={$id_user};";

//      echo $sql;
//      die();
        $products = $this->db->query($sql);
        //echo $sql;
        //var_dump($products);
        //die();

        return $products;
    }
    
    public function getProductInOrderLines(){
        $sql = "SELECT * FROM order_lines WHERE id_order={$this->id}";
        //echo $sql;
        $products = $this->db->query($sql);
        
        if($products){
            return $products;
        }
    }

    public function getOderByIdOrder($id_order) {
        $sql = "SELECT * FROM orders WHERE id={$id_order}";

        $order = $this->db->query($sql)->fetch_object();

//        var_dump($order);
//        die();
        return $order;
    }

    public function save() {
        $sql = "INSERT INTO orders VALUES(NULL, {$this->getId_user()}, '{$this->getProvince()}', '{$this->getLocation()}', '{$this->getAddress()}', {$this->getPrice()}, 'confirm', CURDATE(), CURTIME());";
        $save = $this->db->query($sql);

//        echo $sql;
//        var_dump($save);
//        die();

        $result = false;
        if ($save) {
            $result = $save;
        }
        return $result;
    }

    public function delete_garbage($state, $date, $hour) {
        $sql = "DELETE FROM orders WHERE province='{$this->getProvince()}' AND location='{$this->getLocation()}' AND address='{$this->getAddress()}' AND price={$this->getPrice()} AND state='{$state}' AND date='{$date}' AND hour='{$hour}');";
        echo $sql;
        die();
    }

    public function save_line() {
        $sql = "SELECT LAST_INSERT_ID() as 'order';";
        $query = $this->db->query($sql);
        $id_order = $query->fetch_object()->order;

//        var_dump($id_order);
//        die();

        $result = true;

        if (isset($_SESSION['car'])) {

            foreach ($_SESSION['car'] as $element) {
                $product = $element['product'];

                $insert = "INSERT INTO order_lines VALUES(NULL, {$id_order}, {$product->id}, {$element['unities']})";
                $save = $this->db->query($insert);

//            var_dump($product);
//            var_dump($insert);
//            echo $this->db->error;
//            die();
            }
        } else {

            $car = new Car();
            $id_user = $_SESSION['identity']->id;
            $car->setId_user($id_user);

//                $order_line = "SELECT * FROM orders WHERE id_user={$id_user}";
//                $order_line = $this->db->query($order_line);
//                
//                var_dump($order_line);
//                die();

            $order = $car->search();
            var_dump($order);
            //die();                


            while ($ord = $order->fetch_object()):
                $sql = "INSERT INTO order_lines VALUES(NULL, {$id_order}, {$ord->id_product}, {$ord->unities});";
                //echo $sql;

                $detail_inserted = $this->db->query($sql);

                if (!$detail_inserted) {
                    $result = false;
                }
                
//                var_dump($detail_inserted);
//                die();
            endwhile;
        }
        return $result;
    }

    public function edit() {
        $sql = "UPDATE orders SET state='{$this->getState()}' ";
        $sql .= " WHERE id={$this->getId()};";

        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

}
