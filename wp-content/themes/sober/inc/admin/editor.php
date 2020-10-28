<?php
/**
 * Editor customizer
 */

/**
 * Add dynmic style to editor.
 *
 * @param  string $mce
 * @return string
 */
function sober_editor_dynamic_styles( $mce ) {
    $styles = sober_typography_css();
    $styles = preg_replace( '/\s+/', ' ', $styles );
    $styles = str_replace( '"', '', $styles );

    if ( isset( $mce['content_style'] ) ) {
        $mce['content_style'] .= ' ' . $styles . ' ';
    } else {
        $mce['content_style'] = $styles . ' ';
    }

    return $mce;
}

add_filter( 'tiny_mce_before_init', 'sober_editor_dynamic_styles' );


/**
 * Enqueue editor styles for Gutenberg
 */
function sober_block_editor_styles() {
	// Add custom fonts.
	wp_enqueue_style( 'sober-fonts', sober_fonts_url() );

	// Block styles.
	wp_enqueue_style( 'sober-block-editor-style', get_theme_file_uri( '/css/editor-blocks.css' ) );

	wp_add_inline_style( 'sober-block-editor-style', sober_typography_css() );
}
add_action( 'enqueue_block_editor_assets', 'sober_block_editor_styles' );