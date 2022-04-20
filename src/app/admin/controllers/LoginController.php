<?php
namespace Multi\Admin\Controllers;
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
       
    }

    public function registerAction() {
        $email = $this->request->get('email');
        $pass = $this->request->get('password'); 
        $collection = $this->mongo->test->users;
        $result = $collection->findOne(['email' => $email, 'password' => $pass]);
        if($email === "" and $pass === "") {
            echo "Please enter correct email or password!!";
        }
        elseif($email == $result->email && $pass == $result->password) {
            header("Location:/addproduct/");
        }
        else {
            echo "not authorized!!";
        }
    
    }
}