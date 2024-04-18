<?php
// La classe s'occupant de l'installation
class Galopins_Installer {
    public static function install() {
        register_activation_hook(__FILE__, 'galopins_install');
        
        function galopins_install() {
            global $wpdb;
            $table_name = $wpdb->prefix . "galopins";
        
            $charset_collate = $wpdb->get_charset_collate();
        
            $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                client_name tinytext NOT NULL,
                company_name tinytext NOT NULL,
                rating tinyint NOT NULL,
                review text NOT NULL,
                review_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";
        
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }
}
