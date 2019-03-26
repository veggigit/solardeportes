<script type="text/javascript">var liveurl = '<?php print JURI::root()?>';</script>
<div class="jshop">
    <h1><?php print _JSHOP_SEARCH ?></h1>
    
    <form class="form-horizontal" action="<?php print $this->action?>" name="form_ad_search" method="post" onsubmit="return validateFormAdvancedSearch('form_ad_search')">
    <input type="hidden" name="setsearchdata" value="1">
   
      <?php print $this->_tmp_ext_search_html_start;?>
      
      <div class="control-group">
        <label class="control-label" for="<?php print _JSHOP_SEARCH_TEXT ?>"><?php print _JSHOP_SEARCH_TEXT ?> </label>
        <div class="controls">
           <input type = "text" name = "search" id = "search" value = "<?php print $this->user->search ?>" class = "inputbox" />
        </div>
      </div>
  	   
       
           <div class="control-group">
           <label class="control-label" for="<?php print _JSHOP_SEARCH_FOR ?>"><?php print _JSHOP_SEARCH_FOR ?> </label>
         
          <div class="controls">
         
           <label class="radio">
           <input type="radio" name="search_type" id="search_type_any" value="any" checked="checked"><?php print _JSHOP_ANY_WORDS?> 
           </label>
           <label class="radio">
           <input type="radio" name="search_type" id="search_type_all" value="any" checked="checked"><?php print _JSHOP_ALL_WORDS?> 
           </label>
           <label class="radio">
           <input type="radio" name="search_type" id="search_type_exact" value="any" checked="checked"><?php print _JSHOP_EXACT_WORDS?>
       	   </label>  
           </div>     
          </div>
          
	      <div class="control-group">
       	   <label class="control-label" for="<?php print _JSHOP_SEARCH_CATEGORIES ?>"><?php print _JSHOP_SEARCH_CATEGORIES ?> </label>
        <div class="controls">
           <?php print $this->list_categories ?><br/>
           <label class="checkbox">
           <input type = "checkbox" name = "include_subcat" id = "include_subcat" value = "1" />
           <label class="include_subcat-label" for="<?php print _JSHOP_SEARCH_INCLUDE_SUBCAT ?>"><?php print _JSHOP_SEARCH_INCLUDE_SUBCAT ?></label>
           </label>
        </div>
        </div>
        
          
         <div class="control-group">
        <label class="control-label" for="<?php print _JSHOP_SEARCH_MANUFACTURERS ?>"><?php print _JSHOP_SEARCH_MANUFACTURERS ?> </label>
        <div class="controls">
            <?php print $this->list_manufacturers ?>
        </div>
      </div>
        
      
      <?php if (getDisplayPriceShop()){?>
      
      <div class="control-group">
        <label class="control-label" for="<?php print _JSHOP_SEARCH_PRICE_FROM ?>"><?php print _JSHOP_SEARCH_PRICE_FROM ?> </label>
        <div class="controls">
           <input type = "text" name = "price_from" id = "price_from" value = "<?php print $this->user->currency_code ?>" class = "inputbox" />
        </div>
      </div>
     
     
      <div class="control-group">
        <label class="control-label" for="<?php print _JSHOP_SEARCH_PRICE_TO ?>"><?php print _JSHOP_SEARCH_PRICE_TO ?> </label>
        <div class="controls">
            <input type = "text" class = "inputbox" name = "price_to" id = "price_to" /> <?php print $this->config->currency_code?>
        </div>
      </div>
      <?php }?>
      
       <div class="control-group">
        <label class="control-label" for="<?php print _JSHOP_SEARCH_DATE_FROM ?>"><?php print _JSHOP_SEARCH_DATE_FROM ?> </label>
        <div class="controls">
            <?php echo JHTML::_('calendar','', 'date_from', 'date_from', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'25', 'maxlength'=>'19'));
			 ?>
        </div>
      </div>
         
         
          <div class="control-group">
        <label class="control-label" for="<?php print _JSHOP_SEARCH_DATE_TO ?>"><?php print _JSHOP_SEARCH_DATE_TO ?> </label>
        <div class="controls">
            <?php echo JHTML::_('calendar','', 'date_to', 'date_to', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'25', 'maxlength'=>'19')); ?>
        </div>
      </div>
        <td colspan="2" id="list_characteristics"><?php print $this->characteristics?></td>
      
      <?php print $this->_tmp_ext_search_html_end;?>
      
   <div style="padding:6px;">
   <div class="control-group"> 
   <div class="controls">
        <input type = "submit" class="button" value = "<?php print _JSHOP_SEARCH ?>" /> 
   </div>    
   </div>
   </div>
    </form>
</div>