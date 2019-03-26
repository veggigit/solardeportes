<?php if ($this->allow_review){?>

   <div class="review_header"><h3><?php print _JSHOP_REVIEWS?></h3></div> 
   
		<?php foreach($this->reviews as $curr){?>
        <div class="review_item">
           
            <div class="review_title">
            	<span class="review_user"><?php print $curr->user_name?></span>, 
                <span class='review_time'><?php print formatdate($curr->time);?></span>
             </div>
            
             <?php if ($curr->mark) {?>
             <div class="review_mark"><?php print showMarkStar($curr->mark);?></div>
            <?php } ?> 
            
            <div class="review_text"><?php print nl2br($curr->review)?></div>
            
         </div>
        <?php }?>
    
    <?php if ($this->display_pagination){?>
    <div class="jshop_pagination">
       <div class="pagination"><?php print $this->pagination?></div></td>
    </div>
    
    <?php }?>
    <?php if ($this->allow_review > 0){?>
        <?php JHTML::_('behavior.formvalidation'); ?> 
        
        <form style="margin-top:30px;" action="<?php print SEFLink('index.php?option=com_jshopping&controller=product&task=reviewsave');?>" name="add_review" method="post" class="form-horizontal" onsubmit="return validateReviewForm(this.name)">
        <input type="hidden" name="product_id" value="<?php print $this->product->product_id?>" />
        <input type="hidden" name="back_link" value="<?php print $_SERVER['REQUEST_URI']?>" />
       
       
       <fieldset>
       
       <legend><?php print _JSHOP_ADD_REVIEW_PRODUCT?></legend>
       
       
       	 	<div class="control-group">
                <label class="control-label" for="<?php print _JSHOP_REVIEW_USER_NAME?>"><?php print _JSHOP_REVIEW_USER_NAME?></label>
                
                <div class="controls">
                <input type="text" name="user_name" id="review_user_name" class="inputbox" value="<?php print $this->user->username?>"/>
                </div>
                
            </div>
            
            
            <div class="control-group">
                <label class="control-label" for="<?php print _JSHOP_REVIEW_USER_EMAIL?>"><?php print _JSHOP_REVIEW_USER_EMAIL?></label>
                
                <div class="controls">
               <input type="text" name="user_email" id="review_user_email" class="inputbox" value="<?php print $this->user->email?>" />
                </div>
                
            </div>
            
            
             <div class="control-group">
                <label class="control-label" for="<?php print _JSHOP_REVIEW_REVIEW?>"><?php print _JSHOP_REVIEW_REVIEW?></label>
                
                <div class="controls">
                <textarea name="review" id="review_review" rows="4" cols="40" class="jshop inputbox" style="width:320px;"></textarea>
                </div>
                
            </div>
            
            
             <div class="control-group">
                <label class="control-label" style="padding-top:0" for="<?php print _JSHOP_REVIEW_MARK_PRODUCT?>"><?php print _JSHOP_REVIEW_MARK_PRODUCT?></label>
                
                <div class="controls">
                	 <?php for($i=1; $i<=$this->stars_count*$this->parts_count; $i++){?>
                        <input name="mark" type="radio" class="star {split:<?php print $this->parts_count?>}" value="<?php print $i?>" <?php if ($i==$this->stars_count*$this->parts_count){?>checked="checked"<?php }?>/>
                    <?php } ?>
                
                </div>
                
            </div>
            
           
           
            <div class="control-group">
            	
                <div class="controls">
                  <?php print $this->_tmp_product_review_before_submit;?>
                  <input type="submit" class="button validate" value="<?php print _JSHOP_REVIEW_SUBMIT?>" />
                </div>
          
           </div>
                 
             
          	</fieldset>      
                
                
        </form>
    <?php }else{?>
        <div class="review_text_not_login"><?php print $this->text_review?></div>
    <?php } ?>
<?php }?>