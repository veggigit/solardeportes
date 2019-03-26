<div class="jshop">
    <h1><?php print _JSHOP_MY_ORDERS ?></h1>
    
    <?php if (count($this->orders)) {?>
      
	  <?php foreach ($this->orders as $order){?>
      <ul class="order_list">
         
         
          <li>    <b><?php print _JSHOP_ORDER_NUMBER ?>:</b> <?php print $order->order_number ?></li>
           
           
           
             <li>  <b><?php print _JSHOP_ORDER_STATUS ?>:</b> <?php print $order->status_name ?></li>
            
            
                
          <li><b><?php print _JSHOP_ORDER_DATE ?>:</b> <?php print formatdate($order->order_date, 0) ?></li>
           <li><b><?php print _JSHOP_EMAIL_BILL_TO ?>:</b> <?php print $order->f_name ?> <?php print $order->l_name ?></li>
           <li><b><?php print _JSHOP_EMAIL_SHIP_TO ?>:</b> <?php print $order->d_f_name ?> <?php print $order->d_l_name ?></li>
           <li><b><?php print _JSHOP_PRODUCTS ?>:</b> <?php print $order->count_products ?></li>
           <li><?php print formatprice($order->order_total, $order->currency_code)?><?php print $order->_ext_price_html?></li>
           
                    
                  
                  
        </ul>          
                   <a class="btn" href = "<?php print $order->order_href ?>"><?php print _JSHOP_DETAILS?></a> 
                  
            <hr />      
                  
      <?php } ?>
    <?php }else{ ?>
     <div class="alert alert-info"><p><?php print _JSHOP_NO_ORDERS ?></p></div>
    <?php } ?>
</div>