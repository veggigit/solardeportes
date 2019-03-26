<?php $in_row = $this->config->product_count_related_in_row;?>
<?php if (count($this->related_prod)){?>    
   
    <h2 class="related_header"><?php print _JSHOP_RELATED_PRODUCTS?></h2>
    
    <div class="jshop_list_product jshop_related">
    	
		<div class="jshop list_product clearfix">
    
			<?php foreach($this->related_prod as $k=>$product){?>  
    
                <div style="width:<?php print 100/$in_row?>%;" class="block_product">
                    
                    <?php include(dirname(__FILE__)."/../".$this->folder_list_products."/".$product->template_block_product);?>
                </div>
                
            <?php }?>

		</div>

    </div> 
    
<?php }?>