<?php

require_once 'models/user.php';

class UserController {

    public function index() {
        echo "User controller";
    }

    public function loginRequired(){
        require_once 'views/user/login.php';
    }
    
    public function register() {
        require_once 'views/user/register.php';
    }

    public function save() {
        if (isset($_POST)) {


            $name = isset($_POST['name']) ? $_POST['name'] : false;
            $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : false;
            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;

            //Array de errores
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
            if (!empty($last_name) && !is_numeric($last_name) && !preg_match("/[0-9]/", $last_name)) {
                $last_name_validated = true;
            } else {
                $last_name_validated = false;
                $errors['last_name'] = "Last names are not valid";
            }

            // Email validation
            if (!empty($email)) {
                $email_validated = true;
            } else {
                $email_validated = false;
                $errors['email'] = "Email is empty";
            }

            // Password validation
            if (!empty($password)) {
                $password_validated = true;
            } else {
                $password_validated = false;
                $errors['password'] = "Password is empty";
            }

            $save_user = false;

            if (count($errors) == 0) {
                $save_user = true;

                if ($name && $last_name && $email && $password) {
                    $user = new User();
                    $user->setName($name);
                    $user->setLast_name($last_name);
                    $user->setEmail($email);
                    $user->setPassword($password);

                    $save = $user->save();
                    var_dump($save);


                    if ($save) {
                        $_SESSION['register'] = "complete";
                    } else {
                        $_SESSION['register'] = "failed";
                        var_dump($_SESSION['register'] . " 1");
                        die();
                    }
                } else {
                    $_SESSION['register'] = "failed";
                    var_dump($_SESSION . " 2");
                    die();
                }
            } else {
                $_SESSION['register'] = "failed";
                var_dump($_SESSION . " 3");
                die();
            }
            header("Location:" . base_url . 'user/register');
        }
    }

    public function login() {
        if (isset($_POST)) {
            // Identificar al usuario
            // Consulta a la base de datos
            $user = new User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);

            $identity = $user->login();

//            var_dump($identity);
//            die();

            if ($identity && is_object($identity)) {
                $_SESSION['identity'] = $identity;

                if ($identity->role == 'admin') {
                    $_SESSION['admin'] = true;
                }
                
                if(isset($_SESSION['re_login'])){
                    unset($_SESSION['re_login']);
                }
                
            } else {
                $_SESSION['error_login'] = 'Failed identification';
            }
        }
        header("Location:". base_url);
    }

    public function logout() {
        if (isset($_SESSION['identity'])) {
            unset($_SESSION['identity']);
        }

        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }
        
//        var_dump($_SESSION['car']);
//        die();
        if(isset($_SESSION['car'])){
            unset($_SESSION['car']);
        }

        header("Location:" . base_url);
    }

}
