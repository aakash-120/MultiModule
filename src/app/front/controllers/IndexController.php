<?php

namespace Multi\Front\Controllers;
use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {   
        $collection = $this->mongo->test->addproduct ;
        $this->view->table =  $collection->find();
        if ($this->request->get('search')) {
            $value = $this->request->get('search_field');
            $get_value = $collection->find(['$or' => [['product_name' => "$value"], ['category_name' => "$value"], ['price' => $value], ['stock' => $value]]]);
            $this->view->table = $get_value;
        }
        if ($this->request->get('all_product')) {
            $this->view->table =  $collection->find();
        }
        
        // return '<h1>Hello World!</h1>';
    }
}