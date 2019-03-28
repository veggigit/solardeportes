<div class="jshop">
    <h1><?php print _JSHOP_MY_ORDERS ?></h1>
    
    <?php if (count($this->orders)) {?>
      <?php foreach ($this->orders as $order){?>
      <table class = "jshop" style = "margin-top:20px; width:98%">
          <tr>
            <td>
              <b><?php print _JSHOP_ORDER_NUMBER ?>:</b> <?php print $order->order_number ?>
            </td> 
            <td style = "text-align:right">
              <b><?php print _JSHOP_ORDER_STATUS ?>:</b> <?php print $order->status_name ?>
            </td> 
          </tr>
          <tr>
            <td colspan = "2">
               <table class = "table_order_list">
                 <tr>
                   <td width = "50%">
                     <b><?php print _JSHOP_ORDER_DATE ?>:</b> <?php print formatdate($order->order_date, 0) ?><br />
                     <b><?php print _JSHOP_EMAIL_BILL_TO ?>:</b> <?php print $order->f_name ?> <?php print $order->l_name ?><br />
                     <b><?php print _JSHOP_EMAIL_SHIP_TO ?>:</b> <?php print $order->d_f_name ?> <?php print $order->d_l_name ?><br />
                   </td>
                   <td width = "30%">
                     <b><?php print _JSHOP_PRODUCTS ?>:</b> <?php print $order->count_products ?><br />
                     <b></b> <?php print formatprice($order->order_total, $order->currency_code)?><?php print $order->_ext_price_html?><br />
                   </td>
                   <td width = "20%" style="vertical-align:middle;text-align:right;padding-right:10px;">
                     <a href = "<?php print $order->order_href ?>"><?php print _JSHOP_DETAILS?></a> 
                   </td>
                 </tr>
               </table>
            </td> 
          </tr>
      </table>
      <?php } ?>
    <?php }else{ ?>
      <?php print _JSHOP_NO_ORDERS ?>
    <?php } ?>
</div>