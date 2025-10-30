<?php
/**
 * Plugin Name:     UD Block: Tag-basierte Links
 * Description:     Block zur Auswahl einer Zielseite und bestimmter Tags. Im Frontend werden automatisch alle Link-Blöcke angezeigt, die mit diesen Tags versehen sind.
 * Version:         1.0.0
 * Author:          ulrich.digital gmbh
 * Author URI:      https://ulrich.digital/
 * License:         GPL v2 or later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     tag-basierte-links-ud
 */


defined('ABSPATH') || exit;

// Aktivierung blockieren, falls ud-shared-api nicht aktiv ist
register_activation_hook(__FILE__, 'tag_basierte_links_ud_activate');

function tag_basierte_links_ud_activate() {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');

    if (!is_plugin_active('ud-shared-api/ud-shared-api.php')) {
        wp_die(
            __('Aktivierung fehlgeschlagen: Das Plugin "Tag-basierte Links" benötigt "ud-shared-api". Bitte aktiviere zuerst "ud-shared-api".', 'tag-basierte-links-ud'),
            __('Plugin-Aktivierung abgebrochen', 'tag-basierte-links-ud'),
            ['back_link' => true]
        );
    }
}

// Laufzeitprüfung: Falls ud-shared-api deaktiviert wurde
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

if (!is_plugin_active('ud-shared-api/ud-shared-api.php')) {
    add_action('admin_notices', function () {
        echo '<div class="notice notice-error"><p>';
        echo esc_html__('Das Plugin "Tag-basierte Links" benötigt das Plugin "ud-shared-api", um korrekt zu funktionieren. Bitte aktiviere es zuerst.', 'tag-basierte-links-ud');
        echo '</p></div>';
    });
    return;
}

// Plugin-Funktionalitäten laden
foreach ([
    'helpers.php',
    // 'api.php',
    'render.php',
    'block-register.php',
    'enqueue.php'
] as $file) {
    require_once __DIR__ . '/includes/' . $file;
}
