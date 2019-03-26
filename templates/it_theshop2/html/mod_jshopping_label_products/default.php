<div class="label_products">
<?php foreach($list as $curr){ ?>
    <div class="block_item">
        <?php if ($show_image) { ?>
        <div class="item_image">
            <a href="<?php print $curr->product_link?>">               
                <img src = "<?php print $jshopConfig->image_product_live_path?>/<?php if ($curr->product_thumb_image) print $curr->product_thumb_image; else print $noimage?>" alt="" />
            </a>
        </div>
        <?php } ?>
        <div class="item_name">
            <a href="<?php print $curr->product_link?>"><?php print $curr->name?></a>
        </div>
        <?php if ($curr->_display_price){?>
       <div class="jshop_price item_price">
           <?php print formatprice($curr->product_price);?>
       </div>
       <?php }?>
    </div>       
<?php } ?>
</div>