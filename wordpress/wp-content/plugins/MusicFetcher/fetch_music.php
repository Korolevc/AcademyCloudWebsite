<?php
function spotify_block_callback(){
     global $wpdb;

    // Retrieve the first 3 rows from the "spotify" table
    $results = $wpdb->get_results("SELECT URL FROM {$wpdb->spotify} LIMIT 3");

    // Create an array of Spotify song URLs from the results
    $spotify_songs = array();
    foreach ($results as $row) {
        $spotify_songs[] = $row->song_url;
    }

    // Use the array to display the Spotify block
    echo '<!-- wp:spotify {"urls": ' . json_encode($spotify_songs) . '} -->';
    echo '<!-- /wp:spotify -->';
}

// Add the block to the editor
function register_spotify_block() {
    wp_register_script(
        'spotify-block',
        plugins_url('block.js', __FILE__),
        array('wp-blocks', 'wp-element')
    );
    register_block_type('music-fetcher/spotify', array(
        'editor_script' => 'spotify-block',
        'render_callback' => 'spotify_block_render_callback'
    ));
}
add_action('template_redirect', 'register_spotify_block');

