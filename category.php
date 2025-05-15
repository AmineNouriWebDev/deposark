<?php
get_header();
$current_category = get_queried_object();
?>

<main style="background-color: var(--bg-color);">

    <!-- Start Breadcrumb Area -->
    <div class="page-area bread-pd mb-5" style="background-image:url(<?php echo esc_url(get_header_image()); ?>)">
        <div class="breadcumb-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bread-bg" style="background-image:url(<?php
                                                                        echo esc_url(get_theme_mod('breadcrumb_bg_image', get_template_directory_uri() . '/assets/images/default-bg.jpg'));
                                                                        ?>)">
                        <div class="breadcrumb-title">
                            <h2><?php echo esc_html($current_category->name); ?></h2>
                            <div class="bread-come">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a class="black-text" href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
                                            <i class="bi-angle-right" aria-hidden="true"></i>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a class="black-text" href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
                                                Blog
                                            </a>
                                            <i class="bi-angle-right" aria-hidden="true"></i>
                                        </li>
                                        <?php if (is_paged()) : ?>
                                            <li class="breadcrumb-item">
                                                <a class="black-text" href="<?php echo esc_url(get_category_link($current_category->term_id)); ?>">
                                                    <?php echo esc_html($current_category->name); ?>
                                                </a>
                                                <i class="bi-angle-right" aria-hidden="true"></i>
                                            </li>
                                            <li class="breadcrumb-item active">
                                                Page <?php echo absint(get_query_var('paged')); ?>
                                            </li>
                                        <?php else : ?>
                                            <li class="breadcrumb-item active">
                                                <?php echo esc_html($current_category->name); ?>
                                            </li>
                                        <?php endif; ?>
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

    <!-- Blog Area Start -->
    <div class="blog-area blog-details bg-color blog-sidebar-right fix area-padding-3">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-12">
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?>
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
                                        <a href="<?php the_permalink(); ?>">
                                            <h4 style="color: white; text-decoration: none;"><?php the_title(); ?></h4>
                                        </a>
                                        <span style="color: wheat;"><?php the_excerpt(); ?></span>
                                        <a class="blog-btn anti-bttn" href="<?php the_permalink(); ?>">
                                            <?php esc_html_e('Lire la suite', 'text-domain'); ?>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>

                        <!-- Pagination -->
                        <!-- Pagination -->
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="blog-pagination">

                                <?php graphbit_pagination(); ?>

                            </div>
                        </div>

                    <?php else : ?>
                        <p><?php esc_html_e('Aucun article trouvé dans cette catégorie.', 'text-domain'); ?></p>
                    <?php endif; ?>
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
        </div>
    </div>
    <!-- End of Blog Area -->
</main>

<?php get_footer(); ?>