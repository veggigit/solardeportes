<div class="jshop">
    <h1><?php print $this->category->name?></h1>
    <?php print $this->category->description?>

    <div class="container-sub-categorias">
        <?php if (count($this->categories)){ ?>

            <?php foreach($this->categories as $k=>$category){?>
            <div class="col_jshop_categ">
                <div class="item">
                    <div class="image">
                        <a href="<?php print $category->category_link;?>">
                            <img class="jshop_img"
                                src="<?php print $this->image_category_path;?>/<?php if ($category->category_image) print $category->category_image; else print $this->noimage;?>"
                                alt="<?php print htmlspecialchars($category->name)?>"
                                title="<?php print htmlspecialchars($category->name)?>" />
                        </a>
                    </div>
                    <h3>
                        <a class="product_link"
                            href="<?php print $category->category_link?>"><?php print $category->name?>
                        </a>
                    </h3>
                    <p class="category_short_description">
                        <?php
                            $puntos = '';
                            if (strlen($category->short_description) > 48) {
                                $puntos = '...';
                            }
                            print substr($category->short_description, 0, 45).$puntos
                        ?>
                    </p>
                </div>
            </div>
            <?php } ?>
        <?php }?>
    </div>

    <?php include(dirname(__FILE__)."/products.php");?>
</div>

<style>
    .container-sub-categorias {
        width: 100%;
        max-width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .container-sub-categorias .col_jshop_categ {
        width: 25%;
    }

    .container-sub-categorias .col_jshop_categ .item {
        padding: 15px 10px;
        text-align: center;
        overflow: hidden;
        height: auto;
    }

    .container-sub-categorias .col_jshop_categ .item h3 {
        line-height: 1 !important;
    }

    .container-sub-categorias .col_jshop_categ .item img {
        width: 70%;
        height: 100px;
        object-fit: cover;
        object-position: center;
    }

    @media (max-width: 979px) {
        .container-sub-categorias .col_jshop_categ {
            width: 50%;
        }

        .container-sub-categorias .col_jshop_categ .item {
            max-height: 15em;
        }

        .container-sub-categorias .col_jshop_categ .item h3 {
            font-size: 1.1rem !important;
        }
    }
</style>
