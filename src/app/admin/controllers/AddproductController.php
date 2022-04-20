<?php

namespace Multi\Admin\Controllers;
use Phalcon\Mvc\Controller;


class AddproductController extends Controller
{
    public function indexAction()
    {
        $collection = $this->mongo->test->addproduct;
        if ($this->request->get('id')) {
            $id = $this->request->get('id');
            $val = $collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

            $this->view->edit = $val;
        }
        
    }
    
    public function registerAction()
    {
 
        $collection = $this->mongo->test->addproduct;

        $productname = $this->request->get('productname');
        $categoryname = $this->request->get('categoryname');
        $id = $this->request->get('id');

        $data = new \Multi\Admin\Components\Helperclass() ;
        $inputdata = $data->sanitize_data() ;
     
        if($productname != ''){
        if ($this->request->get('addproduct')) {

            $success = $collection->insertOne([
                'product_name' => $inputdata['productname'], 'category_name' => $inputdata['categoryname'], 'price' => $inputdata['price'], 'stock' => $inputdata['stock'],
                'label_value' => $inputdata['label_arr'], 'variation' => $inputdata['var_arr']
            ]);
        } else {
          
            $success = $collection->updateOne(['_id' => new \MongoDB\BSON\ObjectId($id)], ['$set' => [
                'product_name' => $inputdata['productname'], 'category_name' => $inputdata['categoryname'], 'price' => $inputdata['price'], 'stock' => $inputdata['stock'],
                'label_value' => $inputdata['label_arr'], 'variation' => $inputdata['var_arr']
            ]]);
        }
        $this->view->success = $success;}


        // $success = $user->save();

    

        if (isset($success)) {
            $this->view->message = "Register succesfully";
            $this->logger->info("regsiter successfully");
        } else {
            $this->view->message = "Not Register succesfully due to following reason: <br>";
            $this->logger->error("Not Register succesfully");
        }
    }
}