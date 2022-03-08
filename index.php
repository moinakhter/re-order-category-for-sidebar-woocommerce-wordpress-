<?php

// copy and past in your function.php then sue this shortcode [reorder_woo_cat]
//please don't forget to use css and js file in your theme.
add_shortcode("reorder_woo_cat","reorder_woo_cat");
function reorder_woo_cat(){
    if(ICL_LANGUAGE_CODE=='ja'){
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
    }
    else if(ICL_LANGUAGE_CODE=='en'){
        $en_cat = array(
            318,
            308,
            330,
            272,
            300,
            474,
            378,
            342,
            352,
            859

        );
    }
    else if(ICL_LANGUAGE_CODE=='tr'){
        $en_cat = array(
            319,
            309,
            331,
            273,
            301,
            475,
            379,
            343,
            353,
            855

        );
    }

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
