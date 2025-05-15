<?php

// Activation de la fonctionnalité des menus
function deposark_theme_support()
{
	// Support des menus
	add_theme_support('menus');

	// Enregistrement des emplacements de menu
	register_nav_menus(array(
		'menu-1' => __('Menu Principal', 'deposark'),
		// Ajoutez d'autres emplacements si nécessaire
	));
}
add_action('after_setup_theme', 'deposark_theme_support');
function deposark_custom_header_setup()
{
	add_theme_support(
		'custom-header',
		apply_filters(
			'deposark_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '000000',
				'width'              => 1000,
				'height'             => 250,
				'flex-height'        => true,
				'wp-head-callback'   => 'deposark_header_style',
			)
		)
	);
}
add_action('after_setup_theme', 'deposark_custom_header_setup');

if (! function_exists('deposark_header_style')) :

	function deposark_header_style()
	{
		$header_text_color = get_header_textcolor();

		if (get_theme_support('custom-header', 'default-text-color') === $header_text_color) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
?>
		<style type="text/css">
			<?php
			// Has the text been hidden?
			if (! display_header_text()) :
			?>.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}

			<?php
			// If the user has set a custom color for the text use that.
			else :
			?>.site-title a,
			.site-description {
				color: #<?php echo esc_attr($header_text_color); ?>;


				<?php endif; ?>
		</style>
<?php
	}
endif;
