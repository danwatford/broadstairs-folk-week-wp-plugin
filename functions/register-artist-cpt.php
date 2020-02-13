<?php

function bfw_setup_artist_post_type()
{
    $labels = array(
        'name' => _x('Artist', 'post type general name'),
        'singular_name' => _x('Artist', 'post type singular name'),
        'singular_name_lowercase' => esc_html_x('artist', 'post type singular name'),
        'add_new' => _x('Add New Artist', 'Artist'),
        'add_new_item' => __('Add New Artist'),
        'edit_item' => __('Edit Artist'),
        'new_item' => __('New Artist'),
        'all_items' => __('All Artists'),
        'view_item' => __('View Artists'),
        'search_items' => __('Search Artists'),
        'not_found' => __('No Artists found'),
        'not_found_in_trash' => __('No Artists found in the Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Artists'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'rewrite' => array("slug" => "artist"),
        'menu_position' => 7,
        'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'has_archive' => true,
    );
    register_post_type('artist', $args);
}

function bfw_setup_artist_post_taxonomy()
{
    $labels = array(
        'name' => _x('Artist Category', 'category general name'),
        'singular_name' => _x('Artist Category', 'category singular name'),
        'search_items' => __('Search Artist Categories'),
        'all_items' => __('All Artist Categories'),
        'parent_item' => __('Parent Artist Category'),
        'parent_item_colon' => __('Parent Artist Category:'),
        'edit_item' => __('Edit Artist Category'),
        'update_item' => __('Update Artist Category'),
        'add_new_item' => __('Add New Artist Category'),
        'new_item_name' => __('New Artist Category'),
        'menu_name' => __('Artist Category'),
    );

    register_taxonomy('artist-category', array('artist'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'artist-category'),
    ));
}

function bfw_cmb2_artist_metaboxes()
{

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_artist_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box(array(
        'id' => 'artist_metabox',
        'title' => __('Artist options', 'cmb2'),
        'object_types' => array('artist',),
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true,
    ));

    $cmb->add_field(array(
        'name' => 'Twitter URL',
        'id' => $prefix . 'twitter',
        'type' => 'text_url'
    ));

    $cmb->add_field(array(
        'name' => 'Instagram URL',
        'id' => $prefix . 'instagram',
        'type' => 'text_url'
    ));

    $cmb->add_field(array(
        'name' => 'Facebook URL',
        'id' => $prefix . 'facebook',
        'type' => 'text_url'
    ));

    $cmb->add_field(array(
        'name' => 'Website URL',
        'id' => $prefix . 'website',
        'type' => 'text_url'
    ));
}

add_action('init', 'bfw_setup_artist_post_type');
add_action('init', 'bfw_setup_artist_post_taxonomy', 0);
add_action('cmb2_admin_init', 'bfw_cmb2_artist_metaboxes');
