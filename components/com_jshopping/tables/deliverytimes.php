<?php
/**
* @version      2.7.0 23.09.2010
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

class jshopDeliveryTimes extends JTableAvto {
    
    function __construct( &$_db ){
        parent::__construct( '#__jshopping_delivery_times', 'id', $_db );
    }
    
    function getName() {
        $lang = JSFactory::getLang();
        $name = $lang->get('name');
        return $this->$name;
    }
    
    function getDeliveryTimes(){
        $db = JFactory::getDBO();    
        $lang = JSFactory::getLang();     
        $query = "SELECT id, `".$lang->get('name')."` as name FROM `#__jshopping_delivery_times` ORDER BY name";
        $db->setQuery($query);
        return $db->loadObjectList();
    }
        
}
?>