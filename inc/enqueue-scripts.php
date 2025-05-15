<?php
if (! defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

function deposark_scripts()
{
    wp_enqueue_script('deposark-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
    wp_enqueue_script('deposark-aos', get_template_directory_uri() . '/assets/vendor/aos/aos.js', array(), _S_VERSION, true);
    wp_enqueue_script('deposark-swiper', get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.js', array(), _S_VERSION, true);
    // Inclure Bootstrap CSS
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css',
        array(), // Dépendances
        '5.0.2'  // Version
    );
    // Inclure Popper.js (nécessaire pour certains composants Bootstrap)
    wp_enqueue_script(
        'popper-js',
        'https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js',
        array(), // Dépendances
        '2.9.3', // Version
        true     // Charger dans le footer
    );
    // Inclure Bootstrap JS
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js',
        array('popper-js', 'jquery'), // Dépendances : Popper.js et jQuery
        '5.0.2',                      // Version
        true                          // Charger dans le footer
    );
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
        array(), // Pas de dépendances
        '1.11.3' // Version
    );



    wp_enqueue_style('graphbit-themify-icons', get_template_directory_uri() . '/assets/css/themify-icons.css');
    if (!wp_is_mobile()) {
        wp_enqueue_script('deposark-aos', get_template_directory_uri() . '/assets/vendor/aos/aos.js', array(), _S_VERSION, true);
        wp_enqueue_style('graphbit-aos', get_template_directory_uri() . '/assets/vendor/aos/aos.css');
    }
    wp_enqueue_script('deposark-swiper', get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.js', array(), _S_VERSION, true);
    wp_enqueue_style('graphbit-swiper', get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.css');

    wp_enqueue_style('deposark-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('deposark-style', 'rtl', 'replace');



    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'deposark_scripts');
// Dans functions.php
add_action('wp_enqueue_scripts', 'fix_fontawesome_conflict', 999);
function fix_fontawesome_conflict()
{
    wp_dequeue_style('fontawesome'); // Désactive la version du plugin
    wp_deregister_style('fontawesome');

    // Charge la version actuelle via CDN
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );
}

// Charger le CSS 404 uniquement sur la page d'erreur
add_action('wp_enqueue_scripts', function () {
    if (is_404()) {
        wp_enqueue_style('error-404', get_theme_file_uri('/assets/css/404.css'));
    }
});

// font Kode Mono de google fonts

function add_kode_mono_font()
{
    wp_enqueue_style('kode-mono-font', 'https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&display=swap');
}
add_action('wp_enqueue_scripts', 'add_kode_mono_font');
function add_kode_mono_font_optimized()
{
    // Préconnexion pour améliorer les performances
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';

    // Chargement asynchrone
    wp_enqueue_style(
        'kode-mono-font',
        'https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&display=swap',
        array(),
        null
    );
}
add_action('wp_head', 'add_kode_mono_font_optimized', 1);
