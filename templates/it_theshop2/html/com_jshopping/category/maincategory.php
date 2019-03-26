<?php if ($this->params->get('show_page_heading') && $this->params->get('page_heading')) {?>    
<div class="shophead<?php print $this->params->get('pageclass_sfx');?>"><h1><?php print $this->params->get('page_heading')?></h1></div>
<?php }?>


<div class="jshop">
<?php print $this->category->description?>



    <div class="jshop_list_category">
        
        <?php if (count($this->categories)){?>
    
        <?php foreach($this->categories as $k=>$category){?>
            <?php if ($k%$this->count_category_to_row==0) print "<tr>"; ?>
            <div class = "jshop_categ" style="width:<?php print (100/$this->count_category_to_row)?>%">
             
                   <div class="image">
                        <a href = "<?php print $category->category_link;?>"><img class = "jshop_img" src = "<?php print $this->image_category_path;?>/<?php if ($category->category_image) print $category->category_image; else print $this->noimage;?>" alt="<?php print htmlspecialchars($category->name);?>" title="<?php print htmlspecialchars($category->name);?>" /></a>
                   </div>
                     <h3><a class = "product_link" href = "<?php print $category->category_link?>"><?php print $category->name?></a></h3>
                       <p class = "category_short_description"><?php print $category->short_description?></p>
                       
                       <a href="<?php print $category->category_link;?>" class="button"><?php echo JText::_('ICE_BROWSE') ?> » </a>
                       
                   
               </div>

        <?php } ?>
             
    
   		<?php } ?>

	</div>
    
</div>