<?php 
$config_fields = $this->config_fields;
include(dirname(__FILE__)."/register.js.php");
?>
<div class="jshop">
<?php echo JHtml::_('form.token');?>
    <?php if (!isset($hideheaderh1)){?>
    <h1><?php print _JSHOP_REGISTRATION;?></h1>
    <?php } ?>
    
    <form class="form-horizontal" action = "<?php print SEFLink('index.php?option=com_jshopping&controller=user&task=registersave',1,0, $this->config->use_ssl)?>" method = "post" name = "loginForm" onsubmit = "return validateRegistrationForm('<?php print $this->urlcheckdata?>', this.name)" autocomplete="off">
    <?php echo $this->_tmpl_register_html_1?>
    <div class = "jshop_register" >
	
      <?php if ($config_fields['title']['display']){?>
     <div class="control-group">
        <label class="control-label" for="<?php print _JSHOP_REG_TITLE ?>"><?php print _JSHOP_REG_TITLE ?> <?php if ($config_fields['title']['require']){?><span>*</span><?php } ?></label>
        <div class="controls">
           <?php print $this->select_titles ?>
        </div>
      </div>     
      <?php } ?>
		
       <?php if ($config_fields['f_name']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_F_NAME ?>"> <?php print _JSHOP_F_NAME ?> <?php if ($config_fields['f_name']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
               <input type = "text" name = "f_name" id = "f_name" value = "<?php print $this->user->f_name ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
		
        <?php if ($config_fields['l_name']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_L_NAME ?>"> <?php print _JSHOP_L_NAME ?> <?php if ($config_fields['l_name']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
               <input type = "text" name = "l_name" id = "l_name" value = "<?php print $this->user->l_name ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
		
		
        <?php if ($config_fields['m_name']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_M_NAME ?>"> <?php print _JSHOP_M_NAME ?> <?php if ($config_fields['m_name']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
               <input type = "text" name = "m_name" id = "m_name" value = "<?php print $this->user->m_name ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
		
		
        <?php if ($config_fields['firma_name']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_FIRMA_NAME ?>"> <?php print _JSHOP_FIRMA_NAME ?> <?php if ($config_fields['firma_name']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
               <input type = "text" name = "firma_name" id = "firma_name" value = "<?php print $this->user->firma_name ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
			
        <?php if ($config_fields['client_type']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_CLIENT_TYPE ?>"> <?php print _JSHOP_CLIENT_TYPE ?> <?php if ($config_fields['client_type']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
               <?php print $this->select_client_types;?>
            </div>
          </div>
        <?php } ?>
		
        <?php if ($config_fields['firma_code']['display']){?>
		<div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_FIRMA_CODE ?>"> <?php print _JSHOP_FIRMA_CODE ?> <?php if ($config_fields['firma_code']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "firma_code" id = "firma_code" value = "<?php print $this->user->firma_code ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
		
        <?php if ($config_fields['tax_number']['display']){?>
		<div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_VAT_NUMBER ?>"> <?php print _JSHOP_VAT_NUMBER ?> <?php if ($config_fields['tax_number']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "tax_number" id = "tax_number" value = "<?php print $this->user->tax_number ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
		
		
        <?php if ($config_fields['email']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_EMAIL ?>"> <?php print _JSHOP_EMAIL ?> <?php if ($config_fields['email']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "email" id = "email" value = "<?php print $this->user->email ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
        <?php if ($config_fields['email2']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_EMAIL2 ?>"> <?php print _JSHOP_EMAIL2 ?> <?php if ($config_fields['email2']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "email2" id = "email2" value = "<?php print $this->user->email2 ?>" class = "inputbox" />
            </div>
          </div>  
        <?php } ?>
		
        <?php if ($config_fields['birthday']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_BIRTHDAY ?>"> <?php print _JSHOP_BIRTHDAY ?> <?php if ($config_fields['birthday']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <?php echo JHTML::_('calendar', '', 'birthday', 'birthday', $this->config->field_birthday_format, array('class'=>'inputbox', 'size'=>'25', 'maxlength'=>'19'));?>
            </div>
          </div>  
        <?php } ?>
	
    <?php echo $this->_tmpl_register_html_2?>
        <?php if ($config_fields['home']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_HOME ?>"> <?php print _JSHOP_HOME ?> <?php if ($config_fields['home']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "home" id = "home" value = "<?php print $this->user->home ?>" class = "inputbox" />
            </div>
          </div>  
        <?php } ?>
		
        <?php if ($config_fields['apartment']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_APARTMENT ?>"> <?php print _JSHOP_APARTMENT ?> <?php if ($config_fields['apartment']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "apartment" id = "apartment" value = "<?php print $this->user->apartment ?>" class = "inputbox" />
            </div>
          </div>  
        <?php } ?>
		
        <?php if ($config_fields['street']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_STREET_NR ?>"> <?php print _JSHOP_STREET_NR ?> <?php if ($config_fields['street']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "street" id = "street" value = "<?php print $this->user->street ?>" class = "inputbox" />
            </div>
          </div>  
        <?php } ?>
		
        <?php if ($config_fields['zip']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_ZIP ?>"> <?php print _JSHOP_ZIP ?> <?php if ($config_fields['zip']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "zip" id = "zip" value = "<?php print $this->user->zip ?>" class = "inputbox" />
            </div>
          </div>  
        <?php } ?>
		
        <?php if ($config_fields['city']['display']){?>
         <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_CITY ?>"> <?php print _JSHOP_CITY ?> <?php if ($config_fields['city']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "city" id = "city" value = "<?php print $this->user->city ?>" class = "inputbox" />
            </div>
          </div> 
        <?php } ?>
		
        <?php if ($config_fields['state']['display']){?>
         <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_STATE ?>"> <?php print _JSHOP_STATE ?> <?php if ($config_fields['state']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "state" id = "state" value = "<?php print $this->user->state ?>" class = "inputbox" />
            </div>
          </div>	
        <?php } ?>
		
        <?php if ($config_fields['country']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_COUNTRY ?>"> <?php print _JSHOP_COUNTRY ?> <?php if ($config_fields['country']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
               <?php print $this->select_countries ?>
            </div>
          </div>	
        <?php } ?>  
		
     
    <?php echo $this->_tmpl_register_html_3?>
        <?php if ($config_fields['phone']['display']){?>
        <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_TELEFON ?>"> <?php print _JSHOP_TELEFON ?> <?php if ($config_fields['phone']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "phone" id = "phone" value = "<?php print $this->user->phone ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
		
        <?php if ($config_fields['mobil_phone']['display']){?>
         <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_MOBIL_PHONE ?>"> <?php print _JSHOP_MOBIL_PHONE ?> <?php if ($config_fields['mobil_phone']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "mobil_phone" id = "mobil_phone" value = "<?php print $this->user->mobil_phone ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
		
        <?php if ($config_fields['fax']['display']){?>
         <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_FAX ?>"> <?php print _JSHOP_FAX ?> <?php if ($config_fields['fax']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "fax" id = "fax" value = "<?php print $this->user->fax ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
        
		
        <?php if ($config_fields['ext_field_1']['display']){?>
		 <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_EXT_FIELD_1 ?>"> <?php print _JSHOP_EXT_FIELD_1 ?> <?php if ($config_fields['ext_field_1']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "ext_field_1" id = "ext_field_1" value = "<?php print $this->user->ext_field_1 ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
		
        <?php if ($config_fields['ext_field_2']['display']){?>
		 <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_EXT_FIELD_2 ?>"> <?php print _JSHOP_EXT_FIELD_2 ?> <?php if ($config_fields['ext_field_2']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "ext_field_2" id = "ext_field_2" value = "<?php print $this->user->ext_field_2 ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
		
        <?php if ($config_fields['ext_field_3']['display']){?>
         <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_EXT_FIELD_3 ?>"> <?php print _JSHOP_EXT_FIELD_3 ?> <?php if ($config_fields['ext_field_3']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "ext_field_3" id = "ext_field_3" value = "<?php print $this->user->ext_field_3 ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
	
    <?php echo $this->_tmpl_register_html_4?>
        
        <?php if ($config_fields['u_name']['display']){?>
         <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_USERNAME ?>"> <?php print _JSHOP_USERNAME ?> <?php if ($config_fields['u_name']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "u_name" id = "u_name" value = "<?php print $this->user->u_name ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
		
        <?php if ($config_fields['password']['display']){?>
         <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_PASSWORD ?>"> <?php print _JSHOP_PASSWORD ?> <?php if ($config_fields['password']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "password" id = "password" value = "<?php print $this->user->password ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
		
        <?php if ($config_fields['password_2']['display']){?>
          <div class="control-group">
            <label class="control-label" for=" <?php print _JSHOP_PASSWORD_2 ?>"> <?php print _JSHOP_PASSWORD_2 ?> <?php if ($config_fields['password_2']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "password_2" id = "password_2" value = "<?php print $this->user->password_2 ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>
		
        <?php if ($config_fields['privacy_statement']['display']){?>
         <div class="control-group">
		 <a class="privacy_statement" href="#" onclick="window.open('<?php print SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=privacy_statement&tmpl=component', 1);?>','window','width=800, height=600, scrollbars=yes, status=no, toolbar=no, menubar=no, resizable=yes, location=no');return false;">
            <label class="control-label" for=" <?php print _JSHOP_PRIVACY_STATEMENT ?>"> <?php print _JSHOP_PRIVACY_STATEMENT ?> <?php if ($config_fields['privacy_statement']['require']){?><span>*</span><?php } ?></label>
            <div class="controls">
              <input type = "text" name = "privacy_statement" id = "privacy_statement" value = "<?php print $this->user->privacy_statement ?>" class = "inputbox" />
            </div>
          </div>
        <?php } ?>   
    <?php echo $this->_tmpl_register_html_5?>
	
    <div class="control-group">
       
		<div class="controls">
         <?php echo $this->_tmpl_address_html_8?>	
     
        <?php echo $this->_tmpl_address_html_9?>
         * <?php print _JSHOP_REQUIRED?>  
    	</div>
        
	</div>
    
    
    
    </div>
    
     <div class="control-group">
     
 <input type = "hidden" name = "<?php print $this->validate ?>" value="1" />
	  <?php echo JHtml::_('form.token');?>
  <div class="controls">  <input type = "submit" value = "<?php print _JSHOP_SEND_REGISTRATION ?>" class = "button" /></div>
    
       </div>
       
  </form>
</div>