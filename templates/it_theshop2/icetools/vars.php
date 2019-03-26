<?php
//  © IceTheme 2013

// No direct access.
defined('_JEXEC') or die;

$document = &JFactory::getDocument();

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->getCfg('sitename');

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Add current user information
$user = JFactory::getUser();

// Add pageclass from menu item
$pageclass =  & $app->getParams('com_content');


// Equal Columns JS
if ($this->params->get('equal_column')) {
$document->addScript('templates/' . $this->template . '/js/equal-columns.js');
}

// Template Style 
if(!empty($_COOKIE['templatestyle'])) $templatestyle = $_COOKIE['templatestyle'];
else $templatestyle =  $this->params->get('TemplateStyle');

// Logo 
$logo = '<img src="'. JURI::root() . $this->params->get('logo') .'" alt="'. $sitename .'" />';

// Social - Facebook
$social_fb_user = $this->params->get('social_fb_user');
$social_fb = '';

// Social - Twitter
$social_tw_user = $this->params->get('social_tw_user');
$social_tw = '';

// Social - Youtube
$social_yt_user = $this->params->get('social_yt_user');

// Social Icons 
if($this->params->get('social_icon_fb')) {
}
	

// Add JS to head
if ($this->params->get('go2top')) { 
$doc->addScriptDeclaration('
    jQuery(document).ready(function(){ 
			
		jQuery(window).scroll(function(){
			if ( jQuery(this).scrollTop() > 1000) {
				 jQuery(".scrollup").addClass("gotop_active");
			} else {
				 jQuery(".scrollup").removeClass("gotop_active");
			}
		}); 
		jQuery(".scrollup").click(function(){
			jQuery("html, body").animate({ scrollTop: 0 }, 600);
			return false;
		});
			
			jQuery("[rel=\'tooltip\']").tooltip();
 
		});
		
		
	
	
');
}


// Adjusting columns width
if ($this->countModules('left and right'))
{
	$colspan = "span6";
}
elseif ($this->countModules('left or right'))
{
	$colspan = "span9";
}
else
{
	$colspan = "span12";
}


// Adjusting promo width
if ($this->countModules('promo1 and promo2 and promo3 and promo4'))
{
	$promospan = "span3";
}
elseif ($this->countModules('promo1 and promo2 and promo3'))
{
	$promospan = "span4";
}
elseif ($this->countModules('promo1 and promo2'))
{
	$promospan = "span6";
}
elseif ($this->countModules('promo1 and promo3'))
{
	$promospan = "span6";
}
elseif ($this->countModules('promo2 and promo3'))
{
	$promospan = "span6";
}
else
{
	$promospan = "span12";
}


// Adjusting footer width
if ($this->countModules('footer1 and footer2 and footer3 and footer4'))
{
	$footerspan = "span3";
}
elseif ($this->countModules('footer1 and footer2 and footer3'))
{
	$footerspan = "span4";
}
elseif ($this->countModules('footer1 and footer2'))
{
	$footerspan = "span6";
}
elseif ($this->countModules('footer3 and footer2'))
{
	$footerspan = "span6";
}
elseif ($this->countModules('footer1 and footer3'))
{
	$footerspan = "span6";
}
else
{
	$footerspan = "span12";
}


?>
	
