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

class JshoppingControllerWishlist extends JControllerLegacy{

    function display($cachable = false, $urlparams = false){
        $this->view();
    }

    function view(){
		$mainframe = JFactory::getApplication();
	    $jshopConfig = JSFactory::getConfig();
		$db = JFactory::getDBO();
        $session = JFactory::getSession();
        $params = $mainframe->getParams();
        $ajax = JRequest::getInt('ajax');

		$cart = JModelLegacy::getInstance('cart', 'jshop');
		$cart->load("wishlist");
		$cart->addLinkToProducts(1, "wishlist");
        $cart->setDisplayFreeAttributes();

        $seo = JTable::getInstance("seo", "jshop");
        $seodata = $seo->loadData("wishlist");
        if (getThisURLMainPageShop()){
            $document = JFactory::getDocument();
            appendPathWay(_JSHOP_WISHLIST);
            if ($seodata->title==""){
                $seodata->title = _JSHOP_WISHLIST;
            }
            setMetaData($seodata->title, $seodata->keyword, $seodata->description);
        }else{
            setMetaData($seodata->title, $seodata->keyword, $seodata->description, $params);
        }

        $shopurl = SEFLink('index.php?option=com_jshopping&controller=category',1);
        if ($jshopConfig->cart_back_to_shop=="product"){
            $endpagebuyproduct = $session->get('jshop_end_page_buy_product');
        }elseif ($jshopConfig->cart_back_to_shop=="list"){
            $endpagebuyproduct = $session->get('jshop_end_page_list_product');
        }
        if (isset($endpagebuyproduct) && $endpagebuyproduct){
            $shopurl = $endpagebuyproduct;
        }

        JPluginHelper::importPlugin('jshoppingcheckout');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger( 'onBeforeDisplayWishlist', array(&$cart) );

		$view_name = "cart";
        $view_config = array("template_path"=>JPATH_COMPONENT."/templates/".$jshopConfig->template."/".$view_name);
        $view = $this->getView($view_name, getDocumentType(), '', $view_config);
        $view->setLayout("wishlist");
        $view->assign('config', $jshopConfig);
		$view->assign('products', $cart->products);
		$view->assign('image_product_path', $jshopConfig->image_product_live_path);
		$view->assign('image_path', $jshopConfig->live_path);
		$view->assign('no_image', $jshopConfig->noimage);
		$view->assign('href_shop', $shopurl);
		$view->assign('href_checkout', SEFLink('index.php?option=com_jshopping&controller=cart&task=view',1));
        JSPluginsVars::cart($view);
        $dispatcher->trigger('onBeforeDisplayWishlistView', array(&$view));
		$view->display();
        if ($ajax) die();
    }

    function delete(){
        header("Cache-Control: no-cache, must-revalidate");
        $ajax = JRequest::getInt('ajax');
        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load('wishlist');    
        $cart->delete(JRequest::getInt('number_id'));
        if ($ajax){
            print getOkMessageJson($cart);
            die();
        }
        $this->setRedirect( SEFLink('index.php?option=com_jshopping&controller=wishlist&task=view',0,1) );
    }

    function remove_to_cart(){
        header("Cache-Control: no-cache, must-revalidate");
        $ajax = JRequest::getInt('ajax');
        $number_id = JRequest::getInt('number_id');
        JPluginHelper::importPlugin('jshoppingcheckout');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onBeforeLoadWishlistRemoveToCart', array(&$number_id));
        
        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load("wishlist");
        $prod = $cart->products[$number_id];
        $attr = unserialize($prod['attributes']);
        $freeattribut = unserialize($prod['freeattributes']);
        $cart->delete($number_id);
                        
        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load("cart");        
        $cart->add($prod['product_id'], $prod['quantity'], $attr, $freeattribut);
        $dispatcher->trigger('onAfterWishlistRemoveToCart', array(&$cart));
        if ($ajax){
            print getOkMessageJson($cart);
            die();
        }
        $this->setRedirect( SEFLink('index.php?option=com_jshopping&controller=cart&task=view',1,1) );
    }
}
?>