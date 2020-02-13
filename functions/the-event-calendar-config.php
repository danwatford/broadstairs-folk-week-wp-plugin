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

add_filter('tribe_events_register_default_linked_post_types', 'bfw_tribe_remove_organizers_from_events');