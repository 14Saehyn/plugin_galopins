<?php
/*
Plugin Name: Galopins
Description: Un plugin pour intégrer du contenu texte et des images dans des modèles Elementor.
Version: 1.0
Author: Théo FACORAT
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Inclure le widget Elementor
function galopins_include_widgets() {
    if (did_action('elementor/loaded')) {
        require_once('custom-widget-elementor.php');
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_Custom_Widget());
    }
}

add_action('elementor/widgets/widgets_registered', 'galopins_include_widgets');

// Ajouter une page de réglages au menu d'administration
function galopins_add_admin_menu() {
    add_menu_page(
        __('Galopins Settings', 'text-domain'), 
        'Galopins', 
        'manage_options', 
        'galopins-settings', 
        'galopins_options_page', 
        'dashicons-admin-post'
    );
}

add_action('admin_menu', 'galopins_add_admin_menu');

// Afficher la page des options
function galopins_options_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('galopins_plugin_settings');
            do_settings_sections('galopins_plugin_settings');
            submit_button(__('Save Settings', 'text-domain'));
            ?>
        </form>
    </div>
    <?php
}

// Inclure les options si nous sommes dans l'admin
if (is_admin()) {
    require_once('options.php');
}
