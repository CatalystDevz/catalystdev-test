<?php
/**
 * Writes out the CSS as defined by the values in the Theme Options Panel
 * to the `head` element of the header template.
 *
 * @package awaken
 * @since Awaken Pro 2.0
 */
function enliven_custom_styles() {

	$styles = '';

	$main_color = get_theme_mod( 'site_main_color', '#ea7054' );

	if ( $main_color != '#ea7054' ) {

		$styles .= 'blockquote {
					  border-left: 5px solid '. esc_attr( $main_color ) .';
					}

					.enl-widget a:hover,
					.enl-pb-widget-area .widget_recent_entries a:hover,
					.enl-pb-widget-area .widget_pages a:hover,
					.enl-pb-widget-area .widget_archive a:hover,
					.enl-pb-widget-area .widget_categories a:hover,
					.enl-pb-widget-area .widget_meta a:hover,
					.enl-pb-widget-area .widget_recent_comments a:hover,
					.enl-pb-widget-area .widget_nav_menu a:hover,
					.enl-pb-widget-area .widget_nav_menu a:hover,
					.enl-block-icon,
					.enl-fp-title a:hover,
					.enl-bpw-title a:hover,
					.enl-port-icon,
					.enl-tst-plcehldr,
					.normal-header a:hover,
					.sticky-nav a:hover,
					.arc-entry-title a:hover,
					.entry-meta a:hover,
					.cat-links a:hover,
					.tags-links a:hover,
					.arc-entry-meta a:hover,
					.enl-gp-title a:hover,
					.comment-author .fn,
					.comment-author .url,
					.comment-reply-link,
					.comment-reply-login {
						color: '. esc_attr( $main_color ) .';
					}';

	}

	$btn_bg_color = get_theme_mod( 'button_background_color', '#325edd' );
	$btn_hover_bg_color = get_theme_mod( 'button_background_hover_color', '#153DB0' );
	$btn_text_color = get_theme_mod( 'button_text_color', '#ffffff' );
	$btn_hover_text_color = get_theme_mod( 'button_text_hover_color', '#ffffff' );

	$styles .= '

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"] {
		  background-color: '. esc_attr($btn_bg_color) .';
		  color: '. esc_attr($btn_text_color) .';
		}
		button:hover,
		input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover {
		  background-color: '. esc_attr($btn_hover_bg_color) .';
		  color: '. esc_attr($btn_hover_text_color) .';
		}
		button:active, button:focus,
		input[type="button"]:active,
		input[type="button"]:focus,
		input[type="reset"]:active,
		input[type="reset"]:focus,
		input[type="submit"]:active,
		input[type="submit"]:focus {
		  color: '. esc_attr($btn_hover_text_color) .';
		}

		.enl-cta-btn {
		  background-color: '. esc_attr($btn_bg_color) .';
		  color: '. esc_attr($btn_text_color) .';
		}

		.enl-cta-btn:active {
		  color: '. esc_attr($btn_hover_text_color) .';
		}

		.enl-cta-btn:visited {
		  color: '. esc_attr($btn_text_color) .';
		}

		.enl-cta-btn:hover {
		  background-color: '. esc_attr($btn_hover_bg_color) .';
		  color: '. esc_attr($btn_hover_text_color) .';
		}

		.enl-slide-btn-1 {
		  background-color: '. esc_attr($btn_bg_color) .';
		  color: '. esc_attr($btn_text_color) .';
		}

		.enl-slide-btn-1:visited {
		  color: '. esc_attr($btn_text_color) .';
		}

		.enl-slide-btn-1:hover {
		  background-color: '. esc_attr($btn_hover_bg_color) .';
		  color: '. esc_attr($btn_hover_text_color) .';
		}

		.enl-slide-btn-1:active {
		  color: '. esc_attr($btn_hover_text_color) .';
		}

	';

	$customizer_styles = preg_replace('/\s+/', ' ', $styles);

	wp_add_inline_style( 'enliven-styles', $customizer_styles );

}

add_action( 'wp_enqueue_scripts', 'enliven_custom_styles' );