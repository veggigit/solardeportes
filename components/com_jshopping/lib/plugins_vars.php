<?php
class JSPluginsVars{
    
    public static function product(&$view){
        $view->_tmp_product_html_start = '';
        $view->_tmp_product_html_before_image = '';
        $view->_tmp_product_html_after_image = '';
        $view->_tmp_product_html_before_image_thumb = '';
        $view->_tmp_product_html_after_image_thumb = '';
        $view->_tmp_product_html_after_video = '';        
        $view->_tmp_product_html_before_buttons = '';        
        $view->_tmp_qty_unit = '';
        $view->_tmp_product_html_buttons = '';
        $view->_tmp_product_html_after_buttons = '';
        $view->_tmp_product_html_before_demofiles = '';
        $view->_tmp_product_html_before_related = '';
        $view->_tmp_product_html_before_review = '';
        $view->_tmp_product_html_end = '';
        $view->_tmp_product_ext_js = '';
        $view->product->_tmp_var_bottom_price = '';
        $view->product->_tmp_var_price_ext = '';
        $view->_tmp_product_review_before_submit = '';
        foreach($view->product->product_add_prices as $k=>$add_price){
            $add_price->ext_price = '';
        }
    }
    
    public static function listproducts(&$view){
        $view->_tmp_ext_filter_box = '';
        $view->_tmp_ext_filter = '';
    }
    
    public static function listproducts_product(&$view){
        $view->_tmp_var_start = '';
        $view->_tmp_var_bottom_foto = '';
        $view->_tmp_var_bottom_price = '';
        $view->_tmp_var_top_buttons = '';
        $view->_tmp_var_bottom_buttons = '';
        $view->_tmp_var_buttons = '';
        $view->_tmp_var_end = '';
    }
    
    public static function login(&$view){
        $view->_tmpl_register_html_1 = '';
        $view->_tmpl_register_html_2 = '';
        $view->_tmpl_register_html_3 = '';
        $view->_tmpl_register_html_4 = '';
        $view->_tmpl_register_html_5 = '';
        $view->_tmpl_register_html_6 = '';
    }
    
    public static function register(&$view){
        $view->_tmpl_register_html_1 = '';
        $view->_tmpl_register_html_2 = '';
        $view->_tmpl_register_html_3 = '';
        $view->_tmpl_register_html_4 = '';
        $view->_tmpl_register_html_5 = '';
        $view->_tmpl_register_html_6 = '';
    }
    
    public static function editaccount(&$view){
        $view->_tmpl_editaccount_html_1 = '';
        $view->_tmpl_editaccount_html_2 = '';
        $view->_tmpl_editaccount_html_3 = '';
        $view->_tmpl_editaccount_html_4 = '';
        $view->_tmpl_editaccount_html_5 = '';
        $view->_tmpl_editaccount_html_6 = '';
        $view->_tmpl_editaccount_html_7 = '';
        $view->_tmpl_editaccount_html_8 = '';
        $view->_tmpl_editaccount_html_4_1 = '';
        
    }
    
    public static function cart(&$view){
        $view->_tmp_ext_html_cart_start = '';
        $view->_tmp_ext_subtotal = '';
        $view->_tmp_ext_tax = '';
        $view->_tmp_ext_total = '';
        $view->_tmp_ext_discount = '';
        $view->_tmp_ext_html_before_discount = '';
        if (isset($view->tax_list)){
            foreach($view->tax_list as $percent=>$value){
                $view->_tmp_ext_tax[$percent] = '';
            }
        }
        foreach($view->products as $k=>$v){
            $view->products[$k]['_ext_attribute_html'] = '';
            $view->products[$k]['_ext_price_html'] = '';
            $view->products[$k]['_qty_unit'] = '';
            $view->products[$k]['_ext_price_total_html'] = '';
        }
    }    
    
    public static function checkoutstep2(&$view){
        $view->_tmp_ext_html_address_start = '';
        $view->_tmpl_address_html_2 = '';
        $view->_tmpl_address_html_3 = '';
        $view->_tmpl_address_html_4 = '';
        $view->_tmpl_address_html_5 = '';
        $view->_tmpl_address_html_6 = '';
        $view->_tmpl_address_html_7 = '';
        $view->_tmpl_address_html_8 = '';
        $view->_tmpl_address_html_9 = '';
        $view->_tmp_ext_html_address_end = '';        
    }
    
    public static function checkoutstep3(&$view){
        $view->_tmp_ext_html_payment_start = '';
        $view->_tmp_ext_html_payment_end = '';
    }
    
    public static function checkoutstep4(&$view){
        $view->_tmp_ext_html_shipping_start = '';
        $view->_tmp_ext_html_shipping_end = '';
    }
    
    public static function checkoutstep5(&$view){        
        $view->_tmp_ext_html_previewfinish_start = '';
        $view->_tmp_ext_html_previewfinish_end = '';        
    }
    
    public static function showsmallcart(&$view){
        $view->_tmp_ext_subtotal = '';
        $view->_tmp_ext_shipping = '';
        $view->_tmp_ext_tax = '';
        $view->_tmp_ext_total = '';
        $view->_tmp_ext_payment = '';
        $view->_tmp_ext_discount = '';
        $view->_tmp_ext_shipping_package = '';
        foreach($view->tax_list as $percent=>$value){
            $view->_tmp_ext_tax[$percent] = '';
        }
        foreach($view->products as $k=>$v){
            $view->products[$k]['_ext_attribute_html'] = '';
            $view->products[$k]['_ext_price_html'] = '';
            $view->products[$k]['_qty_unit'] = '';            
            $view->products[$k]['_ext_price_total_html'] = '';
        }
    }
    
    public static function search(&$view){
        $view->_tmp_ext_search_html_start = '';
        $view->_tmp_ext_search_html_end = '';
    }
    
    public static function orders(&$view){
        foreach($view->orders as $order){
            $order->_ext_price_html = '';
        }
    }
    
    public static function order(&$view){
        $view->_tmp_ext_subtotal = '';
        $view->_tmp_ext_shipping = '';
        $view->_tmp_ext_tax = '';
        $view->_tmp_ext_total = '';
        $view->_tmp_ext_payment = '';
        $view->_tmp_ext_discount = '';
        foreach($view->order->items as $item){
            $item->_ext_attribute_html = '';
            $item->_ext_price_html = '';
            $item->_ext_price_total_html = '';
        }
        foreach($view->order->order_tax_list as $percent=>$value){
            $view->_tmp_ext_tax[$percent] = '';
        }
    }
    
    public static function ordersendemail(&$view){
        $view->_tmp_ext_html_ordermail_start = '';
        $view->_tmp_ext_html_ordermail_end = '';
        $view->info_shop = '';
        $view->_tmp_ext_subtotal = '';
        $view->_tmp_ext_shipping = '';
        $view->_tmp_ext_tax = '';
        $view->_tmp_ext_total = '';
        $view->_tmp_ext_payment = '';
        $view->_tmp_ext_discount = '';
        $view->_tmp_ext_shipping_package = '';
        foreach($view->products as $k=>$prod){
            $prod->_ext_attribute_html = '';
            $prod->_ext_price_html = '';
            $prod->_ext_price_total_html = '';
        }
        foreach($view->order->order_tax_list as $percent=>$value){
            $view->_tmp_ext_tax[$percent] = '';
        }
    }
    
}
?>