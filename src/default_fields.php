<?php

function category_colors_extended()
{
    if (class_exists('Category_Colors_Extended')) {
        $meta_sections = [];

        // Color Meta Box
        $meta_sections[] = [
            'title'      => __('Select Category Color', 'category-color-extended'),
            'taxonomies' => ['category'],
            'id'         => 'category_color_extended_meta',
            'fields'     => [
                [
                    'name' => __('Background Color', 'category-color-extended'),
                    'desc' => __('Color for page background', 'category-color-extended'),
                    'id'   => 'category_color_bg',
                    'type' => 'color',
                    ],
                [
                    'name' => __('Foreground Color', 'category-color-extended'),
                    'desc' => __('Color for page accents', 'category-color-extended'),
                    'id'   => 'category_color_fg',
                    'type' => 'color',
                    ],
                [
                    'name' => __('Text On Accent Color', 'category-color-extended'),
                    'desc' => __('Color for text on accents (e. g. button text)', 'category-color-extended'),
                    'id'   => 'category_color_text',
                    'type' => 'color',
                    ],
                ],
            ];

        foreach ($meta_sections as $meta_section) {
            new Category_Colors_Extended($meta_section);
        }
    }
}

add_action('admin_init', 'category_colors_extended');
