<?php
// If uninstall is not called from WordPress, exit
if (! defined('WP_UNINSTALL_PLUGIN') ) {
    exit;
}

global $wpdb;
$table_name = $wpdb->prefix . '2chat_button_generator';

$wpdb->query("DROP TABLE IF EXISTS $table_name");
?>