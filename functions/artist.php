<?php

function bfw_get_artist_events($post_id = false)
{
    $post_id = Tribe__Events__Main::postIdHelper($post_id);

    if ($post_id) {
        $args = array(
            'meta_query' => array(
                array(
                    'key' => Tribe__Events__Linked_Posts::META_KEY_PREFIX . 'artist',
                    'value' => $post_id,
                ),
            ),
            'eventDisplay' => 'list',
            'posts_per_page' => apply_filters('tribe_ext_events_single_artist_posts_per_page', 100),
        );

        $html = tribe_include_view_list($args);

        return apply_filters('tribe_ext_artist_events', $html);
    }
}

function bfw_get_event_artists() {
    $post_id = Tribe__Events__Main::postIdHelper();
    $linked_posts = tribe_get_linked_posts_by_post_type(get_the_ID(), 'artist');

    return $linked_posts;
}

/**
 * Action fired in the_events_calendar/common/src/Tribe/Repository.php: tribe_repository_{$this->filter_name}_query
 * 
 * Fires after the query has been built and before it's returned.
 *
 * @param WP_Query $query The built query.
 * @param Tribe__Repository $this This repository instance.
 * @param bool $use_query_builder Whether a query builder was used to build this query or not.
 * @param Tribe__Repository__Interface $query_builder The query builder in use, if any.
 */
add_action('tribe_repository_events_query', 'bfw_adjust_events_query_for_artist', 20, 4);
function bfw_adjust_events_query_for_artist($query, $repository, $use_query_builder, $query_builder) {
    if (is_singular('artist')) {
        $query->query_vars['meta_query']['bfw_artist_filter'] = array(
            'key' => Tribe__Events__Linked_Posts::META_KEY_PREFIX . 'artist',
            'value' => get_the_ID(),
        );
    }
}
