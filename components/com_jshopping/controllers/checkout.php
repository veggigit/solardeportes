<?php
/**
* @version      4.1.0 29.09.2012
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
include_once(JPATH_COMPONENT_SITE."/payments/payment.php");

class JshoppingControllerCheckout extends JControllerLegacy{
    
    function display($cachable = false, $urlparams = false){
        $this->step2();
    }
    
    function step2(){
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
        $checkout->checkStep(2);
        
        JPluginHelper::importPlugin('jshoppingcheckout');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onLoadCheckoutStep2', array());
        
        $session = JFactory::getSession();
        $user = JFactory::getUser();
        $jshopConfig = JSFactory::getConfig();
        $country = JTable::getInstance('country', 'jshop');
        
        $checkLogin = JRequest::getInt('check_login');
        if ($checkLogin){
            $session->set("show_pay_without_reg", 1);
            checkUserLogin();
        }

        appendPathWay(_JSHOP_CHECKOUT_ADDRESS);
        $seo = JTable::getInstance("seo", "jshop");
        $seodata = $seo->loadData("checkout-address");
        if ($seodata->title==""){
            $seodata->title = _JSHOP_CHECKOUT_ADDRESS;
        }
        setMetaData($seodata->title, $seodata->keyword, $seodata->description);
        
        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load();
        $cart->getSum();

        if ($user->id){
            $adv_user = JSFactory::getUserShop();
        }else{
            $adv_user = JSFactory::getUserShopGuest();    
        }
        $adv_user->birthday = getDisplayDate($adv_user->birthday, $jshopConfig->field_birthday_format);
        $adv_user->d_birthday = getDisplayDate($adv_user->d_birthday, $jshopConfig->field_birthday_format);
        
        $tmp_fields = $jshopConfig->getListFieldsRegister();
        $config_fields = $tmp_fields['address'];
        $count_filed_delivery = $jshopConfig->getEnableDeliveryFiledRegistration('address');

        $checkout_navigator = $this->_showCheckoutNavigation(2);
        if ($jshopConfig->show_cart_all_step_checkout){
            $small_cart = $this->_showSmallCart(2);
        }else{
            $small_cart = '';
        }

        $view_name = "checkout";
        $view_config = array("template_path"=>JPATH_COMPONENT."/templates/".$jshopConfig->template."/".$view_name);
        $view = $this->getView($view_name, getDocumentType(), '', $view_config);
        $view->setLayout("adress");
        $view->assign('select', $jshopConfig->arr['title']);
        
        if (!$adv_user->country) $adv_user->country = $jshopConfig->default_country;
        if (!$adv_user->d_country) $adv_user->d_country = $jshopConfig->default_country;

        $option_country[] = JHTML::_('select.option',  '0', _JSHOP_REG_SELECT, 'country_id', 'name' );
        $option_countryes = array_merge($option_country, $country->getAllCountries());
        $select_countries = JHTML::_('select.genericlist', $option_countryes, 'country', 'class = "inputbox" size = "1"','country_id', 'name', $adv_user->country );
        $select_d_countries = JHTML::_('select.genericlist', $option_countryes, 'd_country', 'class = "inputbox" size = "1"','country_id', 'name', $adv_user->d_country);

        foreach ($jshopConfig->arr['title'] as $key => $value) {
            $option_title[] = JHTML::_('select.option', $key, $value, 'title_id', 'title_name');
        }
        $select_titles = JHTML::_('select.genericlist', $option_title, 'title', 'class = "inputbox"','title_id', 'title_name', $adv_user->title);            
        $select_d_titles = JHTML::_('select.genericlist', $option_title, 'd_title', 'class = "inputbox"','title_id', 'title_name', $adv_user->d_title);
        
        $client_types = array();
        foreach ($jshopConfig->user_field_client_type as $key => $value) {
            $client_types[] = JHTML::_('select.option', $key, $value, 'id', 'name' );
        }
        $select_client_types = JHTML::_('select.genericlist', $client_types,'client_type','class = "inputbox" onchange="showHideFieldFirm(this.value)"','id','name', $adv_user->client_type);
        
        filterHTMLSafe( $adv_user, ENT_QUOTES);

		if ($config_fields['birthday']['display'] || $config_fields['d_birthday']['display']){
            JHTML::_('behavior.calendar');
        }
        $view->assign('config', $jshopConfig);
        $view->assign('select_countries', $select_countries);
        $view->assign('select_d_countries', $select_d_countries);
        $view->assign('select_titles', $select_titles);
        $view->assign('select_d_titles', $select_d_titles);
        $view->assign('select_client_types', $select_client_types);
        $view->assign('live_path', JURI::base());
        $view->assign('config_fields', $config_fields);
        //$view->assign('count_filed_delivery', $count_filed_delivery);
        $view->assign('user', $adv_user);
        $view->assign('delivery_adress', $adv_user->delivery_adress);
        $view->assign('checkout_navigator', $checkout_navigator);
        $view->assign('small_cart', $small_cart);
        $view->assign('action', SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2save', 0, 0, $jshopConfig->use_ssl));
        JSPluginsVars::checkoutstep2($view);
        $dispatcher->trigger('onBeforeDisplayCheckoutStep2View', array(&$view));
        $view->display();
    }
    
    function step2save(){
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
        $checkout->checkStep(2);
        
        JPluginHelper::importPlugin('jshoppingcheckout');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onLoadCheckoutStep2save', array());

        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load();
        
        $session = JFactory::getSession();
        $jshopConfig = JSFactory::getConfig();
        $post = JRequest::get('post');
        if (!count($post)){
            JError::raiseWarning("",_JSHOP_ERROR_DATA);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2',0,1, $jshopConfig->use_ssl));
            return 0;
        }
        if ($post['birthday']) $post['birthday'] = getJsDateDB($post['birthday'], $jshopConfig->field_birthday_format);
        if ($post['d_birthday']) $post['d_birthday'] = getJsDateDB($post['d_birthday'], $jshopConfig->field_birthday_format);
        unset($post['user_id']);
        unset($post['usergroup_id']);
        
        $user = JFactory::getUser();
        if ($user->id){
            $adv_user = JTable::getInstance('userShop', 'jshop');
            $adv_user->load($user->id);
        }else{
            $adv_user = JSFactory::getUserShopGuest();
        }
        
        $adv_user->bind($post);
        if(!$adv_user->check("address")){
            JError::raiseWarning("",$adv_user->getError());
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2',0,1, $jshopConfig->use_ssl));
            return 0;
        }
        $dispatcher->trigger( 'onBeforeSaveCheckoutStep2', array(&$adv_user, &$user, &$cart) );
        
        if(!$adv_user->store()){
            JError::raiseWarning(500,_JSHOP_REGWARN_ERROR_DATABASE);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2',0,1, $jshopConfig->use_ssl));
            return 0;
        }

        if ($user->id){
            $user = clone(JFactory::getUser());
            $user->email = $adv_user->email;            
            $user->name = $adv_user->f_name." ".$adv_user->l_name;
            $user->save();
        }
        
        setNextUpdatePrices();
        
        $dispatcher->trigger( 'onAfterSaveCheckoutStep2', array(&$adv_user, &$user, &$cart) );
        
        if ($jshopConfig->without_shipping && $jshopConfig->without_payment) {
            $checkout->setMaxStep(5);
            $cart->setShippingId(0);
            $cart->setShippingPrId(0);
            $cart->setShippingPrice(0);
            $cart->setPaymentId(0);
            $cart->setPaymentParams("");
            $cart->setPaymentPrice(0);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1, $jshopConfig->use_ssl));
            return 0; 
        }
        
        if ($jshopConfig->without_payment){
            $checkout->setMaxStep(4);
            $cart->setPaymentId(0);
            $cart->setPaymentParams("");
            $cart->setPaymentPrice(0);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step4',0,1,$jshopConfig->use_ssl));
            return 0;
        }

        $checkout->setMaxStep(3);
        $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step3',0,1,$jshopConfig->use_ssl));
    }
    
    function step3(){
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
    	$checkout->checkStep(3);
        
        JPluginHelper::importPlugin('jshoppingcheckout');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onLoadCheckoutStep3', array() );
    	
        $jshopConfig = JSFactory::getConfig();
        $session = JFactory::getSession();
        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load();
        
        $user = JFactory::getUser();
        if ($user->id){
            $adv_user = JSFactory::getUserShop();
        }else{
            $adv_user = JSFactory::getUserShopGuest();
        }
        
        appendPathWay(_JSHOP_CHECKOUT_PAYMENT);
        $seo = JTable::getInstance("seo", "jshop");
        $seodata = $seo->loadData("checkout-payment");
        if ($seodata->title==""){
            $seodata->title = _JSHOP_CHECKOUT_PAYMENT;
        }
        setMetaData($seodata->title, $seodata->keyword, $seodata->description);
        
        $checkout_navigator = $this->_showCheckoutNavigation(3);
        if ($jshopConfig->show_cart_all_step_checkout){
            $small_cart = $this->_showSmallCart(3);
        }else{
            $small_cart = '';
        }
        
        if ($jshopConfig->without_payment){
            $checkout->setMaxStep(4);
            $cart->setPaymentId(0);
            $cart->setPaymentParams("");
            $cart->setPaymentPrice(0);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step4',0,1,$jshopConfig->use_ssl));
            return 0;
        }

        $paymentmethod = JTable::getInstance('paymentmethod', 'jshop');
        $all_payment_methods = $paymentmethod->getAllPaymentMethods();
        $i = 0;
        $paym = array();
        foreach($all_payment_methods as $pm){
            $paym[$i] = new stdClass();
			$paymentsysdata = $paymentmethod->getPaymentSystemData($pm->payment_class);
            if ($paymentsysdata->paymentSystem){
                $paym[$i]->existentcheckform = 1;
				$paym[$i]->payment_system = $paymentsysdata->paymentSystem;
            }else{
                $paym[$i]->existentcheckform = 0;
            }
            
            $paym[$i]->name = $pm->name;
            $paym[$i]->payment_id = $pm->payment_id;
            $paym[$i]->payment_class = $pm->payment_class;
            $paym[$i]->payment_description = $pm->description;
            $paym[$i]->price_type = $pm->price_type;
            $paym[$i]->image = $pm->image;
            $paym[$i]->price_add_text = '';
            if ($pm->price_type==2){
                $paym[$i]->calculeprice = $pm->price;
                if ($paym[$i]->calculeprice!=0){
                    if ($paym[$i]->calculeprice>0){
                        $paym[$i]->price_add_text = '+'.$paym[$i]->calculeprice.'%';
                    }else{
                        $paym[$i]->price_add_text = $paym[$i]->calculeprice.'%';
                    }
                }
            }else{
                $paym[$i]->calculeprice = getPriceCalcParamsTax($pm->price * $jshopConfig->currency_value, $pm->tax_id, $cart->products);
                if ($paym[$i]->calculeprice!=0){
                    if ($paym[$i]->calculeprice>0){
                        $paym[$i]->price_add_text = '+'.formatprice($paym[$i]->calculeprice);
                    }else{
                        $paym[$i]->price_add_text = formatprice($paym[$i]->calculeprice);
                    }
                }
            }
            
            $s_payment_method_id = $cart->getPaymentId();
            if ($s_payment_method_id == $pm->payment_id){
                $params = $cart->getPaymentParams();
            }else{
                $params = array();
            }

            $parseString = new parseString($pm->payment_params);
            $pmconfig = $parseString->parseStringToParams();

            if ($paym[$i]->existentcheckform){
                ob_start();
                $paym[$i]->payment_system->showPaymentForm($params, $pmconfig);
                $paym[$i]->form = ob_get_contents();                
                ob_get_clean();
            }else{
                $paym[$i]->form = "";
            }
            
            $i++;
        }
        
        $s_payment_method_id = $cart->getPaymentId();
        $active_payment = intval($s_payment_method_id);

        if (!$active_payment){
            $list_payment_id = array();
            foreach($paym as $v){
                $list_payment_id[] = $v->payment_id;
            }
            if (in_array($adv_user->payment_id, $list_payment_id)) $active_payment = $adv_user->payment_id;
        }
        
        if (!$active_payment){
            if (isset($paym[0])){
                $active_payment = $paym[0]->payment_id;
            }
        }
        
        if ($jshopConfig->hide_payment_step){
            $first_payment = $paym[0]->payment_class;
            if (!$first_payment){
                JError::raiseWarning("", _JSHOP_ERROR_PAYMENT);
                return 0;
            }
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step3save&payment_method='.$first_payment,0,1,$jshopConfig->use_ssl));
            return 0;
        }
        
        $view_name = "checkout";
        $view_config = array("template_path"=>JPATH_COMPONENT."/templates/".$jshopConfig->template."/".$view_name);
        $view = $this->getView($view_name, getDocumentType(), '', $view_config);
        $view->setLayout("payments");
        $view->assign('payment_methods', $paym);
        $view->assign('active_payment', $active_payment);
        $view->assign('checkout_navigator', $checkout_navigator);
        $view->assign('small_cart', $small_cart);
        $view->assign('action', SEFLink('index.php?option=com_jshopping&controller=checkout&task=step3save', 0, 0, $jshopConfig->use_ssl));
        JSPluginsVars::checkoutstep3($view);
        $dispatcher->trigger('onBeforeDisplayCheckoutStep3View', array(&$view));
        $view->display();    
    }
    
    function step3save(){
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
        $checkout->checkStep(3);
        
        $session = JFactory::getSession();
        $jshopConfig = JSFactory::getConfig();
        $post = JRequest::get('post');
        
        JPluginHelper::importPlugin('jshoppingcheckout');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onBeforeSaveCheckoutStep3save', array(&$post) );
        
        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load();
        
        $user = JFactory::getUser();
        if ($user->id){
            $adv_user = JTable::getInstance('userShop', 'jshop');
            $adv_user->load($user->id);
        }else{
            $adv_user = JSFactory::getUserShopGuest();
        }
        
        $payment_method = JRequest::getVar('payment_method'); //class payment method
        $params = JRequest::getVar('params');
        if (isset($params[$payment_method])){
            $params_pm = $params[$payment_method];
        }else{
            $params_pm = '';
        }
        
        $paym_method = JTable::getInstance('paymentmethod', 'jshop');
        $paym_method->class = $payment_method;
        $payment_method_id = $paym_method->getId();
        $paym_method->load($payment_method_id);
        $pmconfigs = $paym_method->getConfigs();
        $paymentsysdata = $paym_method->getPaymentSystemData();
        $payment_system = $paymentsysdata->paymentSystem;
        if ($paymentsysdata->paymentSystemError){
            $cart->setPaymentParams('');
            JError::raiseWarning(500, _JSHOP_ERROR_PAYMENT);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step3',0,1,$jshopConfig->use_ssl));
            return 0;
        }
        if ($payment_system){
            if (!$payment_system->checkPaymentInfo($params_pm, $pmconfigs)){
                $cart->setPaymentParams('');
                JError::raiseWarning("", $payment_system->getErrorMessage());
                $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step3',0,1,$jshopConfig->use_ssl));
                return 0;
            }            
        }
        
        $paym_method->setCart($cart);
        $cart->setPaymentId($payment_method_id);
        $price = $paym_method->getPrice();
        $cart->setPaymentDatas($price, $paym_method);
        
        if (isset($params[$payment_method])) {
            $cart->setPaymentParams($params_pm);
        } else {
            $cart->setPaymentParams('');
        }
        
        $adv_user->saveTypePayment($payment_method_id);
        
        $dispatcher->trigger( 'onAfterSaveCheckoutStep3save', array(&$adv_user, &$paym_method, &$cart) );
        
        if ($jshopConfig->without_shipping) {
            $checkout->setMaxStep(5);
            $cart->setShippingId(0);
            $cart->setShippingPrice(0);
            $cart->setPackagePrice(0);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1,$jshopConfig->use_ssl));
            return 0; 
        }
        
        $checkout->setMaxStep(4);
        $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step4',0,1,$jshopConfig->use_ssl));
    }
    
    function step4(){
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
        $checkout->checkStep(4);
        
        $session = JFactory::getSession();
        $jshopConfig = JSFactory::getConfig();
        
        JPluginHelper::importPlugin('jshoppingcheckout');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onLoadCheckoutStep4', array() );

        appendPathWay(_JSHOP_CHECKOUT_SHIPPING);
        $seo = JTable::getInstance("seo", "jshop");
        $seodata = $seo->loadData("checkout-shipping");
        if ($seodata->title==""){
            $seodata->title = _JSHOP_CHECKOUT_SHIPPING;
        }
        setMetaData($seodata->title, $seodata->keyword, $seodata->description);
        
        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load();
        
        $user = JFactory::getUser();
        if ($user->id){
            $adv_user = JSFactory::getUserShop();
        }else{
            $adv_user = JSFactory::getUserShopGuest();
        }

        $checkout_navigator = $this->_showCheckoutNavigation(4);
        if ($jshopConfig->show_cart_all_step_checkout){
            $small_cart = $this->_showSmallCart(4);
        }else{
            $small_cart = '';
        }
        
        if ($jshopConfig->without_shipping) {
        	$checkout->setMaxStep(5);
            $cart->setShippingId(0);
            $cart->setShippingPrice(0);
            $cart->setPackagePrice(0);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1,$jshopConfig->use_ssl));
            return 0; 
        }
        
        $shippingmethod = JTable::getInstance('shippingMethod', 'jshop');
        $shippingmethodprice = JTable::getInstance('shippingMethodPrice', 'jshop');
        
        if ($adv_user->delivery_adress){
            $id_country = $adv_user->d_country;
        }else{
            $id_country = $adv_user->country;
        }
        if (!$id_country) $id_country = $jshopConfig->default_country;
        
        if (!$id_country){
            JError::raiseWarning("", _JSHOP_REGWARN_COUNTRY);
        }
        
        if ($jshopConfig->show_delivery_time_checkout){
            $deliverytimes = JSFactory::getAllDeliveryTime();
            $deliverytimes[0] = '';
        }
        if ($jshopConfig->show_delivery_date){
            $deliverytimedays = JSFactory::getAllDeliveryTimeDays();
        }
        $payment_id = $cart->getPaymentId();
        $shippings = $shippingmethod->getAllShippingMethodsCountry($id_country, $payment_id);
        foreach($shippings as $key=>$value){
            $shippingmethodprice->load($value->sh_pr_method_id);
            if ($jshopConfig->show_list_price_shipping_weight){
                $shippings[$key]->shipping_price = $shippingmethodprice->getPricesWeight($value->sh_pr_method_id, $id_country, $cart);
            }
            $prices = $shippingmethodprice->calculateSum($cart);
            $shippings[$key]->calculeprice = $prices['shipping']+$prices['package'];
            $shippings[$key]->delivery = '';
            $shippings[$key]->delivery_date_f = '';
            if ($jshopConfig->show_delivery_time_checkout){
                $shippings[$key]->delivery = $deliverytimes[$value->delivery_times_id];
            }
            if ($jshopConfig->show_delivery_date){
                $day = $deliverytimedays[$value->delivery_times_id];
                if ($day){
                    $shippings[$key]->delivery_date = getCalculateDeliveryDay($day);
                    $shippings[$key]->delivery_date_f = formatdate($shippings[$key]->delivery_date);
                }
            }
        }

        $sh_pr_method_id = $cart->getShippingPrId();
        $active_shipping = intval($sh_pr_method_id);
        if (!$active_shipping){
            foreach($shippings as $v){
                if ($v->shipping_id == $adv_user->shipping_id){
                    $active_shipping = $v->sh_pr_method_id;
                    break;
                }
            }
        }
        if (!$active_shipping){
            if (isset($shippings[0])){
                $active_shipping = $shippings[0]->sh_pr_method_id;
            }
        }
        
        if ($jshopConfig->hide_shipping_step){
            $first_shipping = $shippings[0]->sh_pr_method_id;
            if (!$first_shipping){
                JError::raiseWarning("", _JSHOP_ERROR_SHIPPING);
                return 0;
            }
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step4save&sh_pr_method_id='.$first_shipping,0,1,$jshopConfig->use_ssl));
            return 0;
        }
        
        $view_name = "checkout";
        $view_config = array("template_path"=>JPATH_COMPONENT."/templates/".$jshopConfig->template."/".$view_name);
        $view = $this->getView($view_name, getDocumentType(), '', $view_config);
        $view->setLayout("shippings");
        $view->assign('shipping_methods', $shippings);
        $view->assign('active_shipping', $active_shipping);
        $view->assign('config', $jshopConfig);        
        $view->assign('checkout_navigator', $checkout_navigator);
        $view->assign('small_cart', $small_cart);
        $view->assign('action', SEFLink('index.php?option=com_jshopping&controller=checkout&task=step4save',0,0,$jshopConfig->use_ssl));
        JSPluginsVars::checkoutstep4($view);
        $dispatcher->trigger('onBeforeDisplayCheckoutStep4View', array(&$view));
        $view->display();
    }
    
    function step4save(){
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
    	$checkout->checkStep(4);
        $session = JFactory::getSession();
        $jshopConfig = JSFactory::getConfig();
        
        JPluginHelper::importPlugin('jshoppingcheckout');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger( 'onBeforeSaveCheckoutStep4save', array());

        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load();
        
        $user = JFactory::getUser();
        if ($user->id){
            $adv_user = JTable::getInstance('userShop', 'jshop');
            $adv_user->load($user->id);
        }else{
            $adv_user = JSFactory::getUserShopGuest();
        }
        
        if ($adv_user->delivery_adress){
            $id_country = $adv_user->d_country;
        }else{
            $id_country = $adv_user->country;
        }
        if (!$id_country) $id_country = $jshopConfig->default_country;
        
        $sh_pr_method_id = JRequest::getInt('sh_pr_method_id');
                
        $shipping_method_price = JTable::getInstance('shippingMethodPrice', 'jshop');
        $shipping_method_price->load($sh_pr_method_id);
        
        $sh_method = JTable::getInstance('shippingMethod', 'jshop');
        $sh_method->load($shipping_method_price->shipping_method_id);
        
        if (!$shipping_method_price->sh_pr_method_id){
            JError::raiseWarning("", _JSHOP_ERROR_SHIPPING);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step4',0,1,$jshopConfig->use_ssl));
            return 0;
        }
        
        if (!$shipping_method_price->isCorrectMethodForCountry($id_country)){
            JError::raiseWarning("",_JSHOP_ERROR_SHIPPING);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step4',0,1,$jshopConfig->use_ssl));
            return 0;
        }
        
        if (!$sh_method->shipping_id){
            JError::raiseWarning("", _JSHOP_ERROR_SHIPPING);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step4',0,1,$jshopConfig->use_ssl));
            return 0;
        }
        
        $prices = $shipping_method_price->calculateSum($cart);
        $cart->setShippingId($sh_method->shipping_id);
        $cart->setShippingPrId($sh_pr_method_id);
        $cart->setShippingsDatas($prices, $shipping_method_price);
        
        if ($jshopConfig->show_delivery_date){
            $delivery_date = '';
            $deliverytimedays = JSFactory::getAllDeliveryTimeDays();
            $day = $deliverytimedays[$shipping_method_price->delivery_times_id];
            if ($day){
                $delivery_date = getCalculateDeliveryDay($day);
            }else{
                if ($jshopConfig->delivery_order_depends_delivery_product){
                    $day = $cart->getDeliveryDaysProducts();
                    if ($day){
                        $delivery_date = getCalculateDeliveryDay($day);                    
                    }
                }
            }
            $cart->setDeliveryDate($delivery_date);
        }

        //update payment price
        $payment_method_id = $cart->getPaymentId();
        if ($payment_method_id){
            $paym_method = JTable::getInstance('paymentmethod', 'jshop');
            $paym_method->load($payment_method_id);
            $cart->setDisplayItem(1, 1);
            $paym_method->setCart($cart);
            $price = $paym_method->getPrice();
            $cart->setPaymentDatas($price, $paym_method);            
        }

        $adv_user->saveTypeShipping($sh_method->shipping_id);
        
        $dispatcher->trigger( 'onAfterSaveCheckoutStep4', array(&$adv_user, &$sh_method, &$shipping_method_price, &$cart) );        
        $checkout->setMaxStep(5);
        $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1,$jshopConfig->use_ssl));
    }
    
    function step5(){
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
        $checkout->checkStep(5);
        JPluginHelper::importPlugin('jshoppingcheckout');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onLoadCheckoutStep5', array() );

        appendPathWay(_JSHOP_CHECKOUT_PREVIEW);
        $seo = JTable::getInstance("seo", "jshop");
        $seodata = $seo->loadData("checkout-preview");
        if ($seodata->title==""){
            $seodata->title = _JSHOP_CHECKOUT_PREVIEW;
        }
        setMetaData($seodata->title, $seodata->keyword, $seodata->description);

        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load();

        $session = JFactory::getSession();
        $jshopConfig = JSFactory::getConfig(); 
        $user = JFactory::getUser();
        if ($user->id){
            $adv_user = JSFactory::getUserShop();
        }else{
            $adv_user = JSFactory::getUserShopGuest();
        }

        $sh_method = JTable::getInstance('shippingMethod', 'jshop');
        $shipping_method_id = $cart->getShippingId();
        $sh_method->load($shipping_method_id);
        
        $sh_mt_pr = JTable::getInstance('shippingMethodPrice', 'jshop');
        $sh_mt_pr->load($cart->getShippingPrId());
        if ($jshopConfig->show_delivery_time_checkout){
            $deliverytimes = JSFactory::getAllDeliveryTime();
            $deliverytimes[0] = '';
            $delivery_time = $deliverytimes[$sh_mt_pr->delivery_times_id];
            if (!$delivery_time && $jshopConfig->delivery_order_depends_delivery_product){
                $delivery_time = $cart->getDelivery();
            }
        }else{
            $delivery_time = '';
        }
        if ($jshopConfig->show_delivery_date){
            $delivery_date = $cart->getDeliveryDate();
            if ($delivery_date){
                $delivery_date = formatdate($cart->getDeliveryDate());
            }
        }else{
            $delivery_date = '';
        }
        
        $pm_method = JTable::getInstance('paymentMethod', 'jshop');
        $payment_method_id = $cart->getPaymentId();
		$pm_method->load($payment_method_id); 

        $lang = JSFactory::getLang();
        $field_country_name = $lang->get("name");
        
        $invoice_info = array();
        $country = JTable::getInstance('country', 'jshop');
        $country->load($adv_user->country);
        $invoice_info['f_name'] = $adv_user->f_name;
        $invoice_info['l_name'] = $adv_user->l_name;
        $invoice_info['firma_name'] = $adv_user->firma_name;
        $invoice_info['street'] = $adv_user->street;
        $invoice_info['zip'] = $adv_user->zip;
        $invoice_info['state'] = $adv_user->state;
        $invoice_info['city'] = $adv_user->city;
        $invoice_info['country'] = $country->$field_country_name;
        $invoice_info['home'] = $adv_user->home;
        $invoice_info['apartment'] = $adv_user->apartment;
        
		if ($adv_user->delivery_adress){
            $country = JTable::getInstance('country', 'jshop');
            $country->load($adv_user->d_country);
			$delivery_info['f_name'] = $adv_user->d_f_name;
            $delivery_info['l_name'] = $adv_user->d_l_name;
			$delivery_info['firma_name'] = $adv_user->d_firma_name;
			$delivery_info['street'] = $adv_user->d_street;
			$delivery_info['zip'] = $adv_user->d_zip;
			$delivery_info['state'] = $adv_user->d_state;
            $delivery_info['city'] = $adv_user->d_city;
			$delivery_info['country'] = $country->$field_country_name;
            $delivery_info['home'] = $adv_user->d_home;
            $delivery_info['apartment'] = $adv_user->d_apartment;
		} else {
            $delivery_info = $invoice_info;
		}
        
        $tmp_fields = $jshopConfig->getListFieldsRegister();
        $config_fields = $tmp_fields['address'];
        $count_filed_delivery = $jshopConfig->getEnableDeliveryFiledRegistration('address');
        
        $checkout_navigator = $this->_showCheckoutNavigation(5);
        $small_cart = $this->_showSmallCart(5);

		$view_name = "checkout";
        $view_config = array("template_path"=>JPATH_COMPONENT."/templates/".$jshopConfig->template."/".$view_name);
        $view = $this->getView($view_name, getDocumentType(), '', $view_config);
        $view->setLayout("previewfinish");
        $dispatcher->trigger('onBeforeDisplayCheckoutStep5', array(&$sh_method, &$pm_method, &$delivery_info, &$cart, &$view));
        $lang = JSFactory::getLang();
        $name = $lang->get("name");
        $sh_method->name = $sh_method->$name;
		$view->assign('sh_method', $sh_method );
		$view->assign('payment_name', $pm_method->$name);
        $view->assign('delivery_info', $delivery_info);
		$view->assign('invoice_info', $invoice_info);
        $view->assign('action', SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5save',0,0, $jshopConfig->use_ssl));       
        $view->assign('config', $jshopConfig);
        $view->assign('delivery_time', $delivery_time);
        $view->assign('delivery_date', $delivery_date);
        $view->assign('checkout_navigator', $checkout_navigator);
        $view->assign('small_cart', $small_cart);
		$view->assign('count_filed_delivery', $count_filed_delivery);
        JSPluginsVars::checkoutstep5($view);
        $dispatcher->trigger('onBeforeDisplayCheckoutStep5View', array(&$view));
    	$view->display();
    }

    function step5save(){
		$session = JFactory::getSession();
        $jshopConfig = JSFactory::getConfig();
        $db = JFactory::getDBO();
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
        $mainframe = JFactory::getApplication();
        $checkout->checkStep(5);
		$checkagb = JRequest::getVar('agb');

        JPluginHelper::importPlugin('jshoppingorder');
        $dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger('onLoadStep5save', array(&$checkagb));
        
        $lang = JSFactory::getLang();
        $user = JFactory::getUser();
        if ($user->id){
            $adv_user = JSFactory::getUserShop();
        }else{
            $adv_user = JSFactory::getUserShopGuest();
        }
        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load();
        $cart->setDisplayItem(1, 1);
        $cart->setDisplayFreeAttributes();
		
		if ($jshopConfig->check_php_agb && $checkagb!='on'){
            JError::raiseWarning("", _JSHOP_ERROR_AGB);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1,$jshopConfig->use_ssl));
            return 0;
        }

        if (!$cart->checkListProductsQtyInStore()){
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=cart&task=view',1,1));
            return 0;
        }

        $session = JFactory::getSession();
        $jshopConfig = JSFactory::getConfig();
        $orderNumber = $jshopConfig->next_order_number;
        $jshopConfig->updateNextOrderNumber();
        $db = JFactory::getDBO();

        $payment_method_id = $cart->getPaymentId();
        $pm_method = JTable::getInstance('paymentMethod', 'jshop');
        $pm_method->load($payment_method_id);
		$payment_method = $pm_method->payment_class;

        if ($jshopConfig->without_payment){
            $pm_method->payment_type = 1;
            $paymentSystemVerySimple = 1; 
        }else{
            $paymentsysdata = $pm_method->getPaymentSystemData();
            $payment_system = $paymentsysdata->paymentSystem;
            if ($paymentsysdata->paymentSystemVerySimple){
                $paymentSystemVerySimple = 1;
            }
            if ($paymentsysdata->paymentSystemError){
                $cart->setPaymentParams("");
                JError::raiseWarning("",_JSHOP_ERROR_PAYMENT);
                $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step3',0,1,$jshopConfig->use_ssl));
                return 0;
            }
        }

        $order = JTable::getInstance('order', 'jshop');
        $arr_property = $order->getListFieldCopyUserToOrder();
        foreach($adv_user as $key => $value){
            if (in_array($key, $arr_property)){
                $order->$key = $value;
            }
        }

        $sh_mt_pr = JTable::getInstance('shippingMethodPrice', 'jshop');
        $sh_mt_pr->load($cart->getShippingPrId());

        $order->order_date = $order->order_m_date = date("Y-m-d H:i:s", time());
        $order->order_tax = $cart->getTax(1, 1, 1);
        $order->setTaxExt($cart->getTaxExt(1, 1, 1));
        $order->order_subtotal = $cart->getPriceProducts();
        $order->order_shipping = $cart->getShippingPrice();
        $order->order_payment = $cart->getPaymentPrice();
        $order->order_discount = $cart->getDiscountShow();
        $order->shipping_tax = $cart->getShippingPriceTaxPercent();
        $order->setShippingTaxExt($cart->getShippingTaxList());
        $order->payment_tax = $cart->getPaymentTaxPercent();
        $order->setPaymentTaxExt($cart->getPaymentTaxList());
        $order->order_package = $cart->getPackagePrice();
        $order->setPackageTaxExt($cart->getPackageTaxList());
        $order->order_total = $cart->getSum(1, 1, 1);
        $order->currency_exchange = $jshopConfig->currency_value;
        $order->vendor_type = $cart->getVendorType();
        $order->vendor_id = $cart->getVendorId();
        $order->order_status = $jshopConfig->default_status_order;
        $order->shipping_method_id = $cart->getShippingId();
        $order->payment_method_id = $cart->getPaymentId();
        $order->delivery_times_id = $sh_mt_pr->delivery_times_id;
        if ($jshopConfig->delivery_order_depends_delivery_product){
            $order->delivery_time = $cart->getDelivery();
        }
        if ($jshopConfig->show_delivery_date){
            $order->delivery_date = $cart->getDeliveryDate();
        }
        $order->coupon_id = $cart->getCouponId();

        $pm_params = $cart->getPaymentParams();

        if (is_array($pm_params) && !$paymentSystemVerySimple){
            $payment_system->setParams($pm_params);
            $payment_params_names = $payment_system->getDisplayNameParams();
            $order->payment_params = getTextNameArrayValue($payment_params_names, $pm_params);
            $order->setPaymentParamsData($pm_params);
        }
        
        $name = $lang->get("name");
        $order->ip_address = $_SERVER['REMOTE_ADDR'];
        $order->order_add_info = JRequest::getVar('order_add_info','');
        $order->currency_code = $jshopConfig->currency_code;
        $order->currency_code_iso = $jshopConfig->currency_code_iso;
        $order->order_number = $order->formatOrderNumber($orderNumber);
        $order->order_hash = md5(time().$order->order_total.$order->user_id);
        $order->file_hash = md5(time().$order->order_total.$order->user_id."hashfile");
        $order->display_price = $jshopConfig->display_price_front_current;
        $order->lang = $jshopConfig->cur_lang;
        
        if ($order->client_type){
            $order->client_type_name = $jshopConfig->user_field_client_type[$order->client_type];
        }else{
            $order->client_type_name = "";
        }
		
		if ($order->order_total==0){
            $pm_method->payment_type = 1;
            $jshopConfig->without_payment = 1;
            $order->order_status = $jshopConfig->payment_status_paid;
        }
        
        if ($pm_method->payment_type == 1){
            $order->order_created = 1; 
        }else {
            $order->order_created = 0;
        }
        
        if (!$adv_user->delivery_adress) $order->copyDeliveryData();
        
        $dispatcher->trigger('onBeforeCreateOrder', array(&$order));

        $order->store();

        $dispatcher->trigger('onAfterCreateOrder', array(&$order));

        if ($cart->getCouponId()){
            $coupon = JTable::getInstance('coupon', 'jshop');
            $coupon->load($cart->getCouponId());
            if ($coupon->finished_after_used){
                $free_discount = $cart->getFreeDiscount();
                if ($free_discount > 0){
                    $coupon->coupon_value = $free_discount / $jshopConfig->currency_value;
                }else{
                    $coupon->used = $adv_user->user_id;
                }
                $coupon->store();
            }
        }

        $order->saveOrderItem($cart->products);

        $session->set("jshop_end_order_id", $order->order_id);

        $order_history = JTable::getInstance('orderHistory', 'jshop');
        $order_history->order_id = $order->order_id;
        $order_history->order_status_id = $order->order_status;
        $order_history->status_date_added = $order->order_date;
        $order_history->customer_notify = 1;
        $order_history->store();
        
        if ($pm_method->payment_type == 1){
            $order->changeProductQTYinStock("-");
            if ($jshopConfig->send_order_email){
                $checkout->sendOrderEmail($order->order_id);
            }
        }
        
        $dispatcher->trigger('onEndCheckoutStep5', array(&$order) );

        $session->set("jshop_send_end_form", 0);
        
        if ($jshopConfig->without_payment){
            $checkout->setMaxStep(10);
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=finish',0,1,$jshopConfig->use_ssl));
            return 0;
        }
        
        $pmconfigs = $pm_method->getConfigs();
        
        $task = "step6";
        if (isset($pmconfigs['windowtype']) && $pmconfigs['windowtype']==2){
            $task = "step6iframe";
            $session->set("jsps_iframe_width", $pmconfigs['iframe_width']);
            $session->set("jsps_iframe_height", $pmconfigs['iframe_height']);
        }
        $checkout->setMaxStep(6);
        $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task='.$task,0,1,$jshopConfig->use_ssl));
    }

    function step6iframe(){
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
        $checkout->checkStep(6);
        $jshopConfig = JSFactory::getConfig();
        $session = JFactory::getSession();
        $width = $session->get("jsps_iframe_width");
        $height = $session->get("jsps_iframe_height");
        if (!$width) $width = 600;
        if (!$height) $height = 600;
        ?><iframe width="<?php print $width?>" height="<?php print $height?>" frameborder="0" src="<?php print SEFLink('index.php?option=com_jshopping&controller=checkout&task=step6&wmiframe=1',0,1,$jshopConfig->use_ssl)?>"></iframe><?php
    }

    function step6(){
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
        $checkout->checkStep(6);
        $jshopConfig = JSFactory::getConfig();
        $session = JFactory::getSession();
        header("Cache-Control: no-cache, must-revalidate");
        $order_id = $session->get('jshop_end_order_id');
        $wmiframe = JRequest::getInt("wmiframe");

        if (!$order_id){
            JError::raiseWarning("", _JSHOP_SESSION_FINISH);
            if (!$wmiframe){
                $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1,$jshopConfig->use_ssl));
            }else{
                $this->iframeRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1,$jshopConfig->use_ssl));
            }
        }
        
        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load();
        
        $order = JTable::getInstance('order', 'jshop');
        $order->load($order_id);

        // user click back in payment system 
        $jshop_send_end_form = $session->get('jshop_send_end_form');
        if ($jshop_send_end_form == 1){
            $this->_cancelPayOrder($order_id);
            return 0;
        }

        $pm_method = JTable::getInstance('paymentMethod', 'jshop');
        $payment_method_id = $order->payment_method_id;
        $pm_method->load($payment_method_id);
        $payment_method = $pm_method->payment_class; 
        
		$paymentsysdata = $pm_method->getPaymentSystemData();
        $payment_system = $paymentsysdata->paymentSystem;
        if ($paymentsysdata->paymentSystemVerySimple){
            $paymentSystemVerySimple = 1;
        }
        if ($paymentsysdata->paymentSystemError){
            $cart->setPaymentParams("");
            JError::raiseWarning("",_JSHOP_ERROR_PAYMENT);
            if (!$wmiframe){
                $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step3',0,1,$jshopConfig->use_ssl));
            }else{
                $this->iframeRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step3',0,1,$jshopConfig->use_ssl));
            }
            return 0;
        }
		
        if ($pm_method->payment_type == 1 || $paymentSystemVerySimple) { 
            $checkout->setMaxStep(10);
            if (!$wmiframe){
                $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=finish',0,1,$jshopConfig->use_ssl));
            }else{
                $this->iframeRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=finish',0,1,$jshopConfig->use_ssl));
            }
            return 0;
        }

        $session->set('jshop_send_end_form', 1);

        $pmconfigs = $pm_method->getConfigs();
        $payment_system->showEndForm($pmconfigs, $order);
    }

    function step7(){
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
        $wmiframe = JRequest::getInt("wmiframe");
        $mainframe = JFactory::getApplication();
        $jshopConfig = JSFactory::getConfig();
        $session = JFactory::getSession();
        $pm_method = JTable::getInstance('paymentMethod', 'jshop');
        
        if ($jshopConfig->savelog && $jshopConfig->savelogpaymentdata){
            $str = "url: ".$_SERVER['REQUEST_URI']."\n";
            foreach($_POST as $k=>$v) $str .= $k."=".$v."\n";
            saveToLog("paymentdata.log", $str);
        }
        
        $act = JRequest::getVar("act");
        $payment_method = JRequest::getVar("js_paymentclass");
        
		$paymentsysdata = $pm_method->getPaymentSystemData($payment_method);
        $payment_system = $paymentsysdata->paymentSystem;
        if ($paymentsysdata->paymentSystemVerySimple){
            if (JRequest::getInt('no_lang')) JSFactory::loadLanguageFile();
            saveToLog("payment.log", "#001 - Error payment method file. PM ".$payment_method);
            JError::raiseWarning(500, _JSHOP_ERROR_PAYMENT);
            return 0;
        } 
        if ($paymentsysdata->paymentSystemError){
            if (JRequest::getInt('no_lang')) JSFactory::loadLanguageFile();
            saveToLog("payment.log", "#002 - Error payment. CLASS ".$payment_method);
            JError::raiseWarning(500, _JSHOP_ERROR_PAYMENT);
            return 0;
        }
        
        $pmconfigs = $pm_method->getConfigsForClassName($payment_method);
        $urlParamsPS = $payment_system->getUrlParams($pmconfigs);
        
        $order_id = $urlParamsPS['order_id'];
        $hash = $urlParamsPS['hash'];
        $checkHash = $urlParamsPS['checkHash'];
        $checkReturnParams = $urlParamsPS['checkReturnParams'];
        
        $session->set('jshop_send_end_form', 0);
        
        if ($act == "cancel"){
            $this->_cancelPayOrder($order_id);
            return 0;
        }
        
        if ($act == "return" && !$checkReturnParams){
            $checkout->setMaxStep(10);
            if (!$wmiframe){
                $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=finish', 0, 1, $jshopConfig->use_ssl));
            }else{
                $this->iframeRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=finish', 0, 1, $jshopConfig->use_ssl));
            }
            return 1;
        }
        
        $order = JTable::getInstance('order', 'jshop');
        $order->load($order_id);
        
        if (JRequest::getInt('no_lang')){
            JSFactory::loadLanguageFile($order->getLang());
            $lang = JSFactory::getLang($order->getLang());
        }

        if ($checkHash && $order->order_hash != $hash){
            saveToLog("payment.log", "#003 - Error order hash. Order id ".$order_id);
            JError::raiseWarning("", _JSHOP_ERROR_ORDER_HASH);
            return 0;
        }
        
        if (!$order->payment_method_id){
            saveToLog("payment.log", "#004 - Error payment method id. Order id ".$order_id);
            JError::raiseWarning("", _JSHOP_ERROR_PAYMENT);
            return 0;
        }        
                
        $pm_method->load($order->payment_method_id);
        
        if ($payment_method != $pm_method->payment_class){
            saveToLog("payment.log", "#005 - Error payment method set url. Order id ".$order_id);
            JError::raiseWarning("", _JSHOP_ERROR_PAYMENT);
            return 0;
        }
                
        $pmconfigs = $pm_method->getConfigs();
        $res = $payment_system->checkTransaction($pmconfigs, $order, $act);
        $rescode = $res[0];
        $restext = $res[1];
        
        if ($rescode != 1){
            saveToLog("payment.log", $restext);
        }

        $status = 0;
        $types_status = array(0=>0, 1=>$pmconfigs['transaction_end_status'], 2=>$pmconfigs['transaction_pending_status'], 3=>$pmconfigs['transaction_failed_status'], 4=>$pmconfigs['transaction_cancel_status'], 5=>$pmconfigs['transaction_open_status'], 6=>$pmconfigs['transaction_shipping_status'], 7=>$pmconfigs['transaction_refunded_status'], 8=>$pmconfigs['transaction_confirm_status'], 9=>$pmconfigs['transaction_complete_status'], 10=>$pmconfigs['transaction_other_status'], 99=>0);
        if (isset($types_status[$rescode])) $status = $types_status[$rescode];

        if ($status && !$order->order_created){
            $order->order_created = 1;
            $order->order_status = $status;
            $order->store();
			if ($jshopConfig->send_order_email){
                $checkout->sendOrderEmail($order->order_id);
            }
            $checkout->sendOrderEmail($order->order_id);
            $order->changeProductQTYinStock("-");
            $checkout->changeStatusOrder($order_id, $status, 0);
        }

        if ($status && $order->order_status != $status){
           $checkout->changeStatusOrder($order_id, $status, 1);
        }

        if ($act == "notify"){
            $payment_system->nofityFinish($pmconfigs, $order, $rescode);
            die();
        }
        
        $payment_system->finish($pmconfigs, $order, $rescode, $act);

        if (in_array($rescode, array(0,3,4))){
            JError::raiseWarning(500, $restext);
            if (!$wmiframe){
                $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1,$jshopConfig->use_ssl));
            }else{
                $this->iframeRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1,$jshopConfig->use_ssl));
            }
            return 0;
        }else{
            $checkout->setMaxStep(10);
            if (!$wmiframe){
                $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=finish',0,1,$jshopConfig->use_ssl));
            }else{
                $this->iframeRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=finish',0,1,$jshopConfig->use_ssl));
            }
            return 1;
        }
    }

    function finish(){
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
        $checkout->checkStep(10);
        $jshopConfig = JSFactory::getConfig();
        $session = JFactory::getSession();
        $order_id = $session->get('jshop_end_order_id');

        $document = JFactory::getDocument();
        $document->setTitle(_JSHOP_CHECKOUT_FINISH);
        appendPathWay(_JSHOP_CHECKOUT_FINISH);

        $statictext = JTable::getInstance("statictext","jshop");
        $rowstatictext = $statictext->loadData("order_finish_descr");
        $text = $rowstatictext->text;

        JPluginHelper::importPlugin('jshoppingcheckout');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onBeforeDisplayCheckoutFinish', array(&$text, &$order_id));

        if (trim(strip_tags($text))==""){
            $text = '';
        }

        $view_name = "checkout";
        $view_config = array("template_path"=>JPATH_COMPONENT."/templates/".$jshopConfig->template."/".$view_name);
        $view = $this->getView($view_name, getDocumentType(), '', $view_config);
        $view->setLayout("finish");
        $view->assign('text', $text);
        $view->display();

        if ($order_id){
            $order = JTable::getInstance('order', 'jshop');
            $order->load($order_id);
            $pm_method = JTable::getInstance('paymentMethod', 'jshop');
            $payment_method_id = $order->payment_method_id;
            $pm_method->load($payment_method_id);
            $paymentsysdata = $pm_method->getPaymentSystemData();
            $payment_system = $paymentsysdata->paymentSystem;
            if ($payment_system){
                $pmconfigs = $pm_method->getConfigs();
                $payment_system->complete($pmconfigs, $order, $pm_method);
            }
            $dispatcher->trigger('onAfterDisplayCheckoutFinish', array(&$text, &$order, &$pm_method));
        }

        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load();
        $cart->getSum();
        $cart->clear();
        $checkout->deleteSession();
    }

    function _showSmallCart($step = 0){
        $jshopConfig = JSFactory::getConfig();
        $session = JFactory::getSession();
        
        $cart = JModelLegacy::getInstance('cart', 'jshop');
        $cart->load();
        $cart->addLinkToProducts(0);
        $cart->setDisplayFreeAttributes();
        
        if ($step == 5) {
            $cart->setDisplayItem(1, 1);
        }elseif ($step == 4) {
            $cart->setDisplayItem(0, 1);
        }else{
            $cart->setDisplayItem(0, 0);
        }
        $cart->updateDiscountData();
        
        JPluginHelper::importPlugin('jshoppingcheckout');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger( 'onBeforeDisplaySmallCart', array(&$cart) );
                
        $view_name = "cart";
        $view_config = array("template_path"=>JPATH_COMPONENT."/templates/".$jshopConfig->template."/".$view_name);
        $view = $this->getView($view_name, getDocumentType(), '', $view_config);
        $view->setLayout("checkout");
        
        $view->assign('step', $step);
        $view->assign('config', $jshopConfig);
        $view->assign('products', $cart->products);
        $view->assign('summ', $cart->getPriceProducts());
        $view->assign('image_product_path', $jshopConfig->image_product_live_path);
        $view->assign('no_image', $jshopConfig->noimage);
        $view->assign('discount', $cart->getDiscountShow());
        $view->assign('free_discount', $cart->getFreeDiscount());
        $deliverytimes = JSFactory::getAllDeliveryTime();
        $view->assign('deliverytimes', $deliverytimes);
        
        if ($step == 5){
            if (!$jshopConfig->without_shipping){
                $view->assign('summ_delivery', $cart->getShippingPrice());
                if ($cart->getPackagePrice()>0 || $jshopConfig->display_null_package_price){
                    $view->assign('summ_package', $cart->getPackagePrice());
                }
                $fullsumm = $cart->getSum(1,1,1);
                $tax_list = $cart->getTaxExt(1,1,1);
            }else{                
                $fullsumm = $cart->getSum(0,1,1);
                $tax_list = $cart->getTaxExt(0,1,1);
            }
            
            $lang = JSFactory::getLang();
            $name = $lang->get("name");
            $pm_method = JTable::getInstance('paymentMethod', 'jshop');
            $payment_method_id = $cart->getPaymentId();
            $pm_method->load($payment_method_id);
            $view->assign('payment_name', $pm_method->$name);
            $view->assign('summ_payment', $cart->getPaymentPrice());
        }elseif($step == 4){
            $view->assign('summ_payment', $cart->getPaymentPrice());
            $fullsumm = $cart->getSum(0,1,1);
            $tax_list = $cart->getTaxExt(0,1,1);
            
            $lang = JSFactory::getLang();
            $name = $lang->get("name");
            $pm_method = JTable::getInstance('paymentMethod', 'jshop');
            $payment_method_id = $cart->getPaymentId();
            $pm_method->load($payment_method_id);
            $view->assign('payment_name', $pm_method->$name);
        }else{
            $fullsumm = $cart->getSum(0, 1, 0);
            $tax_list = $cart->getTaxExt(0, 1, 0);
            $view->assign('summ_payment', 0);
        }
        
        $show_percent_tax = 0;
        if (count($tax_list)>1 || $jshopConfig->show_tax_in_product) $show_percent_tax = 1;
        if ($jshopConfig->hide_tax) $show_percent_tax = 0;
        $hide_subtotal = 0;
        if ($step == 5) {
            if (($jshopConfig->hide_tax || count($tax_list)==0) && !$cart->rabatt_summ && $jshopConfig->without_shipping && $cart->getPaymentPrice()==0) $hide_subtotal = 1;
        }elseif ($step == 4) {
            if (($jshopConfig->hide_tax || count($tax_list)==0) && !$cart->rabatt_summ && $cart->getPaymentPrice()==0) $hide_subtotal = 1;
        }else{
            if (($jshopConfig->hide_tax || count($tax_list)==0) && !$cart->rabatt_summ) $hide_subtotal = 1;
        }
        
        $text_total = _JSHOP_PRICE_TOTAL;
        if ($step == 5){
            $text_total = _JSHOP_ENDTOTAL;
            if (($jshopConfig->show_tax_in_product || $jshopConfig->show_tax_product_in_cart) && (count($tax_list)>0)){
                $text_total = _JSHOP_ENDTOTAL_INKL_TAX;
            }
        }

        $view->assign('tax_list', $tax_list);
        $view->assign('fullsumm', $fullsumm);
        $view->assign('show_percent_tax', $show_percent_tax);
        $view->assign('hide_subtotal', $hide_subtotal);
        $view->assign('text_total', $text_total);
        $view->assign('weight', $cart->getWeightProducts());
        JSPluginsVars::showsmallcart($view);
        $dispatcher->trigger('onBeforeDisplayCheckoutCartView', array(&$view));
    return $view->loadTemplate();
    }
    
    function _showCheckoutNavigation($step){
        $jshopConfig = JSFactory::getConfig();
        $array_navigation_steps = array('2' => _JSHOP_STEP_ORDER_2, '3' => _JSHOP_STEP_ORDER_3, '4' => _JSHOP_STEP_ORDER_4, '5' => _JSHOP_STEP_ORDER_5);
        $output = array();
        if ($jshopConfig->without_shipping || $jshopConfig->hide_shipping_step) unset($array_navigation_steps[4]);
        if ($jshopConfig->without_payment || $jshopConfig->hide_payment_step) unset($array_navigation_steps[3]);
        
        foreach($array_navigation_steps as $key=>$value){
            if($key < $step){
                $output[] = '<a href="'.SEFLink('index.php?option=com_jshopping&controller=checkout&task=step'.$key,0,0,$jshopConfig->use_ssl).'">'.$value.'</a>';
            } else{
                if($key == $step)
                    $output[] = '<span id="active_step">'.$value.'</span>';
                else
                    $output[] = $value;
            }
        }
        
        JPluginHelper::importPlugin('jshoppingcheckout');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger( 'onBeforeDisplayCheckoutNavigator', array(&$output, &$array_navigation_steps) );
                
        $view_name = "checkout";
        $view_config = array("template_path"=>JPATH_COMPONENT."/templates/".$jshopConfig->template."/".$view_name);
        $view = $this->getView($view_name, getDocumentType(), '', $view_config);
        $view->setLayout("menu");
        $view->assign('steps', $output);
        $dispatcher->trigger('onAfterDisplayCheckoutNavigator', array(&$view));
    return $view->loadTemplate();
    }

    function _cancelPayOrder($order_id=""){
        $jshopConfig = JSFactory::getConfig();
        $checkout = JModelLegacy::getInstance('checkout', 'jshop');
        $wmiframe = JRequest::getInt("wmiframe");
        $session = JFactory::getSession();
        if (!$order_id) $order_id = $session->get('jshop_end_order_id');
        if (!$order_id){
            JError::raiseWarning("", _JSHOP_SESSION_FINISH);
            if (!$wmiframe){
                $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1,$jshopConfig->use_ssl));
            }else{
                $this->iframeRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1,$jshopConfig->use_ssl));
            }
            return 0;
        }

        $checkout->cancelPayOrder($order_id);
        
        JError::raiseWarning("", _JSHOP_PAYMENT_CANCELED);
        if (!$wmiframe){ 
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1, $jshopConfig->use_ssl));
        }else{
            $this->iframeRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5',0,1, $jshopConfig->use_ssl));
        }
        return 0;
    }
    
    function iframeRedirect($url){
        echo "<script>parent.location.href='$url';</script>\n";
        $mainframe = JFactory::getApplication();
        $mainframe->close();
    }
    
}
?>