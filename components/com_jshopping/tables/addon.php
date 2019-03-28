<?php
/**
* @version      2.7.3 26.01.2011
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

defined('_JEXEC') or die( 'Restricted access' );
jimport('joomla.application.component.model');

class jshopAddon extends JTable{
    
    var $id = null;
    var $alias = null;
    var $key = null;
    var $version = null;
    var $params = null;
    
    function __construct( &$_db ){
        parent::__construct('#__jshopping_addons', 'id', $_db );
    }
    
    function setParams($params){
        $this->params = serialize($params);
    }
        
    function getParams(){
        if ($this->params!=""){
            return unserialize($this->params);
        }else{
            return array();
        }
    }
    
    function loadAlias($alias){
        $query = "select `id` from #__jshopping_addons where `alias`='".$this->_db->escape($alias)."'";
        $this->_db->setQuery($query);
        $id = $this->_db->loadResult();
        $this->load($id);
        $this->alias = $alias;
    }
    
    function getKeyForAlias($alias){
        $query = "select `key` from #__jshopping_addons where `alias`='".$this->_db->escape($alias)."'";
        $this->_db->setQuery($query);
        return $this->_db->loadResult();
    }
	
	function installJoomlaExtension($data, $installexist = 0){
        $db = JFactory::getDbo();
        $db->setQuery("SELECT extension_id FROM `#__extensions` WHERE element='".$db->escape($data['element'])."' AND folder='".$db->escape($data['folder'])."'");
        $exid = (int)$db->loadResult();
        if ($exid && !$installexist){
            return -1;
        }
        $extension = JTable::getInstance('extension', 'JTable');
        if ($exid){
            $extension->load($exid);
        }
        $extension->bind($data);
        if ($extension->check()){
            $extension->store();
            return 1;
        }else{
            return 0;
        }
    }
}
?>