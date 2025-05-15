<?php
require_once get_template_directory() . '/inc/wp_bootstrap_navwalker.php';

if (! defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

class DeposArk_Custom_Nav_Walker extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        // Configuration des icônes
        $brand_icons = [
            'wp-themes'    => 'fas fa-palette',
            'wp-plugins'    => 'fas fa-plug',
            'android'      => 'fab fa-android',
            'iphone'       => 'fab fa-apple',
            'mac'          => 'fas fa-desktop',
            'windows'      => 'fa-brands fa-microsoft'
        ];

        $page_icons = [
            'Accueil'     => 'fas fa-home',
            'Blog'        => 'fas fa-blog',
            'CONTACT'     => 'fas fa-envelope'
        ];

        // Récupération des informations nécessaires
        $current_object = get_queried_object();
        $is_active = false;
        $icon = '';

        // Gestion des icônes
        if ($item->object === 'brand') {
            $term = get_term_by('id', $item->object_id, 'brand');
            if ($term && !is_wp_error($term)) {
                // Mise à jour de l'URL pour la taxonomie
                $item->url = get_term_link($term);

                // Assignation de l'icône
                if (isset($brand_icons[$term->slug])) {
                    $icon = '<i class="' . $brand_icons[$term->slug] . '"></i>';
                }

                // Vérification de l'état actif
                if (
                    is_tax('brand', $term->term_id) ||
                    (is_singular('telechargement') && has_term($term->term_id, 'brand')) ||
                    (is_paged() && isset($current_object->term_id) && $current_object->term_id === $term->term_id)
                ) {
                    $is_active = true;
                }
            }
        } else {
            // Gestion des pages normales
            $icon = isset($page_icons[$item->title]) ?
                '<i class="' . $page_icons[$item->title] . '"></i>' :
                '';

            // Vérification standard de l'état actif
            $is_active = in_array('current-menu-item', $item->classes);
        }

        // Construction des classes
        $li_classes = ['nav-item'];
        if ($is_active) {
            $li_classes[] = 'active';
        }

        // Génération du HTML
        $output .= sprintf(
            '<li class="%s"><a class="nav-link" href="%s">%s%s</a></li>',
            implode(' ', $li_classes),
            esc_url($item->url),
            $icon,
            esc_html($item->title)
        );
    }
}
// Filtre complémentaire pour les articles individuels
add_filter('nav_menu_css_class', function ($classes, $item, $args, $depth) {
    if (is_singular('telechargement') && $item->object === 'brand') {
        $terms = get_the_terms(get_the_ID(), 'brand');
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                if ($item->object_id == $term->term_id) {
                    $classes[] = 'active';
                    break;
                }
            }
        }
    }
    return $classes;
}, 20, 4);
// Ajouter les classes actives personnalisées
add_filter('nav_menu_css_class', function ($classes, $item, $args, $depth) {
    // Pour les marques
    if ($item->object == 'brand') {
        $current_term = get_queried_object();
        $terms = [];

        if (is_singular('telechargement')) {
            $terms = get_the_terms(get_the_ID(), 'brand');
        } elseif (is_tax('brand')) {
            $terms = [$current_term];
        }

        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                if ($item->object_id == $term->term_id) {
                    $classes[] = 'active';
                    break;
                }
            }
        }
    }

    return $classes;
}, 20, 4);


// Ajouter "nav-item" aux <li>
add_filter('nav_menu_css_class', function ($classes, $item, $args, $depth) {
    $classes[] = 'nav-item';
    return $classes;
}, 10, 4);

// Ajouter "nav-link" aux <a>
add_filter('nav_menu_link_attributes', function ($atts, $item, $args, $depth) {
    $atts['class'] = 'nav-link';
    return $atts;
}, 10, 4);
