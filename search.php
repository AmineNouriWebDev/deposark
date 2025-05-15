<?php get_header(); ?>

<main id="primary" class="site-main">

	<?php if (have_posts()) : ?>

		<header class="page-header">
			<h1 class="page-title">
				<?php
				printf(
					esc_html__('Résultats de recherche pour : %s', 'deposark'),
					'<span>' . get_search_query() . '</span>'
				);
				?>
			</h1>
		</header>

		<div class="blog-area blog-details bg-color blog-sidebar-right fix area-padding-3">
			<div class="container">
				<div class="row">
					<div class="col-xl-8 col-lg-8 col-12">
						<?php
						while (have_posts()) : the_post(); ?>
							<article class="blog-post-wrapper single-blog">
								<div class="blog-banner">
									<?php if (has_post_thumbnail()) : ?>
										<div class="blog-images">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail('full', array('alt' => get_the_title())); ?>
											</a>
											<div class="blog-item-date">
												<span class="years-type"><?php the_time('j F Y'); ?></span>
											</div>
											<?php
											// Affichage de la catégorie avec icône
											$categories = get_the_category();
											if (!empty($categories)) :
												$category = reset($categories);
												$slug = strtolower($category->slug);
												$icons = [
													'wp-plugins' => 'bi-puzzle',
													'wp-themes' => 'bi-brush',
													'iphone' => 'bi-phone',
													'android' => 'bi-android2',
													'mac' => 'bi-apple',
													'windows' => 'bi-windows'
												];
												$icon_class = $icons[$slug] ?? 'bi-folder';
											?>
												<div class="blog-item-category">
													<a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-badge">
														<i class="bi <?php echo $icon_class; ?> me-2"></i>
														<?php echo esc_html($category->name); ?>
													</a>
												</div>
											<?php endif; ?>
										</div>
									<?php endif; ?>
									<div class="blog-content">
										<div class="blog-meta">
											<span class="admin-type">
												<i class="fa fa-user"></i>
												<?php the_author_posts_link(); ?>
											</span>
										</div>
										<a href="<?php the_permalink(); ?>">
											<h4><?php the_title(); ?></h4>
										</a>
										<?php the_excerpt(); ?>
										<a class="blog-btn anti-bttn" href="<?php the_permalink(); ?>">
											<?php esc_html_e('Lire la suite', 'deposark'); ?>
										</a>
									</div>
								</div>
							</article>
						<?php endwhile; ?>

						<!-- Pagination -->
						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="blog-pagination">
								<?php the_posts_pagination(array(
									'mid_size' => 2,
									'prev_text' => __('<i class="bi bi-arrow-left"></i>', 'deposark'),
									'next_text' => __('<i class="bi bi-arrow-right"></i>', 'deposark'),
								)); ?>
							</div>
						</div>

					</div>

					<!-- Sidebar -->
					<div class="col-xl-4 col-lg-4 col-md-4 ">

						<div class="left-head-blog right-side sticky-lg-top">
							<div id="search-2" class="left-blog-page d-none d-lg-block widget_search">
								<?php get_sidebar(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	<?php else : ?>

		<?php get_template_part('template-parts/content', 'none'); ?>

	<?php endif; ?>

</main>

<?php get_footer(); ?>