<div class="container-productos">
    <?php foreach ($this->rows as $k=>$product){?>
        <?php if ($k%$this->count_product_to_row==0) ;?>
            <div class="col_block_product">
                <?php include(dirname(__FILE__)."/".$product->template_block_product);?>
            </div>
        <?php if ($k%$this->count_product_to_row==$this->count_product_to_row-1){?>
            <div colspan="<?php print $this->count_product_to_row?>">
                <div class="product_list_hr"></div>
            </div>
        <?php }?>
    <?php }?>
    <?php if ($k%$this->count_product_to_row!=$this->count_product_to_row-1);?>
</div>

<style>
    .container-productos {
        width: 100%;
        max-width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .container-productos .col_block_product {
        width: 25%;
    }

    .container-productos .col_block_product .item {
        padding: 15px 10px;
        text-align: center;
        overflow: hidden;
        position: relative;
        min-height: 330px;
        margin-bottom: 1rem;
    }

    .container-productos .col_block_product .item img {
        width: 100%;
        /* height: 150px; */
        object-fit: cover;
        object-position: top;

    }

    .container-productos .col_block_product .item .name {
        line-height: 1.4;
        margin-bottom: .8rem;
    }

    .container-productos .col_block_product .item .buttons {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
    }

    .container-productos .col_block_product .item .buttons .button.button_cart {
        padding: 0 40px;
    }

    .container-productos .col_block_product .item .button_detail {
        display: none;
    }

    @media (max-width: 979px) {
        .container-productos .col_block_product {
            width: 50%;
        }

        .container-productos .col_block_product .item {
            min-height: 290px;
        }

        .container-productos .col_block_product .item .buttons .button.button_cart {
            padding: 0 30px;
        }
    }
</style>
