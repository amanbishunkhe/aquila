<?php

function track_search_queries() {
    if (is_search() && !empty(get_search_query())) {
        $search_query = get_search_query();
        $searches = isset($_COOKIE['recent_searches']) ? json_decode(stripslashes($_COOKIE['recent_searches']), true) : [];
        
        // Add the current search term to the array
        if (!in_array($search_query, $searches)) {
            $searches[] = $search_query;
            
            // Keep only the last 5 search terms
            if (count($searches) > 5) {
                array_shift($searches);
            }
        }
        
        // Store the updated search terms in a cookie
        setcookie('recent_searches', json_encode($searches), time() + 3600 * 24 * 30, COOKIEPATH, COOKIE_DOMAIN);
    }
}
add_action('template_redirect', 'track_search_queries');


//for display of words
if (isset($_COOKIE['recent_searches'])) {
    $recent_searches = json_decode(stripslashes($_COOKIE['recent_searches']), true);
    if (!empty($recent_searches)) {
        echo '<div class="recent-searches">';
        echo '<h4>Recent Searches:</h4>';
        echo '<ul>';
        foreach ($recent_searches as $search) {
            echo '<li>' . esc_html($search) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}