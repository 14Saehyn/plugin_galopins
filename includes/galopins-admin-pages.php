<?php
// Ajout du menu dans l'administration et d'autres fonctions liées aux pages admin
function galopins_menu() {
    add_menu_page('Galopins Plugin Settings', 'Galopins', 'administrator', 'galopins-settings', 'galopins_settings_page', 'dashicons-testimonial');
    add_submenu_page('galopins-settings', 'Ajouter un avis', 'Ajouter un avis', 'administrator', 'galopins-add', 'galopins_add_page');
    add_submenu_page('galopins-settings', 'Voir les avis', 'Voir les avis', 'administrator', 'galopins-view', 'galopins_view_page');
}

// Tableau de bord
function galopins_settings_page() {
    ?>
    <div class="wrap">
        <h1>Tableau de bord - Galopins</h1>
        <p>Paramètres du plugin Galopins</p>
    </div>
    <?php
}

function galopins_add_page() {
    global $wpdb;

    // Vérification de la méthode POST et du nonce
    if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['action']) && $_POST['action'] == 'add_review') {
        if (check_admin_referer('add_review_nonce')) {
            // $wpdb->show_errors();  // Activer l'affichage des erreurs SQL
            
            $result = $wpdb->insert($wpdb->prefix . 'galopins', array(
                'client_name' => sanitize_text_field($_POST['client_name']),
                'company_name' => sanitize_text_field($_POST['company_name']),
                'rating' => intval($_POST['rating']),
                'review' => sanitize_textarea_field($_POST['review']),
                'review_date' => sanitize_text_field($_POST['review_date'])
            ));

            $wpdb->print_error();  // Afficher les erreurs SQL

            if ($result) {
                echo '<div class="updated"><p>Avis ajouté avec succès.</p></div>';
            } else {
                echo '<div class="error"><p>Erreur lors de l\'ajout de l\'avis.</p></div>';
            }
        }
    }

    // Formulaire d'ajout
    ?>
    <div class="wrap">
        <h2>Ajouter un témoignage</h2>
        <form method="post" action="">
            <?php wp_nonce_field('add_review_nonce'); ?>
            <input type="hidden" name="action" value="add_review">
            <table class="form-table">
                <tr valign="top">
                <th scope="row">Nom du client</th>
                <td><input type="text" name="client_name" required /></td>
                </tr>
                
                <tr valign="top">
                <th scope="row">Entreprise</th>
                <td><input type="text" name="company_name" required /></td>
                </tr>

                <tr valign="top">
                <th scope="row">Note</th>
                <td><input type="number" name="rating" required /></td>
                </tr>

                <tr valign="top">
                <th scope="row">Avis</th>
                <td><textarea name="review" required></textarea></td>
                </tr>

                <tr valign="top">
                <th scope="row">Date</th>
                <td><input type="date" name="review_date" required /></td>
                </tr>
            </table>
            
            <?php submit_button('Ajouter un avis'); ?>
        </form>
    </div>
    <?php
}

function galopins_view_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'galopins';

    $list_table = new Galopins_Reviews_List_Table();
    // Handle bulk actions
    $list_table->process_bulk_action();

    // Vérifie si l'action de suppression a été demandée
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && !empty($_GET['review'])) {
        // Vérifier le nonce
        $nonce = esc_attr($_REQUEST['_wpnonce']);
        if (!wp_verify_nonce($nonce, 'galopins_delete_review')) {
            die('Go get a life script kiddies');
        }
        else {
            // Suppression de l'avis
            $review_id = absint($_GET['review']);
            $wpdb->delete($table_name, array('id' => $review_id), array('%d'));
        }
    }

    $list_table = new Galopins_Reviews_List_Table();
    $list_table->prepare_items();
    ?>
    <div class="wrap">
        <h2>Liste des avis</h2>
        <form method="post">
            <?php $list_table->display(); ?>
        </form>
    </div>
    <?php
}