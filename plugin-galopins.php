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
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action('admin_notices', 'eci_admin_notice_missing_main_plugin');
        return;
    }
    
    include_once('includes/main-class.php');
}
add_action( 'plugins_loaded', 'eci_load_plugin' );

function eci_admin_notice_missing_main_plugin() {
    if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
    $message = sprintf(
        esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-content-integrator' ),
        '<strong>' . esc_html__( 'Elementor Content Integrator', 'elementor-content-integrator' ) . '</strong>',
        '<strong>' . esc_html__( 'Elementor', 'elementor-content-integrator' ) . '</strong>'
    );
    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
}
