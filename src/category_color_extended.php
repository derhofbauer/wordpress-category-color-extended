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

function category_color_extended_load_textdomain()
{
    load_plugin_textdomain('category-color-extended', false, basename(dirname(__FILE__)).'/i18n/');
}
add_action('plugins_loaded', 'category_color_extended_load_textdomain');

class Category_Colors_Extended
{
    protected $_meta;
    protected $_taxonomies;
    protected $_fields;

    public function __construct($meta)
    {
        if (!is_admin()) {
            return;
        }
        $this->_meta = $meta;
        $this->normalize();

        add_action('admin_init', [$this, 'add'], 100);
        add_action('edit_term', [$this, 'save'], 10, 2);
        add_action('delete_term', [$this, 'delete'], 10, 2);
        add_action('load-edit-tags.php', [$this, 'load_edit_page']);
    }

    /********************************
     * Enqueue scripts and styles
     ********************************/
    public function load_edit_page()
    {
        $screen = get_current_screen();
        if ('edit-tags' != $screen->base
           || empty($_GET['action'])
           || 'edit' != $_GET['action']
           || !in_array($screen->taxonomy, $this->_taxonomies)) {
            return;
        }
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
        add_action('admin_head', [$this, 'output_css']);
        add_action('admin_footer', [$this, 'output_js'], 100);
    }

    /*******************************
     * Enqueue scripts and styles
     *******************************/
    public function admin_enqueue_scripts()
    {
        wp_enqueue_script('jquery');
        $this->check_field_color();
    }

    // Output CSS into header
    public function output_css()
    {
        echo $this->css ? '<style>'.$this->css.'</style>' : '';
    }

    // Output JS into footer
    public function output_js()
    {
        echo $this->js ? '<script>jQuery(function($){'.$this->js.'});</script>' : '';
    }

    /***************
     * COLOR FIELD
     ***************/

    // Check field color
    public function check_field_color()
    {
        if (!$this->has_field('color')) {
            return;
        }
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        $this->js .= '$(".color").wpColorPicker();';
    }

    /*****************
     * META BOX PAGE
     *****************/

    // Add meta fields for taxonomies
    public function add()
    {
        foreach (get_taxonomies() as $tax_name) {
            if (in_array($tax_name, $this->_taxonomies)) {
                add_action($tax_name.'_edit_form', [$this, 'show'], 9, 2);
            }
        }
    }

    // Show meta fields
    public function show($tag, $taxonomy)
    {
        // get meta fields from option table
        $metas = get_option($this->_meta['id']);
        if (empty($metas)) {
            $metas = [];
        }
        if (!is_array($metas)) {
            $metas = (array) $metas;
        }

        // get meta fields for current term
        $metas = isset($metas[$tag->term_id]) ? $metas[$tag->term_id] : [];

        wp_nonce_field(basename(__FILE__), 'taxonomy_meta_nonce');

        echo "<h3>{$this->_meta['title']}</h3><table class='form-table'>";
        foreach ($this->_fields as $field) {
            echo '<tr>';

            $meta = !empty($metas[$field['id']]) ? $metas[$field['id']] : $field['std'];
            $meta = is_array($meta) ? array_map('esc_attr', $meta) : esc_attr($meta);
            call_user_func([$this, 'show_field_'.$field['type']], $field, $meta);

            echo '</tr>';
        }
        echo '</table>';
    }

    /*******************
     * META BOX FIELDS
     *******************/

    public function show_field_begin($field, $meta)
    {
        echo "<th scope='row' valign='top'><label for='{$field['id']}'>{$field['name']}</label></th><td>";
    }

    public function show_field_end($field, $meta)
    {
        echo $field['desc'] ? "<br><span class='description'>{$field['desc']}</span></td>" : '</td>';
    }

    public function show_field_color($field, $meta)
    {
        if (empty($meta)) {
            $meta = '#';
        }
        $this->show_field_begin($field, $meta);
        echo "<input type='text' name='{$field['id']}' id='{$field['id']}' value='$meta' class='color'>";
        $this->show_field_end($field, $meta);
    }

    /*****************
     * META BOX SAVE
     *****************/

    // Save meta fields
    public function save($term_id, $tt_id)
    {
        $metas = get_option($this->_meta['id']);
        if (!is_array($metas)) {
            $metas = (array) $metas;
        }
        $meta = isset($metas[$term_id]) ? $metas[$term_id] : [];
        foreach ($this->_fields as $field) {
            $name = $field['id'];
            $new = isset($_POST[$name]) ? $_POST[$name] : ($field['multiple'] ? [] : '');
            $new = is_array($new) ? array_map('stripslashes', $new) : stripslashes($new);
            if (empty($new)) {
                unset($meta[$name]);
            } else {
                $meta[$name] = $new;
            }
        }
        $metas[$term_id] = $meta;
        update_option($this->_meta['id'], $metas);
    }

    /******************
    * META BOX DELETE
    *******************/

    public function delete($term_id, $tt_id)
    {
        $metas = get_option($this->_meta['id']);
        if (!is_array($metas)) {
            $metas = (array) $metas;
        }
        unset($metas[$term_id]);
        update_option($this->_meta['id'], $metas);
    }

    /*********************
     * HELPER FUNCTIONS
     *********************/

    public function normalize()
    {
        // Default values for meta box
        $this->_meta = array_merge([
            'taxonomies' => ['category', 'post_tag'],
            ], $this->_meta);

        $this->_taxonomies = $this->_meta['taxonomies'];
        $this->_fields = $this->_meta['fields'];
    }

    // Check if field with $type exists
    public function has_field($type)
    {
        foreach ($this->_fields as $field) {
            if ($type == $field['type']) {
                return true;
            }
        }

        return false;
    }

    public function get_fields($catid)
    {
        $meta = get_option('category_color_extended_meta');
        if (array_key_exists($catid, $meta)) {
            return $meta[$catid];
        } else {
            return '';
        }
    }
}

//Load Taxonomy metaboxes
require_once 'default_fields.php';

// provide global function for fetching categories
function category_color_extended($catid)
{
    return Category_Colors_Extended::get_fields($catid);
}
