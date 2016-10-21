<?php
function category_colors_extended(){
    if (class_exists( 'Category_Colors_Extended' )) {

        $meta_sections = array();

         // Color Meta Box
        $meta_sections[] = array(
            'title'      => 'Select Category Color',
            'taxonomies' => array('category'),
            'id'         => 'category_color_extended_meta',
            'fields'     => array(
                array(
                    'name' => 'Background Color',
                    'desc' => 'Color for page background',
                    'id'   => 'category_color_bg',
                    'type' => 'color',
                    ),
                array(
                    'name' => 'Foreground Color',
                    'desc' => 'Color for page accents',
                    'id'   => 'category_color_fg',
                    'type' => 'color',
                    ),
                array(
                    'name' => 'Text On Accent Color',
                    'desc' => 'Color for text on accents (e. g. button text)',
                    'id'   => 'category_color_text',
                    'type' => 'color',
                    ),
                ),
            );

        foreach ($meta_sections as $meta_section){
            new Category_Colors_Extended( $meta_section );
        }
    }
}

add_action( 'admin_init', 'category_colors_extended' );

?>