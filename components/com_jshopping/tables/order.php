<?php
/**
* @version      4.1.0 20.08.2012
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

class jshopOrder extends JTable {

    function __construct( &$_db ){
        parent::__construct( '#__jshopping_orders', 'order_id', $_db );
    }

    function getAllItems(){
        if (!isset($this->items)){
            $jshopConfig = JSFactory::getConfig();
            $query = "SELECT OI.* FROM `#__jshopping_order_item` as OI WHERE OI.order_id = '".$this->_db->escape($this->order_id)."'";
            $this->_db->setQuery($query);
            $this->items = $this->_db->loadObjectList();
            foreach($this->items as $k=>$v){
                $this->items[$k]->_qty_unit = '';
                $this->items[$k]->delivery_time = '';
            }
            if ($jshopConfig->display_delivery_time_for_product_in_order_mail){
                $deliverytimes = JSFactory::getAllDeliveryTime();
                foreach($this->items as $k=>$v){
                    if (isset($deliverytimes[$v->delivery_times_id])) {
                        $this->items[$k]->delivery_time = $deliverytimes[$v->delivery_times_id];
                    }
                }
            } 
        }
    return $this->items;
    }
    
    function getWeightItems(){
        $items = $this->getAllItems();
        $weight = 0;
        foreach($items as $row){
            $weight += $row->product_quantity * $row->weight;
        }
    return $weight;
    }

    function getHistory() {
        $lang = JSFactory::getLang();
        $query = "SELECT history.*, status.*, status.`".$lang->get('name')."` as status_name  FROM `#__jshopping_order_history` AS history
                  INNER JOIN `#__jshopping_order_status` AS status ON history.order_status_id = status.status_id
                  WHERE history.order_id = '" . $this->_db->escape($this->order_id) . "'
                  ORDER BY history.status_date_added";
        $this->_db->setQuery($query);
        return $this->_db->loadObjectList();
    }

    function getStatusTime(){
        $query = "SELECT max(status_date_added) FROM `#__jshopping_order_history` WHERE order_id = '".$this->_db->escape($this->order_id)."'";
        $this->_db->setQuery($query);
        $res = $this->_db->loadResult();
    return strtotime($res);
    }

    function getStatus() {
        $lang = JSFactory::getLang();
        $query = "SELECT `".$lang->get('name')."` as name FROM `#__jshopping_order_status` WHERE status_id = '" . $this->_db->escape($this->order_status) . "'";
        $this->_db->setQuery($query);
        return $this->_db->loadResult();
    }

    function copyDeliveryData(){    
		JPluginHelper::importPlugin('jshoppingorder');
        $dispatcher = JDispatcher::getInstance();
        $this->d_title = $this->title;
        $this->d_f_name = $this->f_name;
        $this->d_l_name = $this->l_name;
		$this->d_m_name = $this->m_name;
        $this->d_firma_name = $this->firma_name;
        $this->d_home = $this->home;
        $this->d_apartment = $this->apartment;
        $this->d_street = $this->street;
        $this->d_zip = $this->zip;
        $this->d_city = $this->city;
        $this->d_state = $this->state;
        $this->d_email = $this->email;
		$this->d_birthday = $this->birthday;
        $this->d_country = $this->country;
        $this->d_phone = $this->phone;
        $this->d_mobil_phone = $this->mobil_phone;
        $this->d_fax = $this->fax;
        $this->d_ext_field_1 = $this->ext_field_1;
        $this->d_ext_field_2 = $this->ext_field_2;
        $this->d_ext_field_3 = $this->ext_field_3;
		$dispatcher->trigger('onAfterCopyDeliveryData', array(&$this));
    }

    function getOrdersForUser($id_user) {
        $db = JFactory::getDBO();
        $lang = JSFactory::getLang(); 
        $query = "SELECT orders.*, order_status.`".$lang->get('name')."` as status_name, COUNT(order_item.order_id) AS count_products
                  FROM `#__jshopping_orders` AS orders
                  INNER JOIN `#__jshopping_order_status` AS order_status ON orders.order_status = order_status.status_id
                  INNER JOIN `#__jshopping_order_item` AS order_item ON order_item.order_id = orders.order_id
                  WHERE orders.user_id = '".$db->escape($id_user)."' and orders.order_created='1'
                  GROUP BY order_item.order_id 
                  ORDER BY orders.order_date DESC";
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    /**
    * Next order id    
    */
    function getLastOrderId() {
        $db = JFactory::getDBO(); 
        $query = "SELECT MAX(orders.order_id) AS max_order_id FROM `#__jshopping_orders` AS orders";
        $db->setQuery($query);
        return $db->loadResult() + 1;
    }

    function formatOrderNumber($num){
        $number = outputDigit($num, 8);
        return $number;
    }

    /**
    * save name pdf from order
    */
    function insertPDF() {
        $query = "UPDATE `#__jshopping_orders` SET pdf_file = '".$this->_db->escape($this->pdf_file)."' WHERE order_id = '".$this->_db->escape($this->order_id)."'";
        $this->_db->setQuery($query);
        $this->_db->query();
    }
    
	function getFilesStatDownloads($fileinfo = 0){
        if ($this->file_stat_downloads == "") return array();
        $rows = unserialize($this->file_stat_downloads);
        if ($fileinfo && count($rows)){
            $db = JFactory::getDBO();
            $files_id = array_keys($rows);
            $query = "SELECT * FROM `#__jshopping_products_files` where id in (".implode(',',$files_id).")";
            $db->setQuery($query);
            $_list = $db->loadObjectList();
            $list = array();
            foreach($_list as $k=>$v){
                $v->count_download = $rows[$v->id];
                $list[$v->id] = $v;
            }
            return $list;
        }else{
            return $rows;   
        }
    }
    
    function setFilesStatDownloads($array){
        $this->file_stat_downloads = serialize($array);
    }
    
    function getTaxExt(){
        if ($this->order_tax_ext == "") return array();
        return unserialize($this->order_tax_ext);
    }
    
    function setTaxExt($array){
        $this->order_tax_ext = serialize($array);
    }
    
    function setShippingTaxExt($array){
        $this->shipping_tax_ext = serialize($array);
    }
    
    function getShippingTaxExt(){
        if ($this->shipping_tax_ext == "") return array();
        return unserialize($this->shipping_tax_ext);
    }
    
    function setPackageTaxExt($array){
        $this->package_tax_ext = serialize($array);
    }
    
    function getPackageTaxExt(){
        if ($this->shipping_tax_ext == "") return array();
        return unserialize($this->package_tax_ext);
    }

    function setPaymentTaxExt($array){
        $this->payment_tax_ext = serialize($array);
    }
    
    function getPaymentTaxExt(){
        if ($this->payment_tax_ext == "") return array();
        return unserialize($this->payment_tax_ext);
    }
    
    function getPaymentParamsData(){
        if ($this->payment_params_data == "") return array();
        return unserialize($this->payment_params_data);
    }
    
    function setPaymentParamsData($array){
        $this->payment_params_data = serialize($array);
    }
    
    function getLang(){
        $lang = $this->lang;
        if ($lang=="") $lang = "en-GB";
        return $lang;
    }
	
	function getListFieldCopyUserToOrder(){
        JPluginHelper::importPlugin('jshoppingorder');
        $dispatcher = JDispatcher::getInstance();
        $list = array('user_id','f_name','l_name','m_name','firma_name','client_type','firma_code','tax_number','email','birthday','home','apartment','street','zip','city','state','country','phone','mobil_phone','fax','title','ext_field_1','ext_field_2','ext_field_3','d_f_name','d_l_name','d_m_name','d_firma_name','d_email','d_birthday','d_home','d_apartment','d_street','d_zip','d_city','d_state','d_country','d_phone','d_mobil_phone','d_title','d_fax','d_ext_field_1','d_ext_field_2','d_ext_field_3');
        $dispatcher->trigger('onBeforeGetListFieldCopyUserToOrder', array(&$list));
    return $list;
    }
    
    function saveOrderItem($items) {
        JPluginHelper::importPlugin('jshoppingorder');
        $dispatcher = JDispatcher::getInstance();
        
        foreach($items as $key=>$value){
            $order_item = JTable::getInstance('orderItem', 'jshop');
            $order_item->order_id = $this->order_id;
            $order_item->product_id = $value['product_id'];
            $order_item->product_ean = $value['ean'];
            $order_item->product_name = $value['product_name'];
            $order_item->product_quantity = $value['quantity'];
            $order_item->product_item_price = $value['price'];
            $order_item->product_tax = $value['tax'];
            $order_item->product_attributes = $attributes_value = '';
            $order_item->product_freeattributes = $free_attributes_value = '';
            $order_item->attributes = $value['attributes'];
            $order_item->files = $value['files'];
            $order_item->freeattributes = $value['freeattributes'];
            $order_item->weight = $value['weight'];
            $order_item->thumb_image = $value['thumb_image'];
            $order_item->delivery_times_id = $value['delivery_times_id'];
            $order_item->vendor_id = $value['vendor_id'];
            $order_item->manufacturer = $value['manufacturer'];
            $order_item->params = $value['params'];
            
            if (isset($value['attributes_value'])){
                foreach ($value['attributes_value'] as $attr){
                    $attributes_value .= $attr->attr.': '.$attr->value."\n";
                }
            }
            $order_item->product_attributes = $attributes_value;
            
            if (isset($value['free_attributes_value'])){
                foreach ($value['free_attributes_value'] as $attr){
                    $free_attributes_value .= $attr->attr.': '.$attr->value."\n";
                }
            }
            $order_item->product_freeattributes = $free_attributes_value;
            
            if (isset($value['extra_fields'])){
                $order_item->extra_fields = '';
                foreach($value['extra_fields'] as $extra_field){
                    $order_item->extra_fields .= $extra_field['name'].': '.$extra_field['value']."\n";
                }
            }
            
            $dispatcher->trigger( 'onBeforeSaveOrderItem', array(&$order_item, &$value) );
            
            $order_item->store();
        }
        return 1;
    }
    
    /**
    * get or return product in Stock
    * @param $change ("-" - get, "+" - return) 
    */
    function changeProductQTYinStock($change = "-"){
        $db = JFactory::getDBO();
        JPluginHelper::importPlugin('jshoppingorder');
        $dispatcher = JDispatcher::getInstance();
        
        $query = "SELECT OI.*, P.unlimited FROM `#__jshopping_order_item` as OI left join `#__jshopping_products` as P on P.product_id=OI.product_id
                  WHERE order_id = '".$db->escape($this->order_id)."'";
        $db->setQuery($query);
        $items = $db->loadObjectList();

        foreach($items as $item){
            
            if ($item->unlimited) continue;
            
            if ($item->attributes!=""){
                $attributes = unserialize($item->attributes);
            }else{
                $attributes = array();
            }            
            if (!is_array($attributes)) $attributes = array();
            
            $allattribs = JSFactory::getAllAttributes(1);
            $dependent_attr = array();
            foreach($attributes as $k=>$v){
                if ($allattribs[$k]->independent==0){
                    $dependent_attr[$k] = $v;
                }
            }
            
            if (count($dependent_attr)){
                $where="";
                foreach($dependent_attr as $k=>$v){
                    $where.=" and `attr_$k`='".intval($v)."'";
                }
                $query = "update `#__jshopping_products_attr` set `count`=`count`  ".$change." ".intval($item->product_quantity)." where product_id='".intval($item->product_id)."' ".$where;
                $db->setQuery($query);
                $db->query();
                
                $query="select sum(count) as qty from `#__jshopping_products_attr` where product_id='".intval($item->product_id)."' and `count`>0 ";
                $db->setQuery($query);
                $qty = $db->loadResult();
                
                $query = "UPDATE `#__jshopping_products` SET product_quantity = '".intval($qty)."' WHERE product_id = '".intval($item->product_id)."'";
                $db->setQuery($query);
                $db->query();
                
            }else{
                $query = "UPDATE `#__jshopping_products` SET product_quantity = product_quantity ".$change." ".intval($item->product_quantity)." WHERE product_id = '".intval($item->product_id)."'";
                $db->setQuery($query);
                $db->query();
            }
            $dispatcher->trigger('onAfterchangeProductQTYinStock', array(&$item, &$change) );
        }
    }
    
    /**    
    * get list vendors for order
    */
    function getVendors(){
        $db = JFactory::getDBO();
        $query = "SELECT distinct V.* FROM `#__jshopping_order_item` as OI
                  left join `#__jshopping_vendors` as V on V.id = OI.vendor_id
                  WHERE order_id = '".$db->escape($this->order_id)."'";
        $db->setQuery($query);
    return $db->loadObjectList();
    }
    
    function getVendorItems($vendor_id){
        $items = $this->getAllItems();
        foreach($items as $k=>$v){
            if ($v->vendor_id!=$vendor_id){
                unset($items[$k]);
            }
        }
    return $items;
    }
    
    function getVendorInfo(){
        $jshopConfig = JSFactory::getConfig();
        $vendor_id = $this->vendor_id;
        if ($vendor_id==-1) $vendor_id = 0;
        if ($jshopConfig->vendor_order_message_type<2) $vendor_id = 0;
        $vendor = JTable::getInstance('vendor', 'jshop');
        $vendor->loadFull($vendor_id);
        $vendor->country_id = $vendor->country;
        $lang = JSFactory::getLang($this->getLang());
        $country = JTable::getInstance('country', 'jshop');
        $country->load($vendor->country_id);
        $field_country_name = $lang->get("name");
        $vendor->country = $country->$field_country_name;
    return $vendor;
    }
    
}
?>