<?php

/**
 * Remove the Organizers post type from Events.
 *
 * @link https://theeventscalendar.com/knowledgebase/linked-post-types/
 * @link https://gist.github.com/a521d02facbc64ce3891c9341384cc07
 */
function bfw_tribe_remove_organizers_from_events($default_types)
{
    if (
        !is_array($default_types)
        || empty($default_types)
        || empty(Tribe__Events__Main::ORGANIZER_POST_TYPE)
    ) {
        return $default_types;
    }

    if (($key = array_search(Tribe__Events__Main::ORGANIZER_POST_TYPE, $default_types)) !== false) {
        unset($default_types[$key]);
    }

    return $default_types;
}

/**
 * Register the Artist custom post type with The Events Calendar for linking to Events.
 */
function bfw_link_artist_cpt_to_events()
{
    if (function_exists('tribe_register_linked_post_type')) {
        tribe_register_linked_post_type('artist');
    }
}

/**
 * Override the all events link to refer to the day-by-day events page.
 */
function bfw_override_all_events_link($all_events_link) {
    return "/whats-on/day-by-day/";
}

add_filter('tribe_events_register_default_linked_post_types', 'bfw_tribe_remove_organizers_from_events');
add_action('init', 'bfw_link_artist_cpt_to_events', 20);
add_filter('tribe_get_events_link', 'bfw_override_all_events_link');