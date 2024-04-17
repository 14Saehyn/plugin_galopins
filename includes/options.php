<?php
if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'galopins_add_admin_menu');

// Ajoutez un élément de menu à la barre latérale de l'administration
function galopins_add_admin_menu() {
    add_menu_page(
        'Galopins Content Settings',          // Titre de la page
        'Galopins',                            // Titre du menu
        'galopins_content_settings',           // Slug du menu
        'galopins_content_settings_page',      // Fonction pour afficher la page de contenu
        'dashicons-admin-post',                // Icône du menu
        6                                      // Position dans le menu
    );
}

// Afficher la page des paramètres pour ajouter du contenu
function galopins_content_settings_page() {
    ?>
    <div class="wrap">
        <h1>Ajouter du Contenu</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('galopins_content_settings');
            do_settings_sections('galopins_content_settings');
            submit_button('Sauvegarder le Contenu');
            ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'galopins_content_settings_init');

// Initialisation des réglages
function galopins_content_settings_init() {
    register_setting('galopins_content_settings', 'galopins_content');

    add_settings_section(
        'galopins_content_section',
        __('Configurez votre contenu', 'galopins'),
        'galopins_content_section_callback',
        'galopins_content_settings'
    );

    add_settings_field(
        'galopins_title',
        __('Titre', 'galopins'),
        'galopins_title_render',
        'galopins_content_settings',
        'galopins_content_section'
    );

    add_settings_field(
        'galopins_text',
        __('Texte', 'galopins'),
        'galopins_text_render',
        'galopins_content_settings',
        'galopins_content_section'
    );

    add_settings_field(
        'galopins_image',
        __('Image', 'galopins'),
        'galopins_image_render',
        'galopins_content_settings',
        'galopins_content_section'
    );
}

function galopins_content_section_callback() {
    echo 'Entrez les détails de votre contenu ici.';
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

// JavaScript pour le téléchargeur d'image
function galopins_admin_scripts() {
    ?>
    <script>
    function upload_image(button) {
        var frame = wp.media({
            title: 'Sélectionner ou uploader votre image',
            button: {
                text: 'Utiliser cette image'
            },
            multiple: false
        });

        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            jQuery(button).prev().val(attachment.url);
        });

        frame.open();
    }
    </script>
    <?php
}
