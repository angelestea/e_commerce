<?php

require_once 'models/order.php';
require_once 'models/car.php';
require_once 'models/product.php';

class OrderController {

    public function make() {

//        echo " All good!";
//        die();

        require_once 'views/order/do_order.php';
    }

    public function add() {
//        var_dump($_POST);
//        die();
        
        $totalPrice = isset($_SESSION['totalPrice']) ? (float)$_SESSION['totalPrice'] : false;
        //var_dump($totalPrice);
        
        if (isset($_SESSION['identity']) && !$totalPrice) {
            echo "Ok 1!";
            die();
            
            $status = Utils::carStatus();
            $id_user = $_SESSION['identity']->id;
            $province = isset($_POST['province']) ? $_POST['province'] : false;
            $location = isset($_POST['location']) ? $_POST['location'] : false;
            $address = isset($_POST['address']) ? $_POST['address'] : false;
            $price = isset($status['total']) ? $status['total'] : false;

            //Array de errores
            $errors = array();

            // Validar datos antes de guardarlos en la db
            //----------------------------------------preg_match().- comprubea si algun caract?r del string no es un n?mero
            // Names validation            
            if (!empty($id_user) && is_numeric($id_user)) {
                $id_user_validated = true;
            } else {
                $id_user_validated = false;
                $errors['id_user'] = "Id user not valid";
            }

            // Last names validation
            if (!empty($province) && !is_numeric($province) && !preg_match("/[0-9]/", $province)) {
                $province_validated = true;
            } else {
                $province_validated = false;
                $errors['province'] = "Province not valid";
            }

            // Email validation
            if (!empty($location)) {
                $location_validated = true;
            } else {
                $location_validated = false;
                $errors['location'] = "Location not valid";
            }

            // Password validation
            if (!empty($address)) {
                $address_validated = true;
            } else {
                $address_validated = false;
                $errors['address'] = "Address not valid";
            }

            if (!empty($price) && is_numeric($price)) {
                $price_validated = true;
            } else {
                $price_validated = false;
                $errors['price'] = "Price not valid";
            }

            $save_order = false;

//            var_dump($save_order);
//            var_dump($errors);
//            die();

            if (count($errors) == 0) {
                $save_order = true;


                // Guardar datos en bd
                $order = new Order();
                $order->setId_user($id_user);
                $order->setProvince($province);
                $order->setLocation($location);
                $order->setAddress($address);
                $order->setPrice($price);

//                var_dump($order);
//                die();

                $save = $order->save();

//                var_dump($save);
//                die();
                // Guardar linea pedido
                $save_line = $order->save_line();
                
                //$delete_garbage = $order->delete_garbage(date(),time());
                
                
                if ($save && $save_line) {
                    $_SESSION['order'] = "completed";
                } else {
                    $_SESSION['order'] = "failed";
                }
            } else {
                $_SESSION['order'] = "failed";
            }
            header("Location:".base_url.'order/confirmed');
        }elseif(isset($_SESSION['identity']) && isset($totalPrice)){
            echo "Ok 2!";
            //die();
            $id_user = $_SESSION['identity']->id;
            $province = isset($_POST['province']) ? $_POST['province'] : false;
            $location = isset($_POST['location']) ? $_POST['location'] : false;
            $address = isset($_POST['address']) ? $_POST['address'] : false;
            $price = isset($totalPrice) ? $totalPrice : false;
            
            //var_dump($address);
            //die();
            
            //Array de errores
            $errors = array();

            // Validar datos antes de guardarlos en la db
            //----------------------------------------preg_match().- comprubea si algun caract?r del string no es un n?mero
            // Names validation
            if (!empty($id_user) && is_numeric($id_user)) {
                $id_user_validated = true;
            } else {
                $id_user_validated = false;
                $errors['id_user'] = "Id user not valid";
            }

            // Last names validation
            if (!empty($province) && !is_numeric($province) && !preg_match("/[0-9]/", $province)) {
                $province_validated = true;
            } else {
                $province_validated = false;
                $errors['province'] = "Province not valid";
            }

            // Email validation
            if (!empty($location)) {
                $location_validated = true;
            } else {
                $location_validated = false;
                $errors['location'] = "Location not valid";
            }

            // Password validation
            if (!empty($address)) {
                $address_validated = true;
            } else {
                $address_validated = false;
                $errors['address'] = "Address not valid";
            }

            if (!empty($price) && is_numeric($price)) {
                $price_validated = true;
            } else {
                $price_validated = false;
                $errors['price'] = "Price not valid";
            }

            $save_order = false;

            //var_dump($save_order);
//            var_dump($errors);
//            die();

            if (count($errors) == 0) {
                $save_order = true;


                // Guardar datos en bd
                $order = new Order();
                $order->setId_user($id_user);
                $order->setProvince($province);
                $order->setLocation($location);
                $order->setAddress($address);
                $order->setPrice($price);

//                var_dump($order);
//                die();

                $save = $order->save();

//                var_dump($save);
//                die();
                //Guardar linea pedido
                $save_line = $order->save_line();

//                var_dump($save_line);
//                die();
//                $state_last_inserted = "SELECT state FROM orders WHERE id_user={$order->getId_user()} AND province='{$order->getProvince()}' AND location='{$order->getLocation()}' AND address='{$order->getAddress()}' AND price={$order->getPrice()};";
//                
//                $db = Database::connect();
//                
//                $state = $db->query($state_last_inserted)->fetch_object()->state;
//                echo $state_last_inserted;
//                var_dump($state);
//                die();                
//                
//                $delete_garbage = $order->delete_garbage($state,date(),time());
                                
                if ($save && $save_line) {
                    $_SESSION['order'] = "completed";
                } else {
                    $_SESSION['order'] = "failed";
                }
            } else {
                $_SESSION['order'] = "failed";
            }
//            echo "Ok add";
//            die();
            header("Location:".base_url.'order/confirmed');
        }else {
            // Redigir al index
            header("Location:". base_url);
        }
    }

