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

if ( ! function_exists('bfw_write_log')) {
    function bfw_write_log ( $log )  {
        if ( is_array( $log ) || is_object( $log ) ) {
            error_log( print_r( $log, true ) );
        } else {
            error_log( $log );
        }
    }
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

register_activation_hook(__FILE__, 'bfw_activate');
register_deactivation_hook(__FILE__, 'bfw_deactivate');

require 'functions/register-artist-cpt.php';
require 'functions/artist.php';
require 'functions/the-event-calendar-config.php';
