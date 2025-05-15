<?php
get_header();
$current_post = get_queried_object();
?>

<main style="background-color: var(--bg-color);color: white;">

    <!-- Start Breadcrumb Area -->
    <?php
    $current_post = get_post();
    $default_header = get_header_image();
    $theme_default_bg = get_template_directory_uri() . '/assets/images/default-bg.jpg';

    // Récupération de la marque
    $brand_term = null;
    $brand_terms = get_the_terms($current_post->ID, 'brand');

    if ($brand_terms && !is_wp_error($brand_terms)) {
        $brand_term = reset($brand_terms);
    }

    // Gestion de l'image principale
    $main_background = $default_header;
    if ($brand_term) {
        $brand_image = get_term_meta($brand_term->term_id, 'brand_image', true);
        $main_background = $brand_image ? esc_url($brand_image) : $default_header;
    }

    // Fallback si aucune image
    $main_background = $main_background ?: esc_url($theme_default_bg);

    // Image de fond du breadcrumb (maintenant identique à l'image principale)
    $breadcrumb_background = $main_background;
    ?>

    <div class="page-area bread-pd mb-5" style="background-image:url(<?php echo $main_background; ?>)">
        <div class="breadcumb-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bread-bg" style="background-image:url(<?php echo $breadcrumb_background; ?>)">
                        <div class="breadcrumb-title">
                            <div class="bread-come">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a class="black-text" href="<?php echo esc_url(home_url('/')); ?>">
                                                <?php echo esc_html__('Accueil', 'your-textdomain'); ?>
                                            </a>
                                            <i class="ti-angle-right" aria-hidden="true"></i>
                                        </li>
                                        <?php echo $brand_link; // Injection sécurisée du lien de la marque 
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


                                                <?php comments_number(__('No Comments', 'text-domain'), __('1 Commentaire', 'text-domain'), __('% Commentaires', 'text-domain')); ?>
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

                <!-- Sidebar (identique à taxonomy-brand.php) -->
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="left-head-blog right-side">
                        <div id="search-2" class="left-blog-page d-none d-lg-block widget_search">
                            <?php get_sidebar(); ?>
                        </div>
                    </div>
                </div>
            </div>
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