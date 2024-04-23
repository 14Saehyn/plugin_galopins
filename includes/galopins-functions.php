<?php
function galopins_insert_event($data) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'galopins_events';

    $result = $wpdb->insert($table_name, array(
        'event_name' => sanitize_text_field($data['event_name']),
        'event_description' => sanitize_textarea_field($data['event_description']),
        'event_date' => sanitize_text_field($data['event_date']) // Assure-toi que la date est au format YYYY-MM-DD HH:MM:SS
    ));

    if ($result) {
        return $wpdb->insert_id; // Retourne l'ID de l'événement inséré
    } else {
        return false;
    }
}

function galopins_get_events() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'galopins_events';
    return $wpdb->get_results("SELECT * FROM $table_name");
}

function galopins_get_event_by_date($date) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'galopins_events';
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE event_date = %s", $date));
}