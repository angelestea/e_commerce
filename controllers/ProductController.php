<?php

require_once 'models/product.php';

class ProductController {

    public function index() {

        $product = new Product();
        $products = $product->getRandom(6);



        // Renderizar vista
        require_once 'views/product/highlights.php';
    }

    public function see() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $product = new Product();
            $product->setId($id);

            $product= $product->getOne();
        }
        require_once 'views/product/see.php';
    }

    public function gestion() {
        Utils::isAdmin();

        $product = new Product();
        $products = $product->getAll();

        require_once 'views/product/gestion.php';
    }

    public function create() {
        Utils::isAdmin();
        require_once 'views/product/create.php';
    }

    public function save() {
        Utils::isAdmin();
        if (isset($_POST)) {


            $name = isset($_POST['name']) ? $_POST['name'] : false;
            $description = isset($_POST['description']) ? $_POST['description'] : false;
            $price = isset($_POST['price']) ? $_POST['price'] : false;
            $stock = isset($_POST['stock']) ? $_POST['stock'] : false;
            $category = isset($_POST['category']) ? $_POST['category'] : false;
            $image = isset($_POST['image']) ? $_POST['image'] : false;

            $errors = array();

            // Validar datos antes de guardarlos en la db
            //----------------------------------------preg_match().- comprubea si algun caract?r del string no es un n?mero
            // Names validation
            if (!empty($name) && !is_numeric($name) && !preg_match("/[0-9]/", $name)) {
                $name_validated = true;
            } else {
                $name_validated = false;
                $errors['name'] = "Name is not valid";
            }

            // Last names validation
            if (!empty($description)) {
                $description_validated = true;
            } else {
                $description_validated = false;
                $errors['description'] = "Description not valid";
            }

            // Email validation
            if (!empty($price) && is_numeric($price)) {
                $price_validated = true;
            } else {
                $price_validated = false;
                $errors['email'] = "Email is empty";
            }


            $save_user = false;

            // Cuando no exista errores, se inserta en la tabla correspondiente de la db
            if (count($errors) == 0) {

                $save_user = true;


                $category = intval($category);

                $product = new Product();
                $product->setName($name);
                $product->setDescription($description);
                $product->setPrice($price);
                $product->setStock($stock);
                $product->setId_category($category);

                // Guardar la imagen
                if (isset($_FILES['image'])) {//-----------puede estar $_FILES['image'] tanto como $_FILES
                    $file = $_FILES['image'];
                    $filename = $file['name'];
                    $mimetype = $file['type'];

//                var_dump($file);
//                die();

                    if ($mimetype == "image/jpg" || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif') {

//                    var_dump($filename);
//                    die();

                        if (!is_dir('uploads/images')) //---------si no existe directorio uploads/imafes, se lo crea.
                            mkdir('uploads/images', 0777, true); //-------se crea directorio con permiso, 0777 y true para directorios recursivos
                    }

                    move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename);
                    $product->setImage($filename);
                }

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $product->setId($id);

                    $save = $product->edit();
                } else {
                    $save = $product->save();
                }


                if ($save) {
                    $_SESSION['product'] = "complete";
                } else {
                    $_SESSION['product'] = "failed";
                }
            }

            /* if (isset($_GET['id'])) {
              $id = $_GET['id'];
              $product->setId($id);

              $save = $product->edit();
              } else {
              $save = $product->save();
              } */
        } else {
            $_SESSION['product'] = "failed";
        }
        header('Location:' . base_url . 'product/gestion');
    }

    public function edit() {
        Utils::isAdmin();
//        var_dump($_GET);
//        die();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $edit = true;

            $product = new Product();
            $product->setId($id);

            $pro = $product->getOne();
            $save = $product->edit();

            $result = false;
            if ($save) {
                $result = true;
            }

            require_once 'views/product/create.php';
        } else {
            header('Location:' . base_url . 'product/gestion');
        }
    }

    public function delete() {
        Utils::isAdmin();

//        var_dump($_GET);
//        die();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $product = new Product();
            $product->setId($id);

            $delete = $product->delete();

            if ($delete) {
                $_SESSION['delete'] = 'complete';
            } else {
                $_SESSION['delete'] = 'failed';
            }
        } else {
            $_SESSION['delete'] = 'failed';
        }

        header('Location:' . base_url . 'product/gestion');
    }

}
