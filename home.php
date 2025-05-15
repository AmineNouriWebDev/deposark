<?php

/**
 * Template Name: Blog Custom
 * Template Post Type: page
 */
get_header();
?>

<main style="background-color: var(--bg-color);">

    <!-- Start Breadcrumb Area -->
    <div class="page-area bread-pd mb-5" style="background-image:url(<?php
                                                                        // Utiliser l'image d'en-tête par défaut pour le blog
                                                                        echo esc_url(get_header_image());
                                                                        ?>)">
        <div class="breadcumb-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bread-bg" style="background-image:url(<?php
                                                                        echo esc_url(get_theme_mod('breadcrumb_bg_image', get_template_directory_uri() . '/assets/images/default-bg.jpg'));
                                                                        ?>)">
                        <div class="breadcrumb-title">

                            <div class="bread-come">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a class="black-text" href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
                                            <i class="ti-angle-right" aria-hidden="true"></i>
                                        </li>
                                        <li class="breadcrumb-item active">
                                            <?php
                                            if (is_paged()) {
                                                echo '<a class="black-text" href="' . esc_url(get_permalink()) . '">Blog</a>';
                                                echo '<i class="ti-angle-right" aria-hidden="true"></i></li>';
                                                echo '<li class="breadcrumb-item active">Page ' . absint(get_query_var('paged'));
                                            } else {
                                                echo 'Blog';
                                            }
                                            ?>
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

    <!-- Blog Area Start -->
    <div class="blog-area blog-details bg-color blog-sidebar-right fix area-padding-3">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-12">
                    <?php
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type' => 'post',
                        'paged' => $paged
                    );

                    $blog_query = new WP_Query($args);

                    if ($blog_query->have_posts()) :
                        while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                            <article class="blog-post-wrapper single-blog">
                                <div class="blog-banner">
                                    <?php if (has_post_thumbnail()) { ?>
                                        <div class="blog-images">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('full', array('alt' => get_the_title())); ?>
                                            </a>
                                            <div class="blog-item-date">
                                                <span class="years-type"><?php the_time('j F Y'); ?></span>
                                            </div>
                                            <?php
                                            // Ajout des catégories avec icône
                                            $categories = get_the_category();
                                            if (!empty($categories)) :
                                                $primary_category = reset($categories); // Prend la première catégorie
                                            ?>

                                                <div class="blog-item-category">
                                                    <?php
                                                    $categories = get_the_category();
                                                    if (!empty($categories)) :
                                                        $category = reset($categories);
                                                        $slug = strtolower($category->slug);

                                                        // Mapping des icônes Bootstrap par catégorie
                                                        $icons = [
                                                            'wp-plugins'  => 'bi-puzzle',         // Icône puzzle pour plugins
                                                            'wp-themes'   => 'bi-brush',          // Icône pinceau pour thèmes
                                                            'iphone'      => 'bi-phone',          // Icône téléphone pour iPhone
                                                            'android'     => 'bi-android2',       // Icône Android officielle
                                                            'mac'         => 'bi-apple',          // Icône Apple
                                                            'windows'     => 'bi-windows'         // Icône Windows
                                                        ];

                                                        $icon_class = $icons[$slug] ?? 'bi-folder'; // Fallback si catégorie inconnue
                                                    ?>
                                                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-badge">
                                                            <i class="bi <?php echo $icon_class; ?> me-2"></i>
                                                            <?php echo esc_html($category->name); ?>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php } ?>
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
                                            <h4><?php the_title(); ?></h4>
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
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="blog-pagination">

                                <?php graphbit_pagination(); ?>

                            </div>
                        </div>


                    <?php else : ?>
                        <p><?php esc_html_e('Aucun article trouvé.', 'text-domain'); ?></p>
                    <?php
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>

                <!-- Sidebar (identique à taxonomy-brand.php) -->
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