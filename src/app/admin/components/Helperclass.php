<?php 
namespace Multi\Admin\Components ;

use Phalcon\Http\Request;
use Phalcon\Di\Injectable;
class Helperclass extends Injectable {
    public function sanitize_data() {
        $request = new Request();
        $arr = array() ;
        $var_arr = array() ;
         $label = $request->get('label');
         $input = $request->get('input');
         $var_name = $request->get('variation_name');
         $var_value = $request->get('variation_value');
         $var_price = $request->get('variation_price');
      
        if (isset($label)) {
            for ($i = 0; $i < count($label); $i++) {
                array_push($arr, ['label' => $this->escaper->escapeHtml($label[$i]), 'value' => $this->escaper->escapeHtml($input[$i])]);
            }
        }
        if (isset($var_name)) {
            for ($i = 0; $i < count($var_name); $i++) {
                array_push($var_arr, ['name' => $this->escaper->escapeHtml($var_name[$i]), 'value' => $this->escaper->escapeHtml($var_value[$i]), 'price' => $this->escaper->escapeHtml($var_price[$i])]);
            }
        }
        $inputdata = array(
           'productname' => $this->escaper->escapeHtml($request->get('productname')),
           'categoryname' => $this->escaper->escapeHtml($request->get('categoryname')),
           'price' => $this->escaper->escapeHtml($request->get('price')),
           'stock' => $this->escaper->escapeHtml($request->get('stock')),
           'label_arr' => $arr,
            'var_arr' => $var_arr
        );
        return $inputdata ;
    }
}