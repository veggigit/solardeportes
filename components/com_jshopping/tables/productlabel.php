<?php
/**
* @version      2.4.3 02.11.2010
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

class jshopProductLabel extends JTable{
    
    var $id = null;
    var $name = null;
    var $image = null;
    
    function __construct( &$_db ){
        parent::__construct( '#__jshopping_product_labels', 'id', $_db );
    }
    
    function getListLabels(){
        $db = JFactory::getDBO();            
        $query = "SELECT * FROM `#__jshopping_product_labels` ORDER BY name";
        $db->setQuery($query);
        $list = $db->loadObjectList();
        $rows = array();
        foreach($list as $row){
            $rows[$row->id] = $row;
        }
    return $rows;
    }
}
?>