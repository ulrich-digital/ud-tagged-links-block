<?php
defined('ABSPATH') || exit;

function ud_tag_basierte_links_render_callback($attributes, $content, $block) {

    if (!isset($attributes['selectedPageId'], $attributes['selectedTags']) || !is_array($attributes['selectedTags'])) {
        return '';
    }

    $target_page_id = intval($attributes['selectedPageId']);

    $selected_tags = array_map('sanitize_text_field', $attributes['selectedTags']);

    // Inhalt der Seite laden
    $blocks = parse_blocks(get_post_field('post_content', $target_page_id));
    $matching_blocks = ud_tag_links_extract_matching_link_blocks($blocks, $selected_tags);

    if (empty($matching_blocks)) {
        return '<div class="ud-tagged-links-block__no-matches">Keine passenden Links gefunden.</div>';
    }

    //$output = '<div class="ud-tagged-links-block">';

$output = "";
    foreach ($matching_blocks as $block) {
        $output .= render_block($block);
    }
    //$output .= '</div>';
error_log($output);
    return $output;
}

// Block-Array rekursiv nach passenden ud-link-blocks filtern
function ud_tag_links_extract_matching_link_blocks($blocks, $selected_tags) {

    $matches = [];

    foreach ($blocks as $block) {

        if ($block['blockName'] === 'ud/link-block') {
            $block_tags = $block['attrs']['item']['tags'] ?? [];

            if (!empty(array_intersect($block_tags, $selected_tags))) {
                $matches[] = $block;
            }
        }

        // Rekursion bei verschachtelten Blocks
        if (!empty($block['innerBlocks'])) {
            $matches = array_merge(
                $matches,
                ud_tag_links_extract_matching_link_blocks($block['innerBlocks'], $selected_tags)
            );
        }
    }

    return $matches;
}
