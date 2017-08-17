<?php

function categoryColorsExtended()
{
    if (class_exists('categoryColorsExtended')) {
        $metaSections = [];

        // Color Meta Box
        $metaSections[] = [
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

        foreach ($metaSections as $metaSection) {
            new categoryColorsExtended($metaSection);
        }
    }
}

add_action('admin_init', 'categoryColorsExtended');
