<?php

class Car {

    private $id_user;
    private $id_product;
    private $image;
    private $name;
    private $price;
    private $unities;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId_user() {
        return $this->id_user;
    }

    function getId_product() {
        return $this->id_product;
    }

    function getImage() {
        return $this->image;
    }

    function getName() {
        return $this->name;
    }

    function getPrice() {
        return $this->price;
    }

    function getUnities() {
        return $this->unities;
    }

    function setId_user($id_user) {
        $this->id_user = $id_user;
    }

    function setId_product($id_product) {
        $this->id_product = $id_product;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setUnities($unities) {
        $this->unities = $unities;
    }
    
    function search(){
        $sql = "SELECT * FROM cars WHERE id_user={$this->getId_user()};";
        
        $search = $this->db->query($sql);
        
//        echo $sql;
//        var_dump($search);
//        die();
        
        return $search;
        
    }
    
    function get__order(){
        $sql = "SELECT * FROM cars WHERE id_user={$this->getId_user()};";
        
        $get = $this->db->query($sql);
        
        return $get;
        
    }
    
    function delete__garbage(){
        
        $delete_garbage = "DELETE FROM cars WHERE unities<1;";
        
        $save = $this->db->query($delete_garbage);
        
//        var_dump($save);
//        die();
        
        $result = 0;
        if($save){
            $result = true;
        }
        return $result;
        
    }

    function pre__order() {
        //$sql_delete = "DELETE FROM cars WHERE id_user={$this->getId_user()}";
        
        //$this->delete__garbage();
        
        $sql_save = "INSERT INTO cars VALUES(NULL,{$this->getId_user()}, '{$this->getId_product()}','{$this->getImage()}', '{$this->getName()}', {$this->getPrice()}, {$this->getUnities()});";

        //$save = $this->db->query($sql_delete);
        //echo $sql_save;
       
        $save = $this->db->query($sql_save);

//        var_dump($save);
//        die();
        
        
        $sql_duplicate = "SELECT COUNT(id_user) as 'rows' FROM cars WHERE id_product={$this->getId_product()};";
        
        $duplicate = $this->db->query($sql_duplicate);
        $duplicate = $duplicate->fetch_object();
        $duplicate = $duplicate->rows;
        $duplicate = (int)$duplicate;
//        var_dump($duplicate);
//        die();
        
        if($duplicate > 1){
            $delete_duplicates = "DELETE FROM cars WHERE id_user={$this->getId_user()} LIMIT 1;";
            
            $delete_duplicates = $this->db->query($delete_duplicates);

//            die();
            //var_dump("Ok!");
        }//else{
//            var_dump("Bad");        
//        }
        
//        echo $sql;
//        die();

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    function delete__pre__order() {
        $sql = "DELETE FROM cars WHERE id_user={$this->getId_user()}";

        $delete = $this->db->query($sql);
        //echo $sql;

        $result = false;
        if ($delete) {
            $result = true;
            
            if ($result && isset($_SESSION['car'])) {
                unset($_SESSION['car']);
            }
        }
        return $result;
    }

    function delete__or__add__one__unit() {
        
        $this->delete__garbage();
        
        $sqlOne = "DELETE FROM cars WHERE id_user={$this->getId_user()} AND id_product={$this->getId_product()}";

        $sqlTwo = "INSERT INTO cars VALUES(NULL,{$this->getId_user()}, '{$this->getId_product()}','{$this->getImage()}', '{$this->getName()}', {$this->getPrice()}, {$this->getUnities()});";

//        echo $sqlTwo;
//        die();

        $updateOne = $this->db->query($sqlOne);

        //if ($updateOne) {
        $updateTwo = $this->db->query($sqlTwo);
        $result = false;
        
//        var_dump($updateTwo);
//        die();
        
        if ($updateTwo) {
            $result = true;
        }

        return $result;
    }
}