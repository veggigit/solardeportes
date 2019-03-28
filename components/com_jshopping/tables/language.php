<?php
/**
* @version      2.7.3 27.01.2011
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

class jshopLanguage extends JTable {
    
    var $id = null;
    var $language = null;
    var $name = null;
    var $publish = null;
    var $ordering = null;    
    
    function __construct( &$_db ){
        parent::__construct( '#__jshopping_languages', 'id', $_db );
    }
    
    function getAllLanguages($publish = 1) {
        $jshopConfig = JSFactory::getConfig();
        $db = JFactory::getDBO();
        $where_add = $publish ? "where `publish`='1'": ""; 
        $query = "SELECT * FROM `#__jshopping_languages` ".$where_add." order by `ordering`";
        $db->setQuery($query);
        $rowssort = array();
        $rows = $db->loadObjectList();
        foreach($rows as $k=>$v){
            $rows[$k]->lang = substr($v->language, 0, 2);
            if ($jshopConfig->cur_lang == $v->language) $rowssort[] = $rows[$k];
        }
        foreach($rows as $k=>$v){
            if (isset($rowssort[0]) && $rowssort[0]->language==$v->language) continue;
            $rowssort[] = $v;            
        }
        unset($rows);
        return $rowssort;
    }
   
}
?>