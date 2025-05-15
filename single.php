<?php
get_header();
$current_post = get_queried_object();
?>

<main style="background-color: var(--bg-color); color: white;">

	<!-- Start Breadcrumb Area -->
	<!-- Start Breadcrumb Area -->
	<?php
	// Préparation des variables
	$post_type = get_post_type();
	$header_image = get_header_image();
	$default_bg = get_template_directory_uri() . '/assets/images/default-bg.jpg';
	$breadcrumb_bg = esc_url(get_theme_mod('breadcrumb_bg_image', $default_bg));

	// Gestion de l'image d'en-tête
	$background_image = $header_image;

	if ($post_type === 'telechargement') {
		$brands = get_the_terms(get_the_ID(), 'brand');
		if ($brands && !is_wp_error($brands)) {
			$brand = reset($brands);
			$brand_image = get_term_meta($brand->term_id, 'brand_image', true);
			$background_image = $brand_image ? $brand_image : $header_image;
		}
	}

	// Fallback si aucune image trouvée
	$background_image = $background_image ? esc_url($background_image) : $default_bg;
	?>

	<div class="page-area bread-pd mb-5" style="background-image:url(<?php echo $background_image; ?>)">
		<div class="breadcumb-overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="bread-bg" style="background-image:url(<?php echo $breadcrumb_bg; ?>)">
						<div class="breadcrumb-title">
							<div class="bread-come">
								<nav aria-label="breadcrumb">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a class="black-text" href="<?php echo esc_url(home_url('/')); ?>">
												<?php echo esc_html__('Accueil', 'your-theme-textdomain'); ?>
											</a>
											<i class="bi-angle-right" aria-hidden="true"></i>
										</li>

										<?php
										// Gestion des éléments intermédiaires
										$intermediate_item = '';

										if ($post_type === 'telechargement') {
											$brands = get_the_terms(get_the_ID(), 'brand');
											if ($brands && !is_wp_error($brands)) {
												$brand = reset($brands);
												$intermediate_item = sprintf(
													'<a class="black-text" href="%s">%s</a>',
													esc_url(get_term_link($brand)),
													esc_html($brand->name)
												);
											}
										} else {
											$categories = get_the_category();
											if ($categories && !is_wp_error($categories)) {
												$category = reset($categories);
												$intermediate_item = sprintf(
													'<a class="black-text" href="%s">%s</a>',
													esc_url(get_category_link($category->term_id)),
													esc_html($category->name)
												);
											}
										}

										if (!empty($intermediate_item)) {
											echo '<li class="breadcrumb-item">'
												. $intermediate_item
												. '<i class="bi-angle-right" aria-hidden="true"></i></li>';
										}
										?>

										<li class="breadcrumb-item active">
											<?php the_title(); ?>
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumb Area -->
	<!-- End Breadcrumb Area -->

	<!-- Blog Area Start -->
	<div class="blog-area blog-details bg-color blog-sidebar-right fix area-padding-3">
		<div class="container">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-12">
					<article class="blog-post-wrapper single-blog">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<div class="blog-banner">
									<?php if (has_post_thumbnail()) : ?>
										<div class="blog-images">
											<?php the_post_thumbnail('full', ['class' => 'img-responsive']); ?>
											<div class="blog-item-date">
												<span class="years-type"><?php echo get_the_date('F j, Y'); ?></span>
											</div>
										</div>
									<?php endif; ?>

									<div class="blog-content">
										<div class="blog-meta">
											<span class="admin-type">
												<i class="fa fa-user"></i>
												<?php the_author_posts_link(); ?>
											</span>
											<span class="comments-type">
												<i class="fa fa-comment-o"></i>
												<?php comments_number(__('Aucun commentaire', 'text-domain'), __('1 Commentaire', 'text-domain'), __('% Commentaires', 'text-domain')); ?>
											</span>
										</div>

										<div class="entry-content">
											<?php the_content(); ?>
										</div>
									</div>
								</div>
						<?php endwhile;
						endif; ?>
					</article>
				</div>

				<!-- Sidebar -->
				<div class="col-xl-4 col-lg-4 col-md-4">
					<div class="left-head-blog right-side">
						<div id="search-2" class="left-blog-page d-none d-lg-block widget_search">
							<?php get_sidebar(); ?>
						</div>
					</div>
				</div>
			</div>

			<!-- Commentaires -->
			<div class="row">
				<!-- Commentaires -->
				<div class="comments-section">
					<?php comments_template(); ?>
				</div>
			</div>
		</div>
	</div>
	<!-- End of Blog Area -->
</main>

<?php get_footer(); ?>