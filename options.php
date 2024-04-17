<?php
// Vérifier que le script est appelé depuis WordPress
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Ajouter la page d'options au menu d'administration
function galopins_add_admin_menu() {
    add_menu_page(
        'Galopins Plugin Settings',
        'Galopins Settings',
        'manage_options',
        'galopins_settings',
        'galopins_settings_page'
    );
}

add_action('admin_menu', 'galopins_add_admin_menu');

// Afficher la page des paramètres
function galopins_settings_page() {
    ?>
    <div class="wrap">
        <h1>Galopins Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('galopins_plugin_settings');
            do_settings_sections('galopins_plugin_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Initialiser les paramètres
function galopins_settings_init() {
    register_setting('galopins_plugin_settings', 'galopins_settings');

    add_settings_section(
        'galopins_plugin_page_section',
        __('Your section description', 'galopins'),
        'galopins_settings_section_callback',
        'galopins_plugin_settings'
    );

    add_settings_field(
        'galopins_text',
        __('Your Text', 'galopins'),
        'galopins_text_render',
        'galopins_plugin_settings',
        'galopins_plugin_page_section'
    );
}

add_action('admin_init', 'galopins_settings_init');
