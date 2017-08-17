<?php
function categoryColorsExtended(){
    if (class_exists( 'categoryColorsExtended' )) {

        $metaSections = array();

         // Color Meta Box
        $metaSections[] = array(
            'title'      => __('Select Category Color', 'category-color-extended'),
            'taxonomies' => array('category'),
            'id'         => 'category_color_extended_meta',
            'fields'     => array(
                array(
                    'name' => __('Background Color', 'category-color-extended'),
                    'desc' => __('Color for page background', 'category-color-extended'),
                    'id'   => 'category_color_bg',
                    'type' => 'color',
                    ),
                array(
                    'name' => __('Foreground Color', 'category-color-extended'),
                    'desc' => __('Color for page accents', 'category-color-extended'),
                    'id'   => 'category_color_fg',
                    'type' => 'color',
                    ),
                array(
                    'name' => __('Text On Accent Color', 'category-color-extended'),
                    'desc' => __('Color for text on accents (e. g. button text)', 'category-color-extended'),
                    'id'   => 'category_color_text',
                    'type' => 'color',
                    ),
                ),
            );

        foreach ($metaSections as $metaSection){
            new categoryColorsExtended( $metaSection );
        }
    }
}

add_action( 'admin_init', 'categoryColorsExtended' );

?>