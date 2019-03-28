<?php
/**
* @version      2.9.0 21.05.2011
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

defined('_JEXEC') or die( 'Restricted access' );
jimport('joomla.application.component.model');

class jshopStaticText extends JTableAvto{
    
    function __construct( &$_db ){
        parent::__construct('#__jshopping_config_statictext', 'id', $_db );
    }
    
    function loadData($alias){
        $lang = JSFactory::getLang();
        $db = JFactory::getDBO();         
        $query = "SELECT id, alias, `".$lang->get('text')."` as text FROM `#__jshopping_config_statictext` where alias='".$db->escape($alias)."'";
        $db->setQuery($query);
        return $db->loadObject();
    }
    
}
?>