    public function confirmed() {
        if (isset($_SESSION['identity'])) {
            
            $identity = $_SESSION['identity'];
            $order = new Order();
            $order->setId_user($identity->id);
            $id_user = $order->getId_user();
            $db = Database::connect();
            $sql = "SELECT SUM(price*unities) as 'total_price' FROM cars WHERE id_user={$id_user};";
            $price_products_in_car = $db->query($sql);
            $price_products_in_car = $price_products_in_car->fetch_object()->total_price;
            
            $sql_id_order = "SELECT id FROM orders WHERE id_user={$id_user} ORDER BY id DESC LIMIT 1;";
            //echo $sql_id_order;
            $id_order = (int)$db->query($sql_id_order)->fetch_object()->id;
//            var_dump($id_order);
//            die();
            
            //$id_order = (int)$id_order;
            
//            echo $sql_id_order;
//            var_dump($id_order);
//            die();
//            
//            var_dump($price_products_in_car);
            //die();
            $products = $order->getProductsByUser($id_user);
//            var_dump($products);
//            die();
            require_once 'views/order/confirmed.php';
        }else{
            require_once 'views/order/confirmed.php';
        }
    }

    public function my_orders() {
        Utils::isIdentity();
        $id_user = $_SESSION['identity']->id;
        $order = new Order();

        // Sacar los pedidos del usuario
        $order->setId_user($id_user);
        $orders = $order->getAllByUser();
        
        require_once 'views/order/my_orders.php';
    }

    public function detail() {
        Utils::isIdentity();

        if (isset($_GET['id'])) {
            $id_order = $_GET['id'];

            // Sacar orden
            $order = new Order();
            $order->setId($id_order);
            $products = $order->getProductInOrderLines($id_order);
            
            $order = $order->getOderByIdOrder($id_order);
            

            
//            var_dump($products->fetch_object()->id_product);
//            die();
            
            // Sacar order's products            
            $count = 0;
            $products_a = array();
            while ($pro = $products->fetch_object() /*&& $products->num_rows > $count*/):
                $product = new Product();
                               
                $product->setId($pro->id_product);
//                var_dump($product->getId());
//                die();
                $product = $product->getProductByOrderLines();
                $products_a[$count] = $product;
                $count++;
                
            endwhile;
            
//            var_dump($product_a[0]->fetch_object());
//            die();    
            
            require_once 'views/order/detail.php';
        } else {
            header('Location:' . base_url . 'order/myOrders');
        }
    }

    public function gestion() {
        Utils::isAdmin();
        $gestion = true;

        $order = new Order();
        $orders = $order->getAll();

        require_once 'views/order/my_orders.php';
    }

    public function state() {
        Utils::isAdmin();
        if (isset($_POST['id_order']) && isset($_POST['state'])) {
            // Recoger datos form
            $id = $_POST['id_order'];
            $state = $_POST['state'];

            // Upadate del pedido
            $order = new Order();
            $order->setId($id);
            $order->setState($state);
            $order->edit();

            header("Location:".base_url.'order/detail&id='.$id);
        } else {
            header("Location:" . base_url);
        }
    }
    
    

}
