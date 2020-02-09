<?php
/**
 * Plugin Name: Broadstairs Folk Week WP Plugin
 * Plugin URI: https://github.com/danwatford/broadstairs-folk-week-wp-plugin
 * Description: Wordpress customisations required for the Broadstairs Folk Week website.
 * Version: 0.1
 * Author: Watford Consulting Ltd.
 * Author URI: https://www.watfordconsulting.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * {Plugin Name} is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * {Plugin Name} is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with {Plugin Name}. If not, see {License URI}.
 */

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
        'supports' => array('title', 'editor', 'thumbnail'),
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

function link_artist_cpt_to_events()
{
    if (function_exists('tribe_register_linked_post_type')) {
        tribe_register_linked_post_type('artist');
    }
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

function bfw_activate()
{
    bfw_setup_artist_post_taxonomy();
    bfw_setup_artist_post_type();
    flush_rewrite_rules();
}

function bfw_deactivate()
{
    unregister_post_type('artist');
    unregister_taxonomy('artist-category');
    flush_rewrite_rules();
}

add_action('init', 'bfw_setup_artist_post_type');
add_action('init', 'bfw_setup_artist_post_taxonomy', 0);
add_action('init', 'link_artist_cpt_to_events');
add_action('cmb2_admin_init', 'bfw_cmb2_artist_metaboxes');
register_activation_hook(__FILE__, 'bfw_activate');
register_deactivation_hook(__FILE__, 'bfw_deactivate');
