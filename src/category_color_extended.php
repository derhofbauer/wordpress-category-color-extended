<?php
/*
Plugin Name: Category Color Extended
Plugin URI: https://wordpress.org/plugins/category-color-extended/
Description: Easily set a custom color per Post Category and use the colors in your Wordpress templates to spice up your theme. Based upon https://wordpress.org/plugins/category-color/
Version: 1.0
Author: Alexander Hofbauer
Author URI: http://hofbauer.rocks
License: GPL2+

Text Domain: category-color-extended
Domain Path: ./i18n/
*/

function categoryColorExtendedLoadTextdomain() {
    load_plugin_textdomain( 'category-color-extended', FALSE, basename( dirname( __FILE__ ) ) . '/i18n/' );
}
add_action( 'plugins_loaded', 'categoryColorExtendedLoadTextdomain' );

class categoryColorsExtended{
    protected $meta;
    protected $taxonomies;
    protected $fields;

    function __construct( $meta ){
        if ( !is_admin() )
            return;
        $this->meta = $meta;
        $this->normalize();

        add_action( 'admin_init', array( $this, 'add' ), 100 );
        add_action( 'edit_term', array( $this, 'save' ), 10, 2 );
        add_action( 'delete_term', array( $this, 'delete' ), 10, 2 );
        add_action( 'load-edit-tags.php', array( $this, 'loadEditPage' ) );
    }

    /********************************
     * Enqueue scripts and styles
     ********************************/
    function loadEditPage(){
        $screen = get_current_screen();
        if ('edit-tags' != $screen->base
           || empty( get_query_var('action') )
           || 'edit' != get_query_var('action')
           || !in_array( $screen->taxonomy, $this->taxonomies )) {
            return;
        }
        add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
        add_action( 'admin_head', array( $this, 'outputCSS' ) );
        add_action( 'admin_footer', array( $this, 'outputJs' ), 100 );
    }

    /*******************************
     * Enqueue scripts and styles
     *******************************/
    function adminEnqueueScripts(){
        wp_enqueue_script( 'jquery' );
        $this->checkFieldColor();
    }

    // Output CSS into header
    function outputCSS(){
        echo $this->css ? '<style>' . $this->css . '</style>' : '';
    }

    // Output JS into footer
    function outputJs(){
        echo $this->js ? '<script>jQuery(function($){' . $this->js . '});</script>' : '';
    }

    /***************
     * COLOR FIELD
     ***************/

    // Check field color
    function checkFieldColor(){
        if ( !$this->hasField( 'color' ) )
            return;
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        $this->js .= '$(".color").wpColorPicker();';
    }

    /*****************
     * META BOX PAGE
     *****************/

    // Add meta fields for taxonomies
    function add(){
        foreach ( get_taxonomies() as $taxName ) {
            if ( in_array( $taxName, $this->taxonomies ) ) {
                add_action( $taxName . '_edit_form', array( $this, 'show' ), 9, 2 );
            }
        }
    }

    // Show meta fields
    function show( $tag ){
        // get meta fields from option table
        $metas = get_option( $this->meta['id'] );
        if ( empty( $metas ) ) $metas = array();
        if ( !is_array( $metas ) ) $metas = (array) $metas;

        // get meta fields for current term
        $metas = isset( $metas[$tag->termID] ) ? $metas[$tag->termID] : array();

        wp_nonce_field( basename( __FILE__ ), 'taxonomy_meta_nonce' );

        echo "<h3>{$this->meta['title']}</h3><table class='form-table'>";
        foreach ( $this->fields as $field ) {
            echo '<tr>';

            $meta = !empty( $metas[$field['id']] ) ? $metas[$field['id']] : $field['std'];
            $meta = is_array( $meta ) ? array_map( 'esc_attr', $meta ) : esc_attr( $meta );
            call_user_func( array( $this, 'show_field_' . $field['type'] ), $field, $meta );

            echo '</tr>';
        }
        echo '</table>';
    }

    /*******************
     * META BOX FIELDS
     *******************/

    function showFieldBegin( $field ) {
        echo "<th scope='row' valign='top'><label for='{$field['id']}'>{$field['name']}</label></th><td>";
    }

    function showFieldEnd( $field ) {
        echo $field['desc'] ? "<br><span class='description'>{$field['desc']}</span></td>" : '</td>';
    }

    function showFieldColor( $field, $meta ){
        if ( empty( $meta ) ) $meta = '#';
        $this->showFieldBegin( $field, $meta );
        echo "<input type='text' name='{$field['id']}' id='{$field['id']}' value='$meta' class='color'>";
        $this->showFieldEnd( $field, $meta );
    }


    /*****************
     * META BOX SAVE
     *****************/

    // Save meta fields
    function save( $termID ) {
        $metas = get_option( $this->meta['id'] );
        if ( !is_array( $metas ) )
            $metas = (array) $metas;
        $meta = isset( $metas[$termID] ) ? $metas[$termID] : array();
        foreach ( $this->fields as $field ) {
            $name = $field['id'];
            $new = isset( $_POST[$name] ) ? $_POST[$name] : ( $field['multiple'] ? array() : '' );
            $new = is_array( $new ) ? array_map( 'stripslashes', $new ) : stripslashes( $new );
            if ( empty( $new ) ) {
                unset( $meta[$name] );
            } else {
                $meta[$name] = $new;
            }
        }
        $metas[$termID] = $meta;
        update_option( $this->meta['id'], $metas );
    }

    /******************
    * META BOX DELETE
    *******************/

    function delete( $termID ){
        $metas = get_option( $this->meta['id'] );
        if ( !is_array( $metas ) ) $metas = (array) $metas;
        unset( $metas[$termID] );
        update_option( $this->meta['id'], $metas );
    }

    /*********************
     * HELPER FUNCTIONS
     *********************/

    function normalize(){
        // Default values for meta box
        $this->meta = array_merge( array(
            'taxonomies' => array( 'category', 'post_tag' )
            ), $this->meta );

        $this->taxonomies = $this->meta['taxonomies'];
        $this->fields = $this->meta['fields'];

    }

    // Check if field with $type exists
    function hasField( $type ) {
        foreach ( $this->fields as $field ) {
            if ( $type == $field['type'] ) return true;
        }
        return false;
    }

    function getFields( $catid ) {
        $meta = get_option('category_color_extended_meta');
        if (array_key_exists($catid, $meta)) {
            return $meta[$catid];
        }
        return "";
    }
}

//Load Taxonomy metaboxes
require_once('default_fields.php');

// provide global function for fetching categories
function categoryColorExtended($catid){
    return categoryColorsExtended::getFields($catid);
}

?>