<?php

require_once 'models/product.php';
require_once 'models/car.php';

class CarController {

    public function index() {
        Utils::isLogin();
        $id_user = $_SESSION['identity']->id;
        $dataValue = Utils::showDataBase($id_user);
        if (isset($_SESSION['car']) && count($_SESSION['car']) >= 1) {

            //var_dump($_SESSION['car']);
            $car = $_SESSION['car'];

            if ($dataValue) {
//                echo "Ok!";
//                die();
                $dataValue = $this->pre__order();
                require_once 'views/car/index.php';
            }
            require_once 'views/car/index.php';
        } else {
            require_once 'views/car/index.php';
        }
    }

    public function add() {

        if (isset($_GET['id'])) {
            $id_product = $_GET['id'];
        } else {
            header("Location: " . base_url);
        }


        if (isset($_SESSION['car'])) {

            $counter = 0;

            foreach ($_SESSION['car'] as $index => $element) {
                if ($element['id_product'] == $id_product) {
                    $_SESSION['car'][$index]['unities'] ++;
                    $counter++;

                    $car = new Car();
                    $car->setId_user($_SESSION['identity']->id);
                    $car->setId_product($id_product);
                    $car->setImage($element['product']->image);
                    $car->setName($element['product']->name);
                    $car->setPrice($_SESSION['car'][$index]['price']);
                    $car->setUnities($_SESSION['car'][$index]['unities']);

                    $sum = $car->delete__or__add__one__unit();
                }
            }
        }

        if (!isset($counter) || $counter == 0) {
            //Get product
            $product = new Product();
            $product->setId($id_product);

            $product = $product->getOne();

//            var_dump($product);
//            die();

            if (is_object($product)) {
                $_SESSION['car'][] = array(
                    "id_product" => $product->id,
                    "price" => $product->price,
                    "unities" => 1,
                    "product" => $product
                );
            }
        }

        header("Location:" . base_url . "car/index");
    }

    public function remove() {


        if (isset($_GET['index'])) {
            $index = $_GET['index'];
            unset($_SESSION['car'][$index]);

            $db = Database::connect();
            $sql = "DELETE FROM cars WHERE id_product={$index} AND id_user={$_SESSION['identity']->id};";
            echo $sql;
            $delete_product = $db->query($sql);

            var_dump($delete_product);
        }//elseif(isset($_SESSION['car']) && count($_SESSION['car']) == 0){
        //$this->delete__all();
        //}//else {
//            $db = Database::connect();
//            $sql = "SELECT unities FROM cars WHERE id_product={$_GET['index']};";
//            echo $sql;
//            $unities = $db->query($sql);
//            
//            echo $unities;
//            die();
//            
//        }

        header("Location:" . base_url . "car/index");
    }

    public function delete__all() {
        unset($_SESSION['car']);
        if (isset($_SESSION['re_login'])) {
            unset($_SESSION['re_login']);
        }

        if (isset($_SESSION['identity'])) {
            $car = new Car();
            $id_user = $_SESSION['identity']->id;

            //var_dump($id_user);

            $car->setId_user($id_user);

            //var_dump($car->getUnities());

            $delete = $car->delete__pre__order();
            if ($delete) {
                unset($_SESSION['car']);
                header("Location: " . base_url . "car/index");
            }
        }
    }

