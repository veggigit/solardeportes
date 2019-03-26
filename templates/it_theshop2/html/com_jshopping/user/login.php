<div class="jshop">    
    <h1><?php print _JSHOP_LOGIN ?></h1>
    
    <?php if ($this->config->shop_user_guest && $this->show_pay_without_reg) {?>
      <span class="text_pay_without_reg"><?php print _JSHOP_ORDER_WITHOUT_REGISTER_CLICK?> <a href="<?php print SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2',1,0, $this->config->use_ssl);?>"><?php print _JSHOP_HERE?></a></span>
    <?php } ?>
	
	
              <form method = "post"  class="form-horizontal" action="<?php print SEFLink('index.php?option=com_jshopping&controller=user&task=loginsave', 1,0, $this->config->use_ssl)?>" name = "jlogin">
			  <fieldset>
				<legend>
				<?php print _JSHOP_HAVE_ACCOUNT ?>
				</legend>
			  
					 <div class="control-group">
						<label class="control-label" for="<?php print _JSHOP_USERNAME ?>"><?php print _JSHOP_USERNAME ?>  </label>
						<div class="controls">
						<input type = "text" name = "username" id = "username" value = "<?php print $this->user->username ?>" class = "inputbox" />
						</div>
						</div>
                    
					 <div class="control-group">
						<label class="control-label" for="<?php print _JSHOP_PASSWORT ?>"><?php print _JSHOP_PASSWORT ?>  </label>
						<div class="controls">
						<input type = "password" name = "passwd" id = "password" value = "<?php print $this->user->password ?>" class = "inputbox" />
						</div>
						</div>
						
					 <div class="control-group">
					 <div class="controls">
					  <label for = "remember_me" class="checkbox">
						<input type = "checkbox" name = "remember" id = "remember_me" value = "yes" /> <?php print _JSHOP_REMEMBER_ME ?>
					  </label><br />
					   <input type="submit" class="button" value="<?php print _JSHOP_LOGIN ?>" />
					</div>
				   </div>
				   
			</fieldset>
			
			
                <input type = "hidden" name = "return" value = "<?php print $this->return ?>" />
                <?php echo JHtml::_('form.token');?>
              </form> 
			  
			<fieldset>
			<legend>
           <?php print _JSHOP_HAVE_NOT_ACCOUNT ?>
			</legend>
        
            <?php if (!$this->config->show_registerform_in_logintemplate){?>
			
					  <input type="button" class="button" value="<?php print _JSHOP_REGISTRATION ?>" onclick="location.href='<?php print $this->href_register ?>';" />
					
            <?php }else{?>
                <?php $hideheaderh1 = 1; include(dirname(__FILE__)."/register.php"); ?>
            <?php }?>

</div>    