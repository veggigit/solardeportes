<?php
/*
 * @package		mod_easyblogmostpopularpost
 * @copyright	Copyright (C) 2010 Stack Ideas Private Limited. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 *
 * EasyBlog is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication();
$document = &JFactory::getDocument();
$document->addScript('templates/' . $app->getTemplate(). '/js/jquery.flexslider-min.js');
$document->addStyleSheet('templates/' . $app->getTemplate(). '/css/flexslider.css');

// generate random number 
$randomid = rand(100, 999); 

$db = JFactory::getDBO();

?>

<?php 
foreach($last_prod as $key=>$value){
$last_prod[$key]->buy_link = SEFLink('index.php?option=com_jshopping&controller=cart&task=add&category_id='.$value->category_id.'&product_id='.$value->product_id, 1);}
?>
<div id="mod_jshopping_toprating_products <?php echo $randomid; ?>" class="iceslider mod_jshopping_bestseller_products<?php echo $params->get( 'moduleclass_sfx' ) ?>">
   <div class="iceslider">
    
        <ul class="slides">
            <?php 
			foreach($list as $curr)		
			{ 
				$query = "SELECT count(*) as TOTAL FROM `#__jshopping_products_attr` WHERE product_id = '".$curr->product_id."' ORDER BY product_attr_id";
				$db->setQuery($query);
				$attr_total = $db->loadResult();
			?>
            <li>
            
                <div class="item_container">
                        
                        <?php if ($show_image) { ?>
                        <div class="item_image">
                        
                        <a href="<?php print $curr->product_link?>"><img src = "<?php print $jshopConfig->image_product_live_path?>/<?php if ($curr->product_thumb_image) print $curr->product_thumb_image; else print $noimage?>" alt="" /></a>
                        
                        </div>
                        <?php } ?>
                        
                        <div class="item_name">
                        <a href="<?php print $curr->product_link?>"><?php print $curr->name?></a>
                        </div>
                        
                        <?php if ($curr->_display_price){?>
                        <div class="item_price">
                        <?php print formatprice($curr->product_price);?>
                        </div>
                        <?php }?>   
                        
                        <div class="item_container_effect">
                        <?php if($attr_total > 0){?>
							<div class="item_container_link">
							<div class="buttons">
							<a href="<?php print $curr->product_link?>" class="button"><?php echo JText::_('CHOSE_OPTIONS') ?> </a> 
						</div>  
                        
						</div>
						<?php }else{ ?>
                        <div class="item_container_link">
							<div class="buttons">
							<a href="<?php print $curr->buy_link?>" class="button button_cart"><?php echo JText::_('BUY_BUTTON') ?> </a> 

							<a class="button_detail" href="<?php print $curr->product_link?>"><?php print _JSHOP_DETAIL?></a>    
							</div>  
						</div>
						<?php } ?>
                        </div>

                </div>
                
            </li>
            <?php } ?>
        </ul>
    </div>
</div>

<script type="text/javascript">
// Can also be used with $(document).ready()
jQuery(window).load(function() {
  jQuery('.iceslider').flexslider({
    animation: "slide",
    animationLoop: true,
	itemWidth:292.5,
    itemMargin:0,
    minItems:0,
    maxItems:0
  });
});
</script>