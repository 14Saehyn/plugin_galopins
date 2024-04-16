<?php
/*
Plugin Name: Galopins
Description: Un plugin pour intégrer du contenu texte et des images dans des modèles Elementor.
Version: 1.0
Author: Théo FACORAT
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Fonction pour initialiser le plugin
function galopins_init_plugin() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        // Elementor n'est pas chargé, affiche une notification d'erreur.
        add_action('admin_notices', 'galopins_missing_elementor_notice');
        return;
    }

    // Elementor est chargé, inclure le widget
    require_once('includes/main-class.php');
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_Custom_Widget());
}

add_action('init', 'galopins_init_plugin');  // Utiliser le hook 'init' pour lancer le plugin

// Affiche une notice si Elementor n'est pas activé
function galopins_missing_elementor_notice() {
    $message = esc_html__('"Galopins" requires "Elementor" to be installed and activated.', 'text-domain');
    printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
}
