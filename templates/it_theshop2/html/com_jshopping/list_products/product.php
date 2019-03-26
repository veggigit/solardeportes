<?php print $product->_tmp_var_start?>
<?php 
$db = JFactory::getDBO();
$query = "SELECT count(*) as TOTAL FROM `#__jshopping_products_attr` WHERE product_id = '".$product->product_id."' ORDER BY product_attr_id";
$db->setQuery($query);
$attr_total = $db->loadResult(); 
?>
            
<div class="product productitem_<?php print $product->product_id?>">

    <div class="image">
        <?php if ($product->image){?>
        <div class="image_block">
            <?php if ($product->label_id){?>
                <div class="product_label">
                    <?php if ($product->_label_image){?>
                        <img src="<?php print $product->_label_image?>" alt="<?php print htmlspecialchars($product->_label_name)?>" />
                    <?php }else{?>
                        <span class="label_name"><?php print $product->_label_name;?></span>
                    <?php }?>
                </div>
            <?php }?>
            <a href="<?php print $product->product_link?>">
                <img class="jshop_img" src="<?php print $product->image?>" alt="<?php print htmlspecialchars($product->name);?>" />
            </a>
        </div>
        <?php }?>

       
        <?php print $product->_tmp_var_bottom_foto;?>
    </div>
    
        <div class="name">
            <a href="<?php print $product->product_link?>"><?php print $product->name?></a>
            <?php if ($this->config->product_list_show_product_code){?><span class="jshop_code_prod">(<?php print _JSHOP_EAN?>: <span><?php print $product->product_ean;?></span>)</span><?php }?>
        </div>
		 <?php if ($product->product_old_price > 0){?>
            <div class="old_price"><?php if ($this->config->product_list_show_price_description) print _JSHOP_OLD_PRICE.": ";?><span><?php print formatprice($product->product_old_price)?></span></div>
        <?php }?>
        <?php if ($product->product_price_default > 0 && $this->config->product_list_show_price_default){?>
            <div class="default_price"><?php print _JSHOP_DEFAULT_PRICE.": ";?><span><?php print formatprice($product->product_price_default)?></span></div>
        <?php }?>
        <?php if ($product->_display_price){?>
            <div class = "jshop_price">
                <?php if ($this->config->product_list_show_price_description) print _JSHOP_PRICE.": ";?>
                <?php if ($product->show_price_from) print _JSHOP_FROM." ";?>
                <span><?php print formatprice($product->product_price);?></span>
            </div>
        <?php }?>
		
        <div class="description">
            <?php print $product->short_description?>
        </div>
		 <?php if ($this->allow_review){?>
        <table class="review_mark"><tr><td><?php print showMarkStar($product->average_rating);?></td></tr></table>
        <div class="count_commentar">
            <?php print sprintf(_JSHOP_X_COMENTAR, $product->reviews_count);?>
        </div>
        <?php }?>
		
        <?php if ($product->manufacturer->name){?>
            <div class="manufacturer_name"><?php print _JSHOP_MANUFACTURER;?>: <span><?php print $product->manufacturer->name?></span></div>
        <?php }?>
        <?php if ($product->product_quantity <=0 && !$this->config->hide_text_product_not_available){?>
            <div class="not_available"><?php print _JSHOP_PRODUCT_NOT_AVAILABLE;?></div>
        <?php }?>
       
        <?php print $product->_tmp_var_bottom_price;?>
        <?php if ($this->config->show_tax_in_product && $product->tax > 0){?>
            <span class="taxinfo"><?php print productTaxInfo($product->tax);?></span>
        <?php }?>
        <?php if ($this->config->show_plus_shipping_in_product){?>
            <span class="plusshippinginfo"><?php print sprintf(_JSHOP_PLUS_SHIPPING, $this->shippinginfo);?></span>
        <?php }?>
        <?php if ($product->basic_price_info['price_show']){?>
            <div class="base_price"><?php print _JSHOP_BASIC_PRICE?>: <?php if ($product->show_price_from) print _JSHOP_FROM;?> <span><?php print formatprice($product->basic_price_info['basic_price'])?> / <?php print $product->basic_price_info['name'];?></span></div>
        <?php }?>
        <?php if ($this->config->product_list_show_weight && $product->product_weight > 0){?>
            <div class="productweight"><?php print _JSHOP_WEIGHT?>: <span><?php print formatweight($product->product_weight)?></span></div>
        <?php }?>
        <?php if ($product->delivery_time != ''){?>
            <div class="deliverytime"><?php print _JSHOP_DELIVERY_TIME?>: <span><?php print $product->delivery_time?></span></div>
        <?php }?>
        <?php if (is_array($product->extra_field)){?>
            <div class="extra_fields">
            <?php foreach($product->extra_field as $extra_field){?>
                <div><?php print $extra_field['name'];?>: <?php print $extra_field['value']; ?></div>
            <?php }?>
            </div>
        <?php }?>
        <?php if ($product->vendor){?>
            <div class="vendorinfo"><?php print _JSHOP_VENDOR?>: <a href="<?php print $product->vendor->products?>"><?php print $product->vendor->shop_name?></a></div>
        <?php }?>
        <?php if ($this->config->product_list_show_qty_stock){?>
            <div class="qty_in_stock"><?php print _JSHOP_QTY_IN_STOCK?>: <span><?php print sprintQtyInStock($product->qty_in_stock)?></span></div>
        <?php }?>
        <?php print $product->_tmp_var_top_buttons;?>
		
        
        
        
        <div class="buttons">
        
		<?php if($attr_total > 0){?>
        
        <?php if ($product->product_link){?>
		<a href="<?php print $product->product_link?>" class="button"><?php echo JText::_('CHOSE_OPTIONS') ?> </a>     	
      	 <?php }?>
       
       	<?php }?>  
      
       	<?php if($attr_total == 0){?>
        
        <a href="<?php print $product->buy_link?>" class="button button_cart"><?php echo JText::_('BUY_BUTTON') ?> </a> 
        <a class="button_detail" href="<?php print $product->product_link?>"><?php print _JSHOP_DETAIL?></a>    
       
	    <?php }?>  
        
            <?php print $product->_tmp_var_buttons;?>
        </div>
        <?php print $product->_tmp_var_bottom_buttons;?>
   
</div>
<?php print $product->_tmp_var_end?>