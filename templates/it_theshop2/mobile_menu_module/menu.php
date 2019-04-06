<?php

// importamos helper
include_once $_SERVER['DOCUMENT_ROOT'] . "modules/mod_jshopping_categories/helper.php";

// nuevo objeto
require_once(JPATH_SITE . '/components/com_jshopping/lib/factory.php');
$obj = new jShopCategoriesHelper();
$data = $obj->getCategoriasMenuu();
// var_dump($data);

$cats2 = $data;
$html = "<ul class='cd-accordion-menu'><a href='#' class='nuke-btn'><i class='zmdi zmdi-menu'></i></a>";

foreach ($data as $key => $value) {
    if ($data[$key]->category_parent_id == 0) {
        $html .=
            "<li class='first-level'>
            <a href='" . $data[$key]->category_link . "' class='direct'></a>
            <input type='checkbox' id='" . $data[$key]->category_id . "' >
            <label class='".$data[$key]->category_id."' for='" . $data[$key]->category_id . "'> " . $data[$key]->name . "</label>";

        $html .= "<ul>";
        foreach ($cats2 as $key2 => $value2) {
            if ($data[$key]->category_id == $cats2[$key2]->category_parent_id) {
                $html .= "<li class='second-level'><a href='" . $cats2[$key2]->category_link . "'>" . $cats2[$key2]->name . "</a></li>";
            }
        }
        $html .= "</ul>";
        $html .= "</li>";
    }
}

$html .= "</ul>";

echo $html;
?>
<!-- import icons-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">

<style>
    /* IMPORTANTE */
    /* CLASES PARA UN BUEN FUNCIONAMIENTO. PLZ ADD ESTAS CLASES AL WRAPER DEL MENU Y  AL WRAPER DEL CONTENT */
    .wrap-mobile-menu {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 99;
        background: rgba(0, 0, 0, 0.8);
        width: 100%;
        height: 100%;
        /* esto es cuando está activo */
        overflow-y: scroll;
    }

    .wrap-body-content {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
        width: 100%;
        /* menu activo */
        max-height: 100vh;
        overflow: hidden;
    }

    /* plugin */
    .cd-accordion-menu {
        position: relative;
        width: 315px;
    }

    .cd-accordion-menu a.nuke-btn {
        position: absolute;
        top: 0;
        right: -54px;
        color: white;
        font-size: 2.8rem;
        display: block;
        padding: 1px 8px !important;
        background: #4d5158;
    }

    .cd-accordion-menu ul,
    .cd-accordion-menu li {
        list-style: none;
    }

    .cd-accordion-menu input[type=checkbox] {
        /* hide native checkbox */
        position: absolute;
        opacity: 0;
    }

    .cd-accordion-menu label,
    .cd-accordion-menu a {
        position: relative;
        display: block;
        padding: 18px 18px 18px 18px;
        /* background: #4d5158;
            box-shadow: inset 0 -1px #555960; */
        color: #ffffff;
        font-size: 1rem;
        z-index: 0;
    }

    .cd-accordion-menu ul {
        /* by default hide all sub menus */
        display: none;
    }

    .cd-accordion-menu input[type=checkbox]:checked+label+ul,
    .cd-accordion-menu input[type=checkbox]:checked+label:nth-of-type(n)+ul {
        /* use label:nth-of-type(n) to fix a bug on safari (<= 8.0.8) with multiple adjacent-sibling selectors*/
        /* show second-level when item is checked */
        display: block;
    }

    /* NUEVO */
    .cd-accordion-menu {
        margin: 0;
    }

    .cd-accordion-menu ul,
    li,
    label {
        margin: 0;
    }

    .cd-accordion-menu .first-level {
        background: #4d5158;
        box-shadow: inset 0 -1px #555960;
        position: relative;
    }

    .cd-accordion-menu .first-level .direct {
        background: rgba (white, 0);
        position: absolute;
        left: 0;
        top: 15px;
        width: 45%;
        height: 20px;
        z-index: 2;
        padding: 0;
    }

    .cd-accordion-menu .second-level {
        background: #2e2f31;
        box-shadow: inset 0 -1px #404246;
    }

    .cd-accordion-menu .second-level a {
        padding-left: 64px !important;
    }
</style>

<!-- scripts -->
<script>
(function addIcontoElementWithChild(){
    
    let arr = document.querySelectorAll('.first-level');

   //Si el elemento  elem su first ul tiene li (hijos). Agregasmos class 'has-child' y agregamos icon +
    arr.forEach(function(elem){
        if(elem.querySelector('ul li') != null ) {
            elem.classList.add('has-child');
            elem.innerHTML += "<i class='zmdi zmdi-plus-circle' style='position:absolute; top: 20px; right:20px; color:white; font-size: 1.2em;'></i>";
        }
    });

})();

(function toggleicon(){

    let arr = document.querySelectorAll('.has-child');

    function toggleclass (){
        this.classList.toggle('lolo');
    }

    arr.forEach(function(elem) {
        let classvalue = elem.getElementsByTagName('label')[0].getAttribute('class');
        // console.log(classvalue);
        let label = document.getElementsByClassName(classvalue)[0];
        label.addEventListener('click', toggleclass);
    });

})();
</script>