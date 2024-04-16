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

function eci_load_plugin() {
    include_once('includes/main-class.php');
}

add_action('plugins_loaded', 'eci_load_plugin', 100); // Priorité élevée pour s'assurer que cela se charge après Elementor

function eci_register_widgets() {
    // Vérifiez si Elementor est chargé et actif.
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action('admin_notices', 'eci_admin_notice_missing_main_plugin');
        return;
    }

    // Charge et enregistre le widget
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Custom_Widget());
}

add_action('elementor/init', 'eci_register_widgets'); // Utilisez `elementor/init` pour enregistrer des widgets

function eci_admin_notice_missing_main_plugin() {
    if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
    $message = sprintf(
        esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-content-integrator' ),
        '<strong>' . esc_html__( 'Elementor Content Integrator', 'elementor-content-integrator' ) . '</strong>',
        '<strong>' . esc_html__( 'Elementor', 'elementor-content-integrator' ) . '</strong>'
    );
    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
}
