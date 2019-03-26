<?php if (!empty($this->text)){?>
<div class="alert alert-success">
<?php echo $this->text;?>
</div>
<?php }else{?>
<div class="alert alert-success">
<p><?php print _JSHOP_THANK_YOU_ORDER?></p>
</div>
<?php }?>