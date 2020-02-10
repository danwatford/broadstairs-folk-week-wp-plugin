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
