<?php
function rad_labs_category_colors_extended(){
    if (class_exists( 'RadLabs_Category_Colors_Extended' )) {

        $meta_sections = array();

         // Color Meta Box
        $meta_sections[] = array(
            'title'      => 'Select Category Color',
            'taxonomies' => array('category'),
            'id'         => 'rl_category_extended_meta',
            'fields'     => array(
                array(
                    'name' => 'Background Color',
                    'desc' => 'Color for page background',
                    'id'   => 'rl_category_color_bg',
                    'type' => 'color',
                    ),
                array(
                    'name' => 'Foreground Color',
                    'desc' => 'Color for page accents',
                    'id'   => 'rl_category_color_fg',
                    'type' => 'color',
                    ),
                array(
                    'name' => 'Text On Accent Color',
                    'desc' => 'Color for text on accents (e. g. button text)',
                    'id'   => 'rl_category_color_text',
                    'type' => 'color',
                    ),
                ),
            );

        foreach ($meta_sections as $meta_section){
            new RadLabs_Category_Colors_Extended( $meta_section );
        }
    }
}

add_action( 'admin_init', 'rad_labs_category_colors_extended' );

?>