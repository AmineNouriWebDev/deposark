<?php

/**
 * Template Name: Page d'accueil
 *
 * @package VotreTheme
 */

get_header(); // Charge l'en-tête du thème
?>

<main id="main" class="site-main">

    <!--   ***** Début hero header  *****  -->
    <section class="hero-container">
        <div class="hero-header">
            <h1>Votre Hub Technologique Ultime</h1>
            <h2>Téléchargez des ressources premium pour WordPress, applications mobiles et desktop</h2>

            <div class="platform-grid">
                <div class="platform-item">
                    <svg aria-hidden="true" class="platform-icon" viewBox="0 0 24 24">
                        <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm-2 15l-5-5 1.4-1.4 3.6 3.6 7.6-7.6L19 8l-9 9z" />
                    </svg>
                    <span>Plugins & Thèmes WordPress</span>
                </div>
                <div class="platform-item">
                    <svg aria-hidden="true" class="platform-icon" viewBox="0 0 24 24">
                        <path d="M18 3H6C4.3 3 3 4.3 3 6v12c0 1.7 1.3 3 3 3h12c1.7 0 3-1.3 3-3V6c0-1.7-1.3-3-3-3zM6 5h12c.6 0 1 .4 1 1v8H5V6c0-.6.4-1 1-1z" />
                    </svg>
                    <span>Applications Windows/Mac</span>
                </div>
                <div class="platform-item">
                    <svg aria-hidden="true" class="platform-icon" viewBox="0 0 24 24">
                        <path d="M16 1H8C6.3 1 5 2.3 5 4v16c0 1.7 1.3 3 3 3h8c1.7 0 3-1.3 3-3V4c0-1.7-1.3-3-3-3zm-4 18c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" />
                    </svg>
                    <span>Apps Mobile Android/iOS</span>
                </div>
            </div>

            <div class="hero-footer">
                <a href="#category-section" class="cta-primary">Explorer les Téléchargements</a>

            </div>


        </div>
    </section>
    <!--   ***** Fin hero header  *****  -->


    <!-- Blog Home pageHero Section -->
    <section id="blog-hero" class="blog-hero section mb-5">
        <div class="container " data-aos="fade-up" data-aos-delay="100">
            <div class="blog-grid ">

                <?php
                $categories = array('wp-plugins', 'Android', 'Windows', 'Mac', 'Iphone');
                $category_names = array(
                    'wp-plugins' => 'Wordpress',
                    'Android'    => 'Android',
                    'Windows'    => 'Windows',
                    'Mac'       => 'Mac',
                    'Iphone'     => 'Iphone'
                );

                foreach ($categories as $index => $category_slug) {
                    $args = array(
                        'category_name' => $category_slug,
                        'posts_per_page' => 1
                    );

                    $query = new WP_Query($args);

                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();

                            // Configuration spécifique pour le premier article (Featured)
                            $is_featured = ($index === 0);
                            $delay = $is_featured ? '' : ' data-aos-delay="' . ($index * 100) . '"';
                            $title_tag = $is_featured ? 'h2' : 'h3';

                            // Limiter le titre à 50 caractères
                            $title = get_the_title();
                            $limited_title = mb_strlen($title) > 40 ? mb_substr($title, 0, 40) . '...' : $title;
                ?>

                            <article class="blog-item <?php echo $is_featured ? 'featured' : ''; ?>" data-aos="fade-up" <?php echo $delay; ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url($is_featured ? 'large' : 'medium'); ?>" alt="<?php echo esc_attr($limited_title); ?>" class="img-fluid">
                                <?php endif; ?>

                                <div class="blog-content">
                                    <div class="post-meta">
                                        <span class="date"><?php echo get_the_date('j F Y'); ?></span>
                                        <span class="category"><?php echo $category_names[$category_slug]; ?></span>
                                    </div>

                                    <<?php echo $title_tag; ?> class="post-title">
                                        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr($title); ?>">
                                            <?php echo esc_html($limited_title); ?>
                                        </a>
                                    </<?php echo $title_tag; ?>>
                                </div>
                            </article>

                <?php
                        }
                        wp_reset_postdata();
                    }
                }
                ?>

            </div>
        </div>
    </section>

    <!-- Featured Posts Section -->
    <section id="featured-posts" class="featured-posts  pt-3 section mb-5">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Thèmes WordPress</h2>
            <div>
                <span>Découvrez nos</span>
                <span class="description-title">Derniers Thèmes</span>
            </div>
        </div>
        <!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="blog-posts-slider swiper init-swiper">
                <script type="application/json" class="swiper-config">
                    {
                        "loop": true,
                        "speed": 800,
                        "autoplay": {
                            "delay": 3000
                        },
                        "slidesPerView": 3,
                        "spaceBetween": 30,
                        "breakpoints": {
                            "320": {
                                "slidesPerView": 1,
                                "spaceBetween": 20
                            },
                            "768": {
                                "slidesPerView": 2,
                                "spaceBetween": 20
                            },
                            "1200": {
                                "slidesPerView": 3,
                                "spaceBetween": 30
                            }
                        }
                    }
                </script>

                <div class="swiper-wrapper">
                    <?php
                    // Récupérer les 7 derniers articles de la catégorie wp-plugins
                    $args = array(
                        'post_type' => 'telechargement',
                        'posts_per_page' => 7,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'brand',
                                'field' => 'slug',
                                'terms' => 'wp-themes'
                            )
                        ),
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );

                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                            $comments_count = get_comments_number();
                    ?>
                            <div class="swiper-slide">
                                <div class="blog-post-item">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'carousel-large'); ?>" alt="<?php the_title_attribute(); ?>" />
                                    <?php endif; ?>

                                    <div class="blog-post-content">
                                        <div class="post-meta">
                                            <span><i class="bi bi-clock"></i> <?php echo get_the_date('M j, Y'); ?></span>
                                            <span><i class="bi bi-chat-dots"></i> <?php echo $comments_count . ' ' . _n('Comment', 'Comments', $comments_count); ?></span>
                                        </div>
                                        <h2>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                        <a href="<?php the_permalink(); ?>" class="read-more">
                                            Lire plus <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endwhile;
                        wp_reset_postdata();
                    else : ?>
                        <div class="swiper-slide">
                            <p>Aucun thème trouvé</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
    <!-- /Featured Posts Section -->
    <!-- Category Section Section -->
    <section id="category-section" class="dl-category-section bg-white dl-section">
        <!-- Section Title -->
        <div class="container dl-section-title pt-5 mb-5" data-aos="fade-up">
            <h2>Derniers Téléchargements</h2>
            <div><span class="dl-description-title">Par Catégorie</span></div>
        </div>
        <!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <!-- Featured Posts -->
            <div class="row gy-4 mb-4">
                <?php
                // Requête pour les 3 premiers téléchargements
                $featured_args = array(
                    'post_type' => 'telechargement', // Attention au nom exact du CPT
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'brand', // Nom de la taxonomie dans functions.php
                            'field' => 'slug',
                            'terms' => array('wp-plugins', 'android', 'windows', 'mac', 'iphone')
                        )
                    )
                );

                $featured_query = new WP_Query($featured_args);

                if ($featured_query->have_posts()) :
                    while ($featured_query->have_posts()) : $featured_query->the_post();
                        $marque = get_the_terms(get_the_ID(), 'brand')[0];
                ?>
                        <div class="col-lg-4">
                            <article class="dl-featured-post">
                                <div class="dl-post-img">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img
                                            src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>"
                                            alt="<?php the_title_attribute(); ?>"
                                            class="dl-img-fluid"
                                            loading="lazy" />
                                    <?php else : ?>
                                        <img
                                            src="<?php echo get_theme_file_uri('/assets/img/blog/blog-placeholder.webp'); ?>"
                                            alt="Image par défaut"
                                            class="dl-img-fluid"
                                            loading="lazy" />
                                    <?php endif; ?>
                                </div>
                                <div class="dl-post-content">
                                    <div class="dl-category-meta">
                                        <span class="dl-post-category"><?php echo $marque->name; ?></span>
                                        <div class="dl-author-meta">

                                            <span class="dl-post-date"><?php echo get_the_date('j F Y'); ?></span>
                                        </div>
                                    </div>
                                    <h2 class="dl-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                </div>
                            </article>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <div class="col-lg-12">
                        <p>Aucun téléchargement récent trouvé</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- List Posts -->
            <div class="row">
                <?php
                // Requête pour les 6 téléchargements suivants
                $list_args = array(
                    'post_type' => 'telechargement',
                    'posts_per_page' => 6,
                    'offset' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'brand',
                            'field' => 'slug',
                            'terms' => array('wp-plugins', 'android', 'windows', 'mac', 'iphone')
                        )
                    )
                );

                $list_query = new WP_Query($list_args);

                if ($list_query->have_posts()) :
                    while ($list_query->have_posts()) : $list_query->the_post();
                        $marque = get_the_terms(get_the_ID(), 'brand')[0];
                ?>
                        <div class="col-xl-4 col-lg-6">
                            <article class="dl-list-post">
                                <div class="dl-post-img">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img
                                            src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>"
                                            alt="<?php the_title_attribute(); ?>"
                                            class="dl-img-fluid"
                                            loading="lazy" />
                                    <?php else : ?>
                                        <img
                                            src="<?php echo get_theme_file_uri('/assets/img/blog/blog-placeholder.webp'); ?>"
                                            alt="Image par défaut"
                                            class="dl-img-fluid"
                                            loading="lazy" />
                                    <?php endif; ?>
                                </div>
                                <div class="dl-post-content">
                                    <div class="dl-category-meta">
                                        <span class="dl-post-category"><?php echo $marque->name; ?></span>
                                    </div>
                                    <h3 class="dl-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="dl-post-meta">
                                        <!-- Temps de lecture fixe comme dans l'original -->
                                        <span class="dl-read-time">2 min de lecture</span>
                                        <span class="dl-post-date"><?php echo get_the_date('j F Y'); ?></span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <div class="col-lg-12">
                        <p>Aucun autre téléchargement disponible</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- /Category Section Section -->

    <section id="call-to-action-2" class="call-to-action-2  mt-5 section mb-5">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="advertise-1 d-flex flex-column flex-lg-row gap-4 align-items-center position-relative">

                <div class="content-left flex-grow-1" data-aos="fade-right" data-aos-delay="200">
                    <span class="badge text-uppercase mb-2">Offre exclusive</span>
                    <h2>Boostez Votre Productivité Numérique</h2>
                    <p class="my-4">Découvrez nos solutions premium pour professionnels : plugins WordPress optimisés, thèmes professionnels et applications cross-platform pour Mac/Windows. Plus de 5000 freelances et entreprises nous font déjà confiance pour accélérer leurs projets.</p>

                    <div class="features d-flex flex-wrap gap-3 mb-4">
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Support Premium 24/7</span>
                        </div>

                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Mises à Jour Régulières</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Optimisation SEO Intégrée</span>
                        </div>
                    </div>

                </div>

                <div class="content-right position-relative" data-aos="fade-left" data-aos-delay="300">
                    <img src="https://deposark.com/wp-content/uploads/2025/03/success.jpg" alt="Environnement de travail digital" class="img-fluid rounded-4">
                    <div class="floating-card">
                        <div class="card-icon">
                            <i class="bi bi-speedometer2"></i>
                        </div>
                        <div class="card-content">
                            <span class="stats-number">87%</span>
                            <span class="stats-text">Gain d'Efficacité</span>
                        </div>
                    </div>
                </div>

                <div class="decoration">
                    <div class="circle-1"></div>
                    <div class="circle-2"></div>
                </div>

            </div>

        </div>

    </section><!-- /Call To Action 2 Section -->

    <!-- Latest Posts Section -->
    <section id="latest-posts" class="latest-posts section mb-5">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Dernières Publications</h2>
            <div>
                <span>Découvrez nos</span>
                <span class="description-title">Nouveautés</span>
            </div>
        </div>
        <!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 6,
                    'orderby' => array(
                        'comment_count' => 'DESC',
                        'date' => 'DESC'
                    )
                );

                $posts_query = new WP_Query($args);

                if ($posts_query->have_posts()) :
                    while ($posts_query->have_posts()) : $posts_query->the_post();
                        $categories = get_the_category();
                        $category = !empty($categories) ? $categories[0]->name : 'Général';
                        $comment_count = get_comments_number();
                ?>
                        <div class="col-lg-4">
                            <article>
                                <div class="post-img position-relative">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img
                                            src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>"
                                            alt="<?php the_title_attribute(); ?>"
                                            class="img-fluid" />
                                    <?php else : ?>
                                        <img
                                            src="<?php echo get_theme_file_uri('/assets/img/blog/blog-placeholder.webp'); ?>"
                                            alt="Image par défaut"
                                            class="img-fluid" />
                                    <?php endif; ?>

                                    <!-- Logo Bootstrap -->
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <svg width="24" height="24" fill="currentColor" class="bi bi-file-text">
                                            <use xlink:href="#file-text" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Catégorie avec icône -->
                                <p class="post-category mb-2">
                                    <?php
                                    // Détermine l'icône en fonction de la catégorie
                                    $category_slug = !empty($categories) ? $categories[0]->slug : 'default';

                                    switch ($category_slug) {
                                        case 'wp-themes':
                                            $icon = 'fas fa-palette';
                                            break;
                                        case 'wp-plugins':
                                            $icon = 'fas fa-plug';
                                            break;
                                        case 'android':
                                            $icon = 'fab fa-android';
                                            break;
                                        case 'iphone':
                                            $icon = 'fab fa-apple';
                                            break;
                                        case 'mac':
                                            $icon = 'fas fa-desktop';
                                            break;
                                        case 'windows':
                                            $icon = 'fab fa-microsoft';
                                            break;
                                        default:
                                            $icon = 'fas fa-tag';
                                    }
                                    ?>
                                    <i class="<?php echo $icon; ?> me-2"></i>
                                    <?php echo esc_html($category); ?>
                                </p>



                                <h2 class="title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                                        $title = get_the_title();
                                        echo esc_html(mb_substr($title, 0, 60));
                                        echo mb_strlen($title) > 60 ? '...' : '';
                                        ?>
                                    </a>
                                </h2>

                                <!-- Métadonnées fixes -->
                                <div class="post-meta d-flex justify-content-between align-items-center mt-2">

                                    <p class="post-date mb-0">
                                        <time datetime="<?php echo get_the_date('c'); ?>">
                                            <i class="bi bi-calendar me-1"></i>
                                            <?php echo get_the_date('j M Y'); ?>
                                        </time>
                                    </p>
                                    <p class="comments-count mb-0">
                                        <i class="bi bi-chat-dots me-1"></i>
                                        <?php echo number_format_i18n($comment_count); ?>
                                    </p>
                                </div>
                            </article>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <div class="col-12">
                        <p class="text-center">Aucune publication récente</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- /Latest Posts Section -->
    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4 justify-content-between align-items-center">
                <div class="col-lg-6">
                    <div class="cta-content" data-aos="fade-up" data-aos-delay="200">
                        <h2>Abonnez-vous à notre newsletter</h2>
                        <p>Recevez les dernières actualités, mises à jour et offres spéciales directement dans votre boîte mail.</p>
                        <form id="newsletter-form" method="post" class="php-email-form cta-form" data-aos="fade-up" data-aos-delay="300">
                            <input type="hidden" name="action" value="newsletter_subscription">
                            <?php wp_nonce_field('newsletter_nonce', 'newsletter_security'); ?>
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Votre adresse email..." required>
                                <button class="btn btn-primary" type="submit">S'abonner</button>
                            </div>
                            <div class="loading">Envoi en cours...</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Merci ! Vous recevrez bientôt nos actualités.</div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cta-image" data-aos="zoom-out" data-aos-delay="200">
                        <img src="https://deposark.com/wp-content/uploads/2025/03/cta-1.webp" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer(); // Charge le pied de page du thème
?>