    public function up() {
        if (isset($_GET['index']) && !isset($_GET['data'])) {

            $index = $_GET['index'];
            $_SESSION['car'][$index]['unities'] ++;

            $car = new Car();
            $id_user = $_SESSION['identity']->id;
            $id_product = $_SESSION['car'][$index]['id_product'];
            $product_name = $_SESSION['car'][$index]['product']->name;
            $product_unities = $_SESSION['car'][$index]['unities'];

            //var_dump($product_unities);

            $car->setId_user($id_user);
            $car->setId_product($id_product);
            $car->setName($product_name);
            $car->setUnities($product_unities);

            //var_dump($car->getUnities());
            $sum = $car->delete__or__add__one__unit();
            //$save = $car->pre__order();
        } else {

            //var_dump($_GET['data']);
            //die();
            if (isset($_SESSION['identity'])):
                $id_user = $_SESSION['identity']->id;
                $id_product = $_GET['id_product'];
                $product_name = $_GET['product_name'];
                $product_price = (float) $_GET['product_price'];
                $product_unities = $_GET['product_unities'] + 1;

                //            var_dump($product_price);
                //            die();
                //var_dump($product_unities);
                $car = new Car();
                $car->setId_user($id_user);
                $car->setId_product($id_product);
                $car->setName($product_name);
                $car->setPrice($product_price);
                $car->setUnities($product_unities);

                if (isset($_GET['image'])) {
                    $image = $_GET['image'];
                    $car->setImage($image);
                }


                //var_dump($car->getUnities());
                $sum = $car->delete__or__add__one__unit();
            //            var_dump($sum);
            //die();
            else:
                header("Location:" . base_url . "car/index");
            endif;
        }
        header("Location:" . base_url . "car/index");
    }

    public function down() {
        if (isset($_GET['index']) && !isset($_GET['data'])) {
            $index = $_GET['index'];
            $_SESSION['car'][$index]['unities'] --;

            $car = new Car();
            $id_user = $_SESSION['identity']->id;
            $id_product = $_SESSION['car'][$index]['id_product'];
            $product_name = $_SESSION['car'][$index]['product']->name;
            $product_unities = $_SESSION['car'][$index]['unities'];

            //var_dump($product_unities);

            $car->setId_user($id_user);
            $car->setId_product($id_product);
            $car->setName($product_name);
            $car->setUnities($product_unities);

            //var_dump($car->getUnities());
            $delete = $car->delete__or__add__one__unit();
            //$save = $car->pre__order();

            if ($_SESSION['car'][$index]['unities'] == 0) {
//                $delete__all = $car->delete__pre__order();
                unset($_SESSION['car'][$index]);
            }
        } else {
//            echo "Ok!";
//            die();
            $id_user = $_SESSION['identity']->id;
            $id_product = $_GET['id_product'];
            $product_name = $_GET['product_name'];
            $product_price = (float) $_GET['product_price'];
            $product_unities = $_GET['product_unities'] - 1;
            $product_image = $_GET['image'];

//            var_dump($product_price);
//            die();
            //var_dump($product_unities);
            $car = new Car();
            $car->setId_user($id_user);
            $car->setId_product($id_product);
            $car->setName($product_name);
            $car->setPrice($product_price);
            $car->setUnities($product_unities);
            $car->setImage($product_image);

            //var_dump($car->getUnities());
            $sum = $car->delete__or__add__one__unit();
            //die();
        }
        header("Location:" . base_url . "car/index");
    }

    public function pre__order() {
        Utils::isIdentity();
//        var_dump($_SESSION['car']);
//        die();
        $count = 0;
        if (isset($_SESSION['identity']) && !isset($dataValue)) {
            foreach ($_SESSION['car'] as $index => $element) {
                $car = new Car();
                $id_user = $_SESSION['identity']->id;
                $id_product = $element['id_product'];
                $image = $element['product']->image;
                $product_name = $element['product']->name;
                $product_price = number_format($element['product']->price);
                $product_unities = $element['unities'];
                $count = $count + 1;
                //var_dump($product_unities);

                $car->setId_user($id_user);
                $car->setId_product($id_product);
                $car->setImage($image);
                $car->setName($product_name);
                $car->setPrice($product_price);
                $car->setUnities($product_unities);

                //var_dump($car->getUnities());

                $save = $car->pre__order();

                var_dump($save);
                //die();
            }
            unset($_SESSION['car']);
            //var_dump($count);
            //die();

            if (!isset($_SESSION['car'])) {

                $car = new Car();
                $car->setId_user($_SESSION['identity']->id);

                $orders = $car->get__order();
                return $orders;
                var_dump($orders);
                //echo "Hi ";
                //die();
            }
        } else {
            echo "Ok!";
            die();
        }
    }

}
