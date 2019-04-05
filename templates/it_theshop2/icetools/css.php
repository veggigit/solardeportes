<?php
//  @copyright	Copyright (C) 2012 IceTheme. All Rights Reserved
//  @license	Copyrighted Commercial Software 
//  @author     IceTheme (icetheme.com)

// No direct access.
defined('_JEXEC') or die;


//////////////////////////////////////  CSS  //////////////////////////////////////

// Twitter bootstrap
$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/bootstrap/css/bootstrap.min.css');

$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/css_menu/component.css');
$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/css_menu/icons.css');
$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/css_menu/normalize.css');
$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/css_menu/otros.css');
if ($this->params->get('responsive_template')) {
	$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/bootstrap/css/bootstrap-responsive.min.css');
} 

// CSS by IceTheme for this Tempalte
$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/css/joomla.css');
$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/css/modules.css');
$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/css/general.css');
$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/css/pages.css');
$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/css/joomshopping.css');


if ($this->params->get('responsive_template')) { 
$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/css/responsive.css');
$doc->addStyleSheet($this->baseurl. '/templates/' .$this->template. '/css/joomshopping_responsive.css');
}

?>
<style type="text/css" media="screen">

<?php if($this->params->get('homepage_content')) {
$menu = $app->getMenu();
$lang = JFactory::getLanguage();
if ($menu->getActive() == $menu->getDefault($lang->getTag())) {  ?>
#columns { display:none;}
<?php }} ?>

<?php if (!$this->countModules('sidebar')) { ?>
#content #content_inner {width:100%; border-radius:10px}
#content #content_inner #middlecol {float:none;}
<?php } ?>

<?php if ($this->countModules('slider')) { ?>	
@media (max-width: 1200px) {	
	#promo .container {
		width:865px}	
}

@media (max-width: 979px) {	
	#promo .container {
		width: 570px;}
		.iceslider .flex-control-nav { height:20px; overflow:hidden}
		.iceslider .flex-control-nav li:last-child a,
		.iceslider .flex-control-nav li:first-child a{
			border-radius:0;} 	
}

@media (max-width: 640px) {	
	#promo .container {
		width: 265px;}	
}

<?php } ?>


/* IE10-only styles go here */  
.ie10 ul#ice-switcher {
	padding-right:20px;}  
	.ie10 ul#ice-switcher:hover {
		padding-right:35px}


/* Custom CSS code throught paramters */
<?php echo $this->params->get('custom_css_code'); ?>
</style>

<!-- Template Styles  -->
<?php  if ($this->params->get('enable_template_style') !=1) { ?>
<link id="stylesheet" rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/styles/<?php echo $templatestyle; ?>.css" />
<?php } ?>

<!-- Google Fonts -->
<link href='https://fonts.googleapis.com/css?family=Coming+Soon' rel='stylesheet' type='text/css'>


<?php  if ($this->params->get('responsive_template')) { ?>
<!-- Template Styles -->
<link id="stylesheet" rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/styles/<?php echo $templatestyle; ?>_responsive.css" />

<?php } ?>


<!--[if lte IE 8]>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie8.css" />
<![endif]-->

<!--[if lt IE 9]>
    <script src="<?php echo $this->baseurl ?>/media/jui/js/html5.js"></script>
<![endif]-->


<!--[if !IE]><!--><script>  
if(Function('/*@cc_on return document.documentMode===10@*/')()){
    document.documentElement.className+=' ie10';
}
</script><!--<![endif]-->  

