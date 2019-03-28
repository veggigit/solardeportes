<?php
/**
* @version      4.1.0 10.10.2012
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class JshoppingControllerContent extends JControllerLegacy{

    function display($cachable = false, $urlparams = false){
        JError::raiseError(404, _JSHOP_PAGE_NOT_FOUND);
    }

    function view(){
        $jshopConfig = JSFactory::getConfig();
        $db = JFactory::getDBO(); 
        
        $page = JRequest::getVar('page');
        switch($page){
            case 'agb':
                $pathway = _JSHOP_AGB;
            break;
            case 'return_policy':
                $pathway = _JSHOP_RETURN_POLICY;
            break;
            case 'shipping':
                $pathway = _JSHOP_SHIPPING;
            break;
            case 'privacy_statement':
                $pathway = _JSHOP_PRIVACY_STATEMENT;
            break;
        }
        appendPathWay($pathway);

        $seo = JTable::getInstance("seo", "jshop");
        $seodata = $seo->loadData("content-".$page);
        if ($seodata->title==""){
            $seodata->title = $pathway;
        }
        setMetaData($seodata->title, $seodata->keyword, $seodata->description);
        
        $statictext = JTable::getInstance("statictext","jshop");
        $row = $statictext->loadData($page);
        if (!$row->id){
            JError::raiseError(404, _JSHOP_PAGE_NOT_FOUND);
            return;
        }
        $text = $row->text;
        
        JPluginHelper::importPlugin('jshopping');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onBeforeDisplayContent', array($page, &$text));
        
        echo $text;
    }

}
?>