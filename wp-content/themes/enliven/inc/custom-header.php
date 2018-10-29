<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Enliven
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses enliven_header_style()
 */
function enliven_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'enliven_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '',
		'width'                  => 1920,
		'height'                 => 800,
		'flex-height'            => true,
		'default-image' 		 => get_template_directory_uri() . '/images/header.jpg'
	) ) );
}
add_action( 'after_setup_theme', 'enliven_custom_header_setup' );

/**
 * Header featured content.
 */
function enliven_featured_content() {

	/*if( is_home() && is_paged() ) {
		return false;
	} */

	?>
	
	<div class="enl-featured-container">
		<div class="overlay"></div>
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
		<div class="enl-featured-inner">

			<div class="enl-featured-content">

			<?php
				$header_title = get_theme_mod( 'header_title', 'Welcome to Enliven' );
				$header_desc = get_theme_mod( 'header_description', 'The Ultimate Business WordPress Theme.' );
				$first_button_text = get_theme_mod( 'header_btn_one_text', 'Download' );
				$second_button_text = get_theme_mod( 'header_btn_two_text', 'Preview' );
				$first_button_url = get_theme_mod( 'header_btn_one_url', '#' );
				$second_button_url = get_theme_mod( 'header_btn_two_url', '#' );
			?>

			<?php if ( ! empty( $header_title ) ) : ?>

				<h1 class="enl-fcontent-title"><?php echo esc_html($header_title); ?></h1>

			<?php endif; ?>

			<?php if ( ! empty( $header_desc ) ) : ?>
			
				<div class="enl-fcontent-details">
					<?php echo wp_kses_post( $header_desc ); ?>
				</div>

			<?php endif; ?>

			<?php if ( ! empty( $first_button_text ) ) : ?>

				<a class="enl-slide-btn-1" href="<?php echo esc_url( $first_button_url ); ?>"><?php echo esc_html( $first_button_text ) ?></a>

			<?php endif; ?>

			<?php if ( ! empty( $second_button_text ) ) : ?>

				<a class="enl-slide-btn-2" href="<?php echo esc_url( $second_button_url ); ?>"><?php echo esc_html( $second_button_text ) ?></a>

			<?php endif; ?>

			</div><!-- .enl-featured-content -->
		
		</div><!-- .enl-featured-inner -->

	</div><!-- .enl-featured-container -->

<?php
}