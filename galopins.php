<?php
/*
Plugin Name: Galopins
Plugin URI: https://agencegalopins.com/
Description: Centralisation des témoignages des clients.
Version: 1.0
Author: Agence Galopins
Author URI: https://agencegalopins.com/
*/

// Inclusion des fichiers nécessaires
require_once plugin_dir_path(__FILE__) . 'includes/class-galopins-installer.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-galopins-reviews-list-table.php';
require_once plugin_dir_path(__FILE__) . 'includes/galopins-admin-pages.php';
require_once plugin_dir_path(__FILE__) . 'includes/galopins-functions.php';

// Hook pour l'activation du plugin
register_activation_hook(__FILE__, array('Galopins_Installer', 'install'));

// Ajout du menu dans l'administration
add_action('admin_menu', 'galopins_menu');
