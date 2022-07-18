<?php

class Utils {

    public static function deleteSession($name) {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }

        return $name;
    }

    public static function isAdmin() {
        if (!isset($_SESSION['admin'])) {
            header("Location:".base_url);
        } else {
            return true;
        }
    }
    
    public static function isIdentity() {
        if (!isset($_SESSION['identity'])) {
            header("Location:" . base_url);
        } else {
            return true;
        }
    }
    
    public static function isLogin(){
        if (!isset($_SESSION['identity'])) {
            $_SESSION['re_login'] = true;
            header("Location:" . base_url.'user/loginRequired');
        } else {
            return true;
        }
    }

    public static function showCategories() {
        require_once 'models/category.php';
        $category = new Category();
        $categories = $category->getAll();
        return $categories;
    }

    public static function carStatus() {
        $status = array(
            'products' => 0,
            'total' => 0
        );

        if (isset($_SESSION['car'])) {
            $status['products'] = count($_SESSION['car']);

            foreach ($_SESSION['car'] as $product) {
                $status['total'] += $product['price'] * $product['unities'];
            }
        }

        return $status;
    }

    public static function showStatus($status) {
        $value = 'earring';

        if ($status == 'confirm') {
            $value = 'earring';
        } elseif ($status == 'preparation') {
            $value = 'in preparation';
        } elseif ($status == 'ready') {
            $value = 'preparated to send';
        } elseif ($status = 'sended') {
            $value = 'sended';
        }

        return $value;
    }
    
    public static function searchIdOrderByUser($id_user){
        
        $db = Database::connect();
        $sql = "SELECT id FROM orders WHERE id_user={$id_user} ORDER BY id DESC LIMIT 1";
                  
        $data = $db->query($sql);
        
        if($data){
            return $data;
        } 
        
    }
    
    public static function showDataBase($id_user){
        $db = Database::connect();
        $sql = "SELECT * FROM cars WHERE id_user={$id_user}";
                                                                        
        $data = $db->query($sql);
        
        if($data){
            return $data;
        }   
    }
}
