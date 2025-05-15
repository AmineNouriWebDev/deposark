<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DeposArk
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8422914368176546"
		crossorigin="anonymous"></script>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-67T02MC23L"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'G-67T02MC23L');
	</script>


	<!-- Main CSS File -->


	<!-- Sprite SVG global -->
	<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
		<symbol id="file-text" viewBox="0 0 16 16">
			<path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z" />
			<path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z" />
		</symbol>
	</svg>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="page" class="site">


		<header>



			<nav class="navbar navbar-expand-custom navbar-mainbg">
				<a class="navbar-brand navbar-logo d-flex align-items-center" href="<?= esc_url(home_url('/')); ?>">
					<span><?php bloginfo('name'); ?></span>
					<div class="d-flex ms-3 gap-2">
						<i class="bi bi-cloud-download fs-5 icon-hover"></i>

					</div>
				</a>
				<button class="navbar-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<i class="fas fa-bars text-white"></i>
				</button>

				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'menu-1',
						'menu_id'         => 'primary-menu',
						'menu_class'      => 'navbar-nav ml-auto',
						'container'       => 'div',
						'container_class' => 'collapse navbar-collapse',
						'container_id'    => 'navbarSupportedContent',
						'items_wrap'      => '<ul id="%1$s" class="%2$s"><div class="hori-selector"><div class="left"></div><div class="right"></div></div>%3$s</ul>',
						'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
						'walker'          => new DeposArk_Custom_Nav_Walker(),
					)
				);
				?>
				<!-- Bouton de recherche -->
				<button class="btn btn-search" data-bs-toggle="modal" data-bs-target="#searchModal">
					<i class="fas fa-search"></i>
				</button>


			</nav>
			<!-- Modal de recherche -->


			<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="searchModalLabel">Rechercher</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<?php get_search_form(); ?> <!-- Utilise le formulaire personnalisé -->
						</div>
					</div>
				</div>
			</div>




		</header>