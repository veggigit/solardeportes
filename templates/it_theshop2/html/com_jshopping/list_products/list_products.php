<div class="jshop list_product">
<?php foreach ($this->rows as $k=>$product){?>
<?php if ($k%$this->count_product_to_row==0) ;?>
    <div style="width:<?php print 100/$this->count_product_to_row?>%" class="block_product">
        <?php include(dirname(__FILE__)."/".$product->template_block_product);?>
    </div>
    <?php if ($k%$this->count_product_to_row==$this->count_product_to_row-1){?>
    
        <div colspan="<?php print $this->count_product_to_row?>"><div class="product_list_hr"></div></div>               
    <?php }?>
<?php }?>
<?php if ($k%$this->count_product_to_row!=$this->count_product_to_row-1);?>
</div>