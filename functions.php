<?php


require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/enqueue-scripts.php';
require_once get_template_directory() . '/inc/custom-post-types-taxonomies.php';
require_once get_template_directory() . '/inc/custom-nav-walker.php';
require_once get_template_directory() . '/inc/widgets.php';
require_once get_template_directory() . '/inc/comments-pagination.php';
require_once get_template_directory() . '/inc/forms.php';
require_once get_template_directory() . '/inc/utility-functions.php';


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}
// Dans functions.php, forcer le remplacement global
add_filter('wp_get_attachment_url', function ($url) {
	return str_replace('http://deposit.local', 'https://deposark.com', $url);
}, 999);
