# re-order-category-for-sidebar-woocommerce-wordpress-
Reorder category of woocommerce/wordpress by Moin Akhtar


# copy and past in your function.php then sue this shortcode [reorder_woo_cat]
#please don't forget to use css and js file in your theme.
<?php add_shortcode("reorder_woo_cat","reorder_woo_cat");
function reorder_woo_cat(){
    // parent cat ids
        $en_cat = array(
            219,
            214,
            225,
            196,
            210,
            465,
            250,
            231,
            237,
            851

        );
  

     $term_html = "<ul id='cat_order'>";
    foreach ($en_cat as $val) {
        if (term_exists($val, 'product_cat')) {
            $parent_term = get_term_by('term_id', $val, 'product_cat');
            $parent_id = $parent_term->term_id;
            $parent_name = $parent_term->name;
            $is_parent = $parent_term->parent;
            $parent_link = get_term_link($parent_term, 'product_cat');
            if($is_parent == 0){
                $child_terms_ids = get_terms( "product_cat", array(
                    'parent'    => $parent_id,
                    'hide_empty' => false
                ) );
                if($child_terms_ids){
                    $term_html .= "<li class='parent has-child first_parent'><a href='javascript:void(0);'>".$parent_name." <i class='fas fa-chevron-down' style='float: right;margin-top: 5px;'></i></a><ul>";
                    foreach ($child_terms_ids as $child) {
                        $child_term = get_term_by('term_id', $child->term_id, 'product_cat');
                        $child_id = $child->term_id;
                        $child_name = $child->name;
                        $ch_is_parent = $child->parent;
                        $child_link = get_term_link($child_term, 'product_cat');
                        $child_terms_ids2 = get_terms( "product_cat", array(
                            'parent'    => $child_id,
                            'hide_empty' => false
                        ) );
                        if($child_terms_ids2){
                            $term_html .= "<li class='parent has-child'><a href='".$child_link."'>".$child_name." </a><ul>";

                            foreach ($child_terms_ids2 as $child2) {
                                $child_term2 = get_term_by('term_id', $child->term_id, 'product_cat');
                                $child_name2 = $child2->name;
                                $child_link = get_term_link($child_term2, 'product_cat');
                                $term_html .= "<li class='child'><a href='".$child_link."'>".$child_name2."</a></li>";

                            }
                            $term_html .= '</ul></li>';
                        }else{
                            $term_html .= "<li class='child'><a href='".$child_link."'>".$child_name."</a></li>";

                        }

                        if($ch_is_parent == $is_parent){
                            $term_html .= "<li class='parent'><a href='".$parent_link."'>".$parent_name."</a></li>";

                        }

                    }
                    $term_html .= "</ul></li>";
                }else{
                    $term_html .= "<li class='parent'><a href='".$parent_link."'>".$parent_name."</a></li>";
                }

            }
        }

    }
    $term_html .= "</ul>";
    return $term_html;
}

?>




# Copy js in your js file, it will work with jQuery Library.
jQuery(document).ready(function () {
    jQuery(".first_parent > a").click(function () {
        if(jQuery(this).hasClass("active_cat")){
            jQuery(".active_cat").removeClass("active_cat");
            jQuery(this).find("i").removeClass("fa-chevron-up");
            jQuery(this).find("i").addClass("fa-chevron-down");
            jQuery(this).parent().find("ul").hide(400);
        }else{
            jQuery(".first_parent ul").hide(400);
            jQuery(this).parent().find("ul").show(400);
            jQuery(".active_cat i").removeClass("fa-chevron-up");
            jQuery(".active_cat i").addClass("fa-chevron-down");
            jQuery(".active_cat").removeClass("active_cat");
            jQuery(this).addClass("active_cat");
            jQuery(this).find("i").removeClass("fa-chevron-down");
            jQuery(this).find("i").addClass("fa-chevron-up");
        }
    });
});




# Copy css in your css file
#cat_order li a{
    text-decoration: none;
    color: #777777!important;
}
#cat_order > li > a{
    font-weight: 400;
    width: 100% !important;
    padding: 4px;
    display: inline-block;
}

#cat_order > li > a.active_cat{
    border: 2px solid #4dae65;
    font-weight: bold;
    width: 100% !important;
    padding: 4px;
    display: inline-block;
}

#cat_order li.parent.has-child ul li{
    text-indent: 14px;
    padding: 4px;
}

#cat_order li.parent.has-child ul{
    display: none;
}
#cat_order .first_parent{
    margin-bottom: 6px;
}
#cat_order li.parent.has-child ul li.child{
    text-indent: 40px;
}


#cat_order li a:hover{
    text-decoration: none;
    color: #4dae65 !important;
}



