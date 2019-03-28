<?php
/**
* @version      2.8.0 10.02.2011
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

class jshopOrderItem extends JTable {

    var $order_item_id = null;
    var $order_id = null;
    var $product_id = null;
    var $product_ean = null;
    var $product_name = null;
    var $product_quantity = null;
    var $product_item_price = null;
    var $product_tax = null;
    var $product_attributes = null;
    var $files = null;
    var $weight = null;
    var $thumb_image = null;
    var $vendor_id = null;

    function __construct( &$_db ){
        parent::__construct( '#__jshopping_order_item', 'order_item_id', $_db );
    }
}
?>