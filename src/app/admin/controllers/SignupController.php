<?php
namespace Multi\Admin\Controllers;
use Phalcon\Mvc\Controller;

class SignupController extends Controller{

    public function IndexAction()
    {

    }

    public function registerAction() {
        $signup = $this->mongo->test->users ;
        $name = $this->request->get('name');
        $email = $this->request->get('email');
        $password = $this->request->get('password');
        $success = $signup->insertOne(['name' => $name, 'email' => $email , 'password' => $password]);


        $this->view->success = $success;

        if($success){
            $this->view->message = "Register succesfully";
        }else{
            $this->view->message = "Not Register succesfully due to following reason: <br>".implode("<br>", $user->getMessages());
        }
    }
}