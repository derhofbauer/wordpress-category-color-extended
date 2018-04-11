category-color-extended
=======================

![StyleCI](https://styleci.io/repos/70521969/shield)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/bd4bf589c1994e69b0847b4e742a4aa5)](https://www.codacy.com/app/hofbauer.alexander/category-color-extended?utm_source=github.com&utm_medium=referral&utm_content=derhofbauer/category-color-extended&utm_campaign=badger)
[![Build Status](https://travis-ci.org/derhofbauer/category-color-extended.svg?branch=master)](https://travis-ci.org/derhofbauer/category-color-extended)
[![BCH compliance](https://bettercodehub.com/edge/badge/derhofbauer/category-color-extended?branch=master)](https://bettercodehub.com/)
[![Issue Count](https://codeclimate.com/github/derhofbauer/category-color-extended/badges/issue_count.svg)](hhttps://codeclimate.com/github/derhofbauer/category-color-extended/)
[![CodeFactor](https://www.codefactor.io/repository/github/derhofbauer/fesearch/badge)](https://www.codefactor.io/repository/github/derhofbauer/fesearch)

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
        $rl_category_color_fg   = category_color_extended( $category_id )['category_color_fg'];
        $rl_category_color_bg   = category_color_extended( $category_id )['category_color_bg'];
        $rl_category_color_text = category_color_extended( $category_id )['category_color_text'];
    }
?>
```

Now you can use the colors in your template in an inline stylesheet.
