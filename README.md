category-color-extended
=======================

Extending WordPress Plugin "Category Color" (https://wordpress.org/plugins/category-color/) with an additional color field.

Easily set custom colors per Post Category and use the colors in your Wordpress templates to spice up your theme.

## Description

Easily set custom colors per Post Category and use the colors in your Wordpress templates to spice up your theme. You can use it to color your Category names, your Post titles, background, lines, etc. in your Theme. Colors are always easily adjustable through your Category Edit screen.

This Form povides a second color field to be able to add background and accent colors to Categories.

## Installation

Please refer to the official documentation: https://codex.wordpress.org/Managing_Plugins

## How to us these colors

```php
<?php
    if(function_exists('category_color_extended')){
        $rl_category_color_fg   = category_color_extended( $category_id )['rl_category_color_fg'];
        $rl_category_color_bg   = category_color_extended( $category_id )['rl_category_color_bg'];
        $rl_category_color_text = category_color_extended( $category_id )['rl_category_color_text'];
    }
?>
```

Now you can use the colors in your template in an inline stylesheet.
