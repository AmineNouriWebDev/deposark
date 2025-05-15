<?php
function graphbit_excerpt()
{
    $graphbit_redux_demo = get_option('redux_demo');
    if (isset($graphbit_redux_demo['blog_excerpt'])) {
        $limit = $graphbit_redux_demo['blog_excerpt'];
    } else {
        $limit = 80;
    }
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt) . '...';
    } else {
        $excerpt = implode(" ", $excerpt);
    }
    $excerpt = preg_replace('`[[^]]*]`', '', $excerpt);
    return $excerpt;
}

//pagination
function graphbit_pagination($prev = 'Prev', $next = 'Next', $pages = '')
{
    global $paged; // current page
    if (empty($paged)) $paged = 1;
    global $wp_query;
    $pages = $wp_query->max_num_pages;
    if (!$pages) {
        $pages = 1;
    }
    if ($pages != 1) {
        echo '<ul class="pagination">';
        if ($paged >= 1) echo '<li><a href="' . get_pagenum_link($paged - 1) . '" >Prev</a></li>';
        for ($page = 1; $page <= $pages; $page++) {
            echo $page == $paged ? '<li class="active"><a href="#">' . $page . '</a></li>' : '<li><a class="btn btn-default" href="' . get_pagenum_link($page) . '">' . $page . '</a></li>';
        }
        if ($paged <= $pages) echo '<li><a href="' . get_pagenum_link($paged + 1) . '" >Next</a></li>';
        echo "</ul>\n";
    }
}
// affichage des tableux dans single.php
add_filter('tiny_mce_before_init', function ($init) {
    $init['content_style'] =
        'table { width: 100% !important; max-width: 100% !important; } ' .
        'td, th { padding: 8px 12px; border: 1px solid #6b25d6; word-break: break-word; }';
    return $init;
});


add_action('after_setup_theme', 'custom_image_sizes');
function custom_image_sizes()
{
    add_image_size('carousel-large', 800, 600, true); // 800px de large, 600px de haut, rognée
}
