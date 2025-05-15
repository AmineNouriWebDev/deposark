<?php

// Gestion de l'inscription (version corrigée)
add_action('wp_ajax_newsletter_subscription', 'handle_newsletter_subscription');
add_action('wp_ajax_nopriv_newsletter_subscription', 'handle_newsletter_subscription');

function handle_newsletter_subscription()
{
    global $wpdb;

    // Debug : Vérifier la réception des données
    error_log(print_r($_POST, true));

    // 1. Vérification du nonce
    if (!isset($_POST['newsletter_security']) || !wp_verify_nonce($_POST['newsletter_security'], 'newsletter_nonce')) {
        error_log('Erreur Nonce');
        wp_send_json_error('Erreur de sécurité. Rafraîchissez la page.');
        return;
    }

    // 2. Validation de l'email (corrigé)
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

    if (empty($email)) {
        error_log('Email vide');
        wp_send_json_error('L\'email est requis');
        return;
    }

    if (!is_email($email)) {
        error_log('Email invalide : ' . $email);
        wp_send_json_error('Format d\'email invalide (ex: nom@domaine.com)');
        return;
    }

    // 3. Vérification de la table
    $table = $wpdb->prefix . 'newsletter_subscribers';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
        error_log('Table inexistante : ' . $table);
        wp_send_json_error('Erreur technique. Contactez l\'administrateur.');
        return;
    }

    // 4. Vérification des doublons
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT email FROM $table WHERE email = %s",
        $email
    ));

    if ($exists) {
        error_log('Doublon détecté : ' . $email);
        wp_send_json_error('Cet email est déjà inscrit');
        return;
    }

    // 5. Insertion (avec vérification améliorée)
    $result = $wpdb->insert($table, [
        'email' => $email,
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'subscription_date' => current_time('mysql'),
        'status' => 'subscribed'
    ], ['%s', '%s', '%s', '%s']); // Formats explicites

    if (false === $result) {
        error_log('Erreur DB : ' . $wpdb->last_error);
        wp_send_json_error('Erreur technique lors de l\'inscription');
        return;
    }

    error_log('Inscription réussie : ' . $email);
    wp_send_json_success('Merci ! Vous êtes maintenant inscrit.');
}
function newsletter_scripts()
{
    wp_enqueue_script(
        'newsletter-ajax',
        get_template_directory_uri() . '/js/newsletter.js',
        array('jquery'),
        filemtime(get_template_directory() . '/js/newsletter.js'),
        true
    );

    wp_localize_script('newsletter-ajax', 'newsletter_ajax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('newsletter_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'newsletter_scripts');


// Gestion du formulaire de contact
add_action('wp_ajax_contact_form', 'handle_contact_form');
add_action('wp_ajax_nopriv_contact_form', 'handle_contact_form');

function handle_contact_form()
{
    global $wpdb;

    // Vérification nonce
    check_ajax_referer('contact_form_nonce', 'security');

    // Validation
    $errors = [];
    if (empty($_POST['name'])) $errors[] = 'Nom requis';
    if (!is_email($_POST['email'])) $errors[] = 'Email invalide';
    if (!empty($errors)) {
        wp_send_json_error(implode('<br>', $errors));
        return;
    }

    // Données
    $data = [
        'name'    => sanitize_text_field($_POST['name']),
        'email'   => sanitize_email($_POST['email']),
        'phone'   => sanitize_text_field($_POST['phone'] ?? ''),
        'subject' => sanitize_text_field($_POST['subject'] ?? 'Aucun sujet'),
        'message' => sanitize_textarea_field($_POST['message']),
        'ip'      => $_SERVER['REMOTE_ADDR']
    ];

    // Insertion DB
    $result = $wpdb->insert("{$wpdb->prefix}contact_submissions", $data);

    if (false === $result) {
        error_log('DB Error: ' . $wpdb->last_error);
        wp_send_json_error('Erreur database');
        return;
    }

    // Email
    $headers = ['Content-Type: text/html; charset=UTF-8'];
    $email_body = "Nouveau contact:<br><br>" . print_r($data, true);

    wp_mail(
        get_option('admin_email'),
        'Nouveau message de contact',
        $email_body,
        $headers
    );

    wp_send_json_success('Message envoyé !');
}

// Création table
function create_contact_table()
{
    global $wpdb;
    $table = $wpdb->prefix . 'contact_submissions';

    $sql = "CREATE TABLE $table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        subject VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        ip VARCHAR(45) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) CHARSET=utf8mb4;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_contact_table');
function enqueue_contact_scripts()
{
    if (is_page('contact')) {
        wp_enqueue_script('contact-js', get_theme_file_uri('/js/contact.js'), ['jquery'], null, true);

        // Correction : Passer un tableau avec les données
        wp_localize_script('contact-js', 'contact_ajax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('contact_form_nonce') //  Ajoutez le nonce
        ]);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_contact_scripts');
// Supprimer jQuery Migrate
add_action('wp_default_scripts', function ($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
});
