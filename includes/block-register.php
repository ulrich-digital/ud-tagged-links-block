<?php
/**
 * Register the custom block
 */

defined('ABSPATH') || exit;

add_action('init', function () {
	register_block_type_from_metadata(__DIR__ . '/../', [
		'render_callback' => 'ud_tag_basierte_links_render_callback',
	]);
});