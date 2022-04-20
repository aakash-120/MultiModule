<?php
namespace Multi\Admin\Controllers;
use Phalcon\Mvc\Controller;

class DisplayproductController extends Controller
{

    public function IndexAction()
    {
        $collection = $this->mongo->test->addproduct;
        $this->view->table =  $collection->find();
        if ($this->request->get('search')) {
            $value = $this->request->get('search_field');
            $get_value = $collection->find(['$or' => [['product_name' => "$value"], ['category_name' => "$value"], ['price' => $value], ['stock' => $value]]]);
            $this->view->table = $get_value;
        }
        if ($this->request->get('all_product')) {
            $this->view->table =  $collection->find();
        }
    }

    public function DeleteAction()
    {
        $collection = $this->mongo->test->addproduct;
        $id = $this->request->get('id');
        $collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
        $this->response->redirect('/admin/displayproduct/index');
    }
}