<?php

/**
 *	Generate modal styling based on customizer settings
 *	Since not much CSS is generated, add it to the head
 */
add_action( 'wp_head', 'after_comment_prompts_customizer_output' );
function after_comment_prompts_customizer_output() { ?>
<style>
.popup_background {
	<?php
		if ( $overlay = get_theme_mod( 'acp_customizer_modal_overlay_color' ) )
			printf( 'background-color: %s !important;', $overlay );

		if ( $opacity = get_theme_mod( 'acp_customizer_modal_overlay_opacity' ) )
			printf( 'opacity: %s !important;', $opacity );
	?>
}
.comment-prompt-modal-wrap{
	<?php 
		if ( $modal_bg = get_theme_mod( 'acp_customizer_modal_background_color' ) )
			printf( 'background-color: %s !important;', $modal_bg, get_theme_mod( 'acp_customizer_modal_width' ) . 'px' );

		if ( $modal_width = get_theme_mod( 'acp_customizer_modal_width' ) )
			printf( 'max-width: %s !important;', $modal_width . 'px' );
	?>
}
.popupoverlay-close {
	<?php 
		if ( $close_color = get_theme_mod( 'acp_customizer_modal_close_color' ) )
			printf( 'color: %s !important;', $close_color );
	?>
}
</style>
<?php }