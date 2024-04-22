<?php
// Inclusion de la classe WP_List_Table si nécessaire
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Galopins_Reviews_List_Table extends WP_List_Table {
    public function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        global $wpdb;
        $table_name = $wpdb->prefix . 'galopins';
        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page
        ]);

        $this->items = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table_name ORDER BY review_date DESC LIMIT %d OFFSET %d;",
            $per_page,
            ($current_page - 1) * $per_page
        ), ARRAY_A);
    }

    public function get_columns() {
        return array(
            'cb'           => '<input type="checkbox" />',
            'client_name'  => 'Nom du client',
            'company_name' => 'Entreprise',
            'rating'       => 'Note',
            'review'       => 'Avis',
            'review_date'  => 'Date'
        );
    }

    public function column_default($item, $column_name) {
        switch ($column_name) {
            case 'client_name':
            case 'company_name':
            case 'review':
                // Utilise wp_unslash pour retirer les barres obliques inversées
                return wp_unslash(esc_html($item[$column_name]));
            default:
                // Pour toutes les autres colonnes, retourne la valeur telle quelle
                return isset($item[$column_name]) ? esc_html($item[$column_name]) : '';
        }
    }

    public function column_cb($item) {
        return sprintf('<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']);
    }

    public function get_bulk_actions() {
        $actions = array(
            'bulk-delete' => 'Supprimer'
        );
        return $actions;
    }

    public function process_bulk_action() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'galopins';
    
        if ('bulk-delete' === $this->current_action()) {
            // Sécurise l'entrée en s'assurant que chaque ID est un entier
            $delete_ids = array_map('intval', $_POST['bulk-delete']);
    
            // Vérifie si des éléments ont été sélectionnés
            if (count($delete_ids) > 0) {
                // Prépare la requête avec des placeholders pour les IDs
                $placeholders = implode(', ', array_fill(0, count($delete_ids), '%d'));
    
                // Prépare la requête SQL pour supprimer les avis
                $query = "DELETE FROM $table_name WHERE id IN ($placeholders)";
    
                // Exécute la requête en utilisant wpdb::prepare pour sécuriser les variables
                $wpdb->query($wpdb->prepare($query, $delete_ids));
    
                // Affiche un message pour informer l'utilisateur de la réussite de la suppression
                echo '<div class="updated"><p>Les avis sélectionnés ont été supprimés.</p></div>';
            }
        }
    }
}
