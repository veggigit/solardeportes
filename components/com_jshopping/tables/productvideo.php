<?php
/**
* @version      3.9.0 30.07.2012
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2012 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

class jshopProductVideo extends JTable {

    function __construct( &$_db ){
        parent::__construct('#__jshopping_products_videos', 'video_id', $_db);
    }
}
?>