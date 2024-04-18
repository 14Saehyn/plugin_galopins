<?php
/**
 * Plugin Name: Galopins
 * Description: Permet d'insérer un titre, du contenu, et des images via une interface dans le backend de WordPress.
 * Version: 1.0
 * Author: Théo FACORAT
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Hook into the admin menu to add a new menu item
add_action('admin_menu', 'galopins_setup_menu');

function galopins_setup_menu(){
    add_menu_page('Galopins Plugin Page', 'Galopins', 'manage_options', 'galopins', 'galopins_init');
}

// The function that will render the admin page
function galopins_init(){
    ?>
    <div class="wrap">
        <h2>Galopins</h2>
        <form method="post" action="options.php">
            <?php
                settings_fields('galopins_options_group');
                do_settings_sections('galopins');
                submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register and define the settings
add_action('admin_init', 'galopins_admin_init');

function galopins_admin_init(){
    register_setting('galopins_options_group', 'galopins_options', 'galopins_options_validate');
    add_settings_section('galopins_main', 'Galopins Settings', 'galopins_section_text', 'galopins');
    add_settings_field('galopins_title', 'Title', 'galopins_setting_string', 'galopins', 'galopins_main');
    add_settings_field('galopins_content', 'Content', 'galopins_setting_content', 'galopins', 'galopins_main');
    add_settings_field('galopins_images', 'Images', 'galopins_setting_images', 'galopins', 'galopins_main');
}

function galopins_section_text() {
    echo '<p>Enter your settings here.</p>';
}

function galopins_setting_string() {
    $options = get_option('galopins_options');
    echo "<input id='galopins_title' name='galopins_options[title]' size='40' type='text' value='{$options['title']}' />";
}

function galopins_setting_content() {
    $options = get_option('galopins_options');
    echo "<textarea id='galopins_content' name='galopins_options[content]' rows='5' cols='40'>{$options['content']}</textarea>";
}

function galopins_setting_images() {
    $options = get_option('galopins_options');
    echo "<input id='galopins_images' name='galopins_options[images]' size='40' type='text' value='{$options['images']}' />";
    echo '<button onclick="galopins_open_media_window()">Add Image</button>';
    ?>
    <script>
        function galopins_open_media_window() {
            if (wp.media && wp.media.editor) {
                wp.media.editor.open();
                return false;
            }
        }
    </script>
    <?php
}

function galopins_options_validate($input) {
    $newinput['title'] = trim($input['title']);
    $newinput['content'] = trim($input['content']);
    $newinput['images'] = trim($input['images']);
    return $newinput;
}
