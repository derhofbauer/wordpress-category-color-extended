=== Category Color Extended ===
Contributors: zayedbaloch, naeemnur, pixeldesign, derhofbauer
Tags: category colors, meta box, taxonomy tag colors, post, page
Donate link: http://zayed.xyz
Requires at least: 3.2
Tested up to: 4.5
Stable tag: 1.0
License: GPLv2 or later

Easily set a custom color per Post Category and use the colors in your Wordpress templates to spice up your theme.

== Description ==

Easily set a custom color per Post Category and use the colors in your Wordpress templates to spice up your theme. You can use it to color your Category names, your Post titles, background, lines, etc. in your Theme. Colors are always easily adjustable through your Category Edit screen.

== Installation ==

Please refer to the official documentation: https://codex.wordpress.org/Managing_Plugins

== Frequently Asked Questions ==

= How can I add these colors to my template? =

`
<?php
    if(function_exists('category_color_extended')){
        $rl_category_color_fg   = category_color_extended( $category_id )['category_color_fg'];
        $rl_category_color_bg   = category_color_extended( $category_id )['category_color_bg'];
        $rl_category_color_text = category_color_extended( $category_id )['category_color_text'];
    }
?>
`

Now you can use the colors in your template in an inline stylesheet.

= Why can't pick a color right away when creating a Category, but only when editing a Category? =

Both for consistency and efficiency. First of all WordPress want to keep creating Categories sweet and simple with as little effort as possible. Adding Colors can be considered as customizing Categories, thus it would be more logical to show it in the Edit section only.

Second, when writing a Post you can also quick-add a new category. For consistency's sake we'd have to add the Colorpicker there too, which would be too much of a hassle user-wise at least.

== Screenshots ==

1. Category Edit page
2. Category Color Picker

== Changelog ==

= 1.0 =
First release after forking the plugin.
