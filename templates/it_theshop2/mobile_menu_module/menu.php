<?php
?>
<!-- import icons-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">

<!-- menu -->
<ul class="cd-accordion-menu">
    <li class="has-children">
        <input type="checkbox" id="gr-1">
        <label class="padre" for="gr-1"><i class="zmdi zmdi-chevron-right"></i> Padre</label>

        <ul>
            <li class="children"><a href="#0"><i class="zmdi zmdi-trending-flat"></i> Hijo</a></li>
        </ul>
    </li>

    <li class="has-children">
        <input type="checkbox" id="gr-2">
        <label class="padre" for="gr-2"><i class="zmdi zmdi-chevron-right"></i> Padre</label>

        <ul>
            <li class="children"><a href="#0"><i class="zmdi zmdi-trending-flat"></i> Hijo</a></li>
        </ul>
    </li>
    <li class="has-children"><a href="#0">Image</a></li>
</ul>
<!-- end menu-->

<style>
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
        padding: 18px 18px 18px 64px;
        /* background: #4d5158;
            box-shadow: inset 0 -1px #555960; */
        color: #ffffff;
        font-size: 1.6rem;
    }

    .cd-accordion-menu ul {
        /* by default hide all sub menus */
        display: none;
    }

    .cd-accordion-menu input[type=checkbox]:checked+label+ul,
    .cd-accordion-menu input[type=checkbox]:checked+label:nth-of-type(n)+ul {
        /* use label:nth-of-type(n) to fix a bug on safari (<= 8.0.8) with multiple adjacent-sibling selectors*/
        /* show children when item is checked */
        display: block;
    }

    /* new */
    .cd-accordion-menu {
        margin: 0;
    }

    .cd-accordion-menu ul,
    li,
    label {
        margin: 0;
    }

    .cd-accordion-menu .has-children {
        background: #4d5158;
        box-shadow: inset 0 -1px #555960;
    }

    .cd-accordion-menu .children {
        background: #2e2f31;
        box-shadow: inset 0 -1px #404246;
    }

    .cd-accordion-menu .children  a{
        padding-left: 64px !important;
    }
</style>

<!-- scripts -->
<script>

(function(){
    const padre = document.querySelector('.padre')
    
    padre.addEventListener("click", function(){
        padre.childNodes[0].classList.add('active')
    }); 

})();

</script>