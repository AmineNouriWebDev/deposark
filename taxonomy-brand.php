<?php
get_header();
$term = get_queried_object();
?>

<main style="background-color: var(--bg-color);">

    <!-- Start Breadcrumb Area -->
    <?php
    // Préparation des variables
    $current_term = get_queried_object();
    $default_header = esc_url(get_header_image());
    $theme_default_bg = esc_url(get_template_directory_uri() . '/assets/images/default-bg.jpg');

    // Gestion de l'image principale
    $main_background = $default_header;
    $breadcrumb_background = $default_header;

    if (is_tax('brand')) {
        $brand_image = get_term_meta($current_term->term_id, 'brand_image', true);

        // Hiérarchie des images
        $main_background = $brand_image ? esc_url($brand_image) : $default_header;
        $breadcrumb_background = $main_background; // Utilisation de la même image

        // Fallback final
        if (!$main_background) {
            $main_background = $theme_default_bg;
            $breadcrumb_background = $theme_default_bg;
        }
    }

    // Construction du fil d'Ariane
    $breadcrumb_items = [
        [
            'url' => home_url('/'),
            'text' => __('Accueil', 'your-textdomain')
        ]
    ];

    if (is_tax('brand')) {
        $breadcrumb_items[] = [
            'url' => get_term_link($current_term),
            'text' => $current_term->name
        ];

        if (is_paged()) {
            $breadcrumb_items[] = [
                'text' => sprintf(__('Page %d', 'your-textdomain'), absint(get_query_var('paged')))
            ];
        }
    }
    ?>

    <div class="page-area bread-pd mb-5">
        <div class="breadcumb-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bread-bg" style="background-image:url(<?php echo $breadcrumb_background; ?>)">
                        <div class="breadcrumb-title">
                            <h2><?php single_term_title(); ?></h2>
                            <div class="bread-come">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <?php foreach ($breadcrumb_items as $index => $item) : ?>
                                            <li class="breadcrumb-item <?php echo ($index === count($breadcrumb_items) - 1) ? 'active' : ''; ?>">
                                                <?php if (isset($item['url'])) : ?>
                                                    <a class="black-text" href="<?php echo esc_url($item['url']); ?>">
                                                        <?php echo esc_html($item['text']); ?>
                                                    </a>
                                                    <i class="ti-angle-right" aria-hidden="true"></i>
                                                <?php else : ?>
                                                    <?php echo esc_html($item['text']); ?>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
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
                    $args = [
                        'post_type' => 'telechargement',
                        'tax_query' => [[
                            'taxonomy' => 'brand',
                            'field' => 'slug',
                            'terms' => $term->slug
                        ]],
                        'paged' => $paged
                    ];

                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post(); ?>
                            <article class="blog-post-wrapper single-blog">
                                <div class="blog-banner">
                                    <?php if (has_post_thumbnail()) { ?>
                                        <div class="blog-images">
                                            <a href="<?php the_permalink(); ?>"><img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" alt=""></a>
                                            <div class="blog-item-date">
                                                <span class="years-type"><?php the_time(get_option('date_format')); ?></span>
                                            </div>
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
                                                <?php comments_number(__('No Comments', 'text-domain'), __('1 Comment', 'text-domain'), __('% Comments', 'text-domain')); ?>
                                            </span>
                                        </div>
                                        <a href="<?php the_permalink(); ?>">
                                            <h4 style="color: white;text-decoration:none;"><?php the_title(); ?></h4>
                                        </a>
                                        <span style="color: wheat;"> <?php the_excerpt(); ?></span>
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
                        <p><?php esc_html_e('Aucun téléchargement disponible pour cette marque.', 'text-domain'); ?></p>
                    <?php
                    endif;
                    wp_reset_postdata();
                    ?>
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