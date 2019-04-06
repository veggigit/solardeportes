<?php
class jShopCategoriesHelper
{

    public static function getTreeCats($order, $ordering, $category_id, $categories_id, &$categories, $level = 0)
    {
        if ($category_id) {
            if (isset($categories_id[$level])) {
                $cat = JTable::getInstance('category', 'jshop');
                $cat->load($categories_id[$level]);

                $cats = $cat->getSisterCategories($order, $ordering);
                foreach ($cats as $key => $value) {
                    $value->level = $level;
                    if (in_array($value->category_id, $categories_id)) {
                        $categories[] = $value;
                        // get Children cats 
                        if ($value->category_id == $category_id) {
                            $cat = JTable::getInstance('category', 'jshop');
                            $cat->load($categories_id[$level]);
                            $cat->category_id = $category_id;
                            $childs = $cat->getChildCategories($order, $ordering);
                            foreach ($childs as $key2 => $value2) {
                                $value2->level = $level + 1;
                                $categories[] = $value2;
                            }
                        }
                        jShopCategoriesHelper::getTreeCats($order, $ordering, $category_id, $categories_id, $categories, ++$level);
                        $level--;
                    } else {
                        $categories[] = $value;
                    }
                }
            }
        } else {
            $cat = JTable::getInstance('category', 'jshop');
            $cat->category_parent_id = 0;
            $cats = $cat->getSisterCategories($order, $ordering);
            foreach ($cats as $key => $value) {
                $cats[$key]->level = 0;
            }
            $categories = $cats;
        }
    }

    public static function getCatsArray($order, $ordering, $category_id, $categories_id = array())
    {
        $res_arr = array();
        jShopCategoriesHelper::getTreeCats($order, $ordering, $category_id, $categories_id, $res_arr, 0);
        return $res_arr;
    }

    /* nuevo */
    public static function getCategoriasMenuu(){
        require_once (JPATH_SITE.'/components/com_jshopping/lib/factory.php');

        $cat = JTable::getInstance('category', 'jshop');
        $cats = $cat->getCategoriasMenu();
        // $cats2 = $cats;
        // $html = "<ul>";

        // foreach ($cats as $key => $value) {
        //     if ($cats[$key]->category_parent_id == 0) {
        //         $html .= "<li>".$cats[$key]->name."</li>";
        //         $html .= "<ul>";
        //         foreach ($cats2 as $key2 => $value2){   
        //             if ($cats[$key]->category_id == $cats2[$key2]->category_parent_id) {
        //                 $html .= "<li>".$cats2[$key2]->name."</li>";
        //             }
        //         }
        //         $html .= "</ul>";
        //     }
        // }

        // $html .= "</ul>";
        return $cats;
    }
    /* nuevo */
}
?>
