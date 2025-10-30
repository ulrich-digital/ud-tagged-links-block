<?php
/**
 * Enqueue styles and scripts for block editor and frontend
 */

defined('ABSPATH') || exit;

add_action('enqueue_block_assets', function () {
	wp_localize_script(
		'ud-tagged-links-block-editor-script', // exakt wie in webpack & block.json
		'udTagLinkSettings',
		[
			'nonce' => wp_create_nonce('wp_rest'),
		]
	);
});

