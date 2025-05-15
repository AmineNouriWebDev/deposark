<?php
// Créer une taxonomie "Marques" (Brands)
function create_brand_taxonomy()
{
    register_taxonomy('brand', 'telechargement', array( // Limitez au CPT download
        'labels' => array(
            'name' => 'Marques',
            'singular_name' => 'Marque'
        ),
        'rewrite' => array(
            'slug' => 'marques', // Nouveau slug
            'with_front' => false,
            'hierarchical' => true // Permet les slugs parent/enfant
        ),
        'hierarchical' => true,
        'show_admin_column' => true,
        'show_in_rest' => true, // Nécessaire pour Gutenberg
        'meta_box_cb' => 'post_categories_meta_box', // Affiche comme les catégories
    ));
}
add_action('init', 'create_brand_taxonomy');

// Créer un type de contenu "Téléchargements"

function create_download_post_type()
{
    $labels = array(
        'name'               => 'Téléchargements',
        'singular_name'      => 'Téléchargement',
        'menu_name'          => 'Téléchargements',
        'add_new'            => 'Ajouter un article à télécharger',
        'add_new_item'       => 'Ajouter un article à télécharger',
        'edit_item'          => 'Éditer l\'article à télécharger',
        'new_item'           => 'Nouveau article à télécharger',
        'view_item'          => 'Voir l\'article à télécharger',
        'search_items'       => 'Rechercher des articles à télécharger',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'telechargements'), // URL personnalisée (ex: /telechargement/nom-article)
        'capability_type'    => 'post',
        'has_archive'        => true, // Archive à /telechargement/
        'hierarchical'       => false,
        'menu_position'      => 5, // Position dans le menu admin (5 = après "Articles")
        'menu_icon'          => 'dashicons-products', // Icône WordPress (https://developer.wordpress.org/resource/dashicons/)
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'show_in_rest'       => false, // Compatible avec l'éditeur Gutenberg
    );

    register_post_type('telechargement', $args);
}
add_action('init', 'create_download_post_type');
// Filtrer les téléchargements par marque dans l'admin a coté du titre et de date publication
add_filter('parse_query', function ($query) {
    global $pagenow;
    $type = isset($_GET['post_type']) ? $_GET['post_type'] : 'post';

    if ($pagenow == 'edit.php' && $type == 'telechargement' && isset($_GET['brand'])) {
        $query->query_vars['tax_query'] = [[
            'taxonomy' => 'brand',
            'field' => 'slug',
            'terms' => $_GET['brand']
        ]];
    }
});
// Balises meta pour les archives de marques
add_action('wp_head', function () {
    if (is_tax('brand')) {
        $term = get_queried_object();
        echo '<meta name="description" content="Téléchargements pour ' . esc_attr($term->name) . '">';
    }
});
// Ajouter un champ image aux termes de la taxonomie
function add_brand_image_field($term)
{
    $image = get_term_meta($term->term_id, 'brand_image', true);
?>
    <div class="form-field term-group">
        <label for="brand-image"><?php _e('Image de la marque', 'text-domain'); ?></label>
        <input type="text" id="brand-image" name="brand_image" value="<?php echo esc_url($image); ?>" class="meta-image-field">
        <button type="button" class="button meta-image-button"><?php _e('Choisir une image', 'text-domain'); ?></button>
    </div>
<?php
}
add_action('brand_add_form_fields', 'add_brand_image_field');
add_action('brand_edit_form_fields', 'add_brand_image_field');

// Sauvegarder le champ image
function save_brand_image($term_id)
{
    if (isset($_POST['brand_image'])) {
        update_term_meta($term_id, 'brand_image', esc_url_raw($_POST['brand_image']));
    }
}
add_action('created_brand', 'save_brand_image');
add_action('edited_brand', 'save_brand_image');

// Scripts pour le média uploader
function brand_admin_scripts()
{
    wp_enqueue_media();
    wp_enqueue_script('brand-admin-js', get_template_directory_uri() . '/js/admin-brand.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'brand_admin_scripts');


// Filtre amélioré avec dropdown
add_action('restrict_manage_posts', 'filter_telechargement_by_brand');
function filter_telechargement_by_brand()
{
    global $typenow;

    if ($typenow == 'telechargement') {
        $selected = isset($_GET['brand']) ? $_GET['brand'] : '';
        wp_dropdown_categories(array(
            'show_option_all' => 'Toutes les marques',
            'taxonomy' => 'brand',
            'name' => 'brand',
            'value_field' => 'slug',
            'selected' => $selected,
            'hierarchical' => true
        ));
    }
}

// Adaptation du parse_query
add_filter('parse_query', 'convert_brand_id_to_taxonomy_term_in_query');
function convert_brand_id_to_taxonomy_term_in_query($query)
{
    global $pagenow;

    if ($pagenow == 'edit.php' && isset($_GET['brand']) && !empty($_GET['brand'])) {
        $term = get_term_by('slug', $_GET['brand'], 'brand');
        if ($term) {
            $query->query_vars['tax_query'] = array(array(
                'taxonomy' => 'brand',
                'field' => 'term_id',
                'terms' => $term->term_id
            ));
        }
    }
}
