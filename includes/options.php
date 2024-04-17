<?php
if (!defined('ABSPATH')) {
    exit;
}

// Initialisation des réglages
function galopins_content_settings_init() {
    register_setting('galopins_plugin_settings', 'galopins_content');

    add_settings_section(
        'galopins_content_section',
        __('Configurez votre contenu', 'galopins'),
        'galopins_content_section_callback',
        'galopins_plugin_settings'
    );

    add_settings_field(
        'galopins_title',
        __('Titre', 'galopins'),
        'galopins_title_render',
        'galopins_plugin_settings',
        'galopins_content_section'
    );

    add_settings_field(
        'galopins_text',
        __('Texte', 'galopins'),
        'galopins_text_render',
        'galopins_plugin_settings',
        'galopins_content_section'
    );

    add_settings_field(
        'galopins_image',
        __('Image', 'galopins'),
        'galopins_image_render',
        'galopins_plugin_settings',
        'galopins_content_section'
    );
}

add_action('admin_init', 'galopins_content_settings_init');

function galopins_content_section_callback() {
    echo __('Entrez les détails de votre contenu ici.', 'galopins');
}

function galopins_title_render() {
    $options = get_option('galopins_content');
    ?>
    <input type="text" name="galopins_content[galopins_title]" value="<?php echo esc_attr($options['galopins_title'] ?? ''); ?>">
    <?php
}

function galopins_text_render() {
    $options = get_option('galopins_content');
    ?>
    <textarea name="galopins_content[galopins_text]"><?php echo esc_textarea($options['galopins_text'] ?? ''); ?></textarea>
    <?php
}

function galopins_image_render() {
    $options = get_option('galopins_content');
    ?>
    <input type="text" name="galopins_content[galopins_image]" value="<?php echo esc_url($options['galopins_image'] ?? ''); ?>">
    <button type="button" class="button" onclick="upload_image(this);">Choisir/Uploader Image</button>
    <?php
}

add_action('admin_footer', 'galopins_admin_scripts');  // Ajouter le script au footer de l'admin

// // JavaScript pour le téléchargeur d'image
// function galopins_admin_scripts() {
//     // Votre code JS pour le téléchargeur d'image
// }
