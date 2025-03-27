# WooCommerce Category Reordering Shortcode

## Overview
This plugin allows you to reorder WooCommerce product categories using a custom WordPress shortcode. The shortcode dynamically generates a hierarchical category menu with parent-child relationships, enabling a structured and organized display.

## Features
- Display WooCommerce product categories in a hierarchical format.
- Supports parent and child categories.
- Uses a shortcode for easy integration into pages or widgets.
- Expandable/collapsible subcategories using JavaScript.

## Installation
1. Copy and paste the provided PHP function into your `functions.php` file.
2. Add the `[reorder_woo_cat]` shortcode to your desired location (page, post, or widget).
3. Include the provided CSS and JavaScript files in your theme for proper styling and functionality.

## Usage

### 1. Add the Shortcode
Paste the following code into your `functions.php` file:

```php
add_shortcode("reorder_woo_cat", "reorder_woo_cat");

function reorder_woo_cat() {
    // Define parent category IDs
    $en_cat = array(219, 214, 225, 196, 210, 465, 250, 231, 237, 851);

    $term_html = "<ul id='cat_order'>";
    foreach ($en_cat as $val) {
        if (term_exists($val, 'product_cat')) {
            $parent_term = get_term_by('term_id', $val, 'product_cat');
            $parent_id = $parent_term->term_id;
            $parent_name = $parent_term->name;
            $parent_link = get_term_link($parent_term, 'product_cat');
            $is_parent = $parent_term->parent;

            if ($is_parent == 0) {
                $child_terms = get_terms("product_cat", array(
                    'parent' => $parent_id,
                    'hide_empty' => false
                ));

                if ($child_terms) {
                    $term_html .= "<li class='parent has-child first_parent'><a href='javascript:void(0);'>$parent_name <i class='fas fa-chevron-down' style='float: right; margin-top: 5px;'></i></a><ul>";
                    
                    foreach ($child_terms as $child) {
                        $child_term = get_term_by('term_id', $child->term_id, 'product_cat');
                        $child_name = $child_term->name;
                        $child_link = get_term_link($child_term, 'product_cat');

                        $sub_child_terms = get_terms("product_cat", array(
                            'parent' => $child->term_id,
                            'hide_empty' => false
                        ));

                        if ($sub_child_terms) {
                            $term_html .= "<li class='parent has-child'><a href='$child_link'>$child_name</a><ul>";

                            foreach ($sub_child_terms as $sub_child) {
                                $sub_child_name = $sub_child->name;
                                $sub_child_link = get_term_link($sub_child, 'product_cat');
                                $term_html .= "<li class='child'><a href='$sub_child_link'>$sub_child_name</a></li>";
                            }
                            $term_html .= "</ul></li>";
                        } else {
                            $term_html .= "<li class='child'><a href='$child_link'>$child_name</a></li>";
                        }
                    }
                    $term_html .= "</ul></li>";
                } else {
                    $term_html .= "<li class='parent'><a href='$parent_link'>$parent_name</a></li>";
                }
            }
        }
    }
    $term_html .= "</ul>";
    return $term_html;
}
```

### 2. Enqueue CSS for Styling
Add the following CSS to your theme's style.css file to style the category menu:


```css
#cat_order {
    list-style: none;
    padding: 0;
}

#cat_order li {
    margin: 5px 0;
}

#cat_order .has-child > a {
    font-weight: bold;
    cursor: pointer;
}

#cat_order ul {
    display: none;
    margin-left: 20px;
}

#cat_order .has-child.active > ul {
    display: block;
}
```
### 3. Enqueue JavaScript for Functionality
Add this JavaScript to your theme’s script.js file or enqueue it in functions.php:

```js

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll("#cat_order .has-child > a").forEach(item => {
        item.addEventListener("click", function() {
            let parentLi = this.parentElement;
            parentLi.classList.toggle("active");
        });
    });
});
```

### 4. Add the Shortcode to a Page
To display the category menu, add the shortcode to any page, post, or widget:

```html
[reorder_woo_cat]
```
## Customization
Modify the $en_cat array to include the category IDs you want to display.

Change the CSS styles to match your theme design.

Adjust JavaScript behavior for enhanced user experience.

## Troubleshooting
Categories not displaying? Make sure the category IDs in $en_cat exist in WooCommerce.

JavaScript not working? Ensure the script is properly enqueued and there are no JS errors in the console.

Styles not applied? Verify that your CSS file is correctly loaded.

## License
This plugin is licensed under the MIT License.
