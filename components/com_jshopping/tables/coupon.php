<?php
/**
* @version      2.0.0 31.07.2010
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

class jshopCoupon extends JTable {
    
    var $coupon_id = null;
    var $coupon_code = null;
    var $coupon_type = null;
    var $coupon_value = null;
    var $tax_id = null;    
    var $used = null;
    var $for_user_id = null;
    var $coupon_start_date = null;
    var $coupon_expire_date = null;
    var $finished_after_used = null;
    var $coupon_publish = null;
    
    function __construct( &$_db ){
        parent::__construct( '#__jshopping_coupons', 'coupon_id', $_db );
    }
    
    function getExistCode(){
        $query = "SELECT `coupon_id` FROM `#__jshopping_coupons`
                  WHERE `coupon_code` = '" . $this->_db->escape($this->coupon_code) . "' AND `coupon_id` <> '" . $this->_db->escape($this->coupon_id) . "'";
        $this->_db->setQuery($query);
        $this->_db->query();
        return $this->_db->getNumRows();
    }
    
    function getEnableCode($code){
        $jshopConfig = JSFactory::getConfig();
        $db = JFactory::getDBO();
        if(!$jshopConfig->use_rabatt_code) {
            $this->error = _JSHOP_RABATT_NON_SUPPORT;
            return 0;
        }
        $date = date("Y-m-d");
        $query = "SELECT * FROM `#__jshopping_coupons` WHERE coupon_code = '" . $db->escape($code) . "' AND coupon_publish = '1'";
        $db->setQuery($query);
        $row = $db->loadObject();
        
        if(!isset($row->coupon_id)) {
            $this->error = _JSHOP_RABATT_NON_CORRECT;
            return 0;
        }
        
        if ($row->coupon_expire_date < $date && $row->coupon_expire_date!="0000-00-00"){
            $this->error = _JSHOP_RABATT_NON_CORRECT;
            return 0;
        }
        
        if ($row->coupon_start_date > $date){
            $this->error = _JSHOP_RABATT_NON_CORRECT;
            return 0;
        }
        
        if($row->used) {
            $this->error = _JSHOP_RABATT_USED;
            return 0;
        }
        
        if ($row->for_user_id){
            $user = JFactory::getUser();
            if (!$user->id){
                $this->error = _JSHOP_FOR_USE_COUPON_PLEASE_LOGIN;
                return 0;
            }
            if ($row->for_user_id!=$user->id){
                $this->error = _JSHOP_RABATT_NON_CORRECT;
                return 0;    
            }
        }
        
        $this->load($row->coupon_id);
        return 1;                
    }
    
    
}
?>