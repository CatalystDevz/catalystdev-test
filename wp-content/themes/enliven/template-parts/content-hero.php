<?php 

	$enl_image_url = enliven_get_header_image();

?>

<?php if( $enl_image_url ) { ?>
	<div class="hero-container img-banner" style="background-image: url(<?php echo esc_url( $enl_image_url ); ?>);">
	<div class="overlay"></div>
<?php } else { ?>
	<div class="hero-container nrml-banner">
<?php } ?>

		<div class="hero-wrapper">
			<h1 class="page-title-hero"><?php the_title() ?></h1>
		</div>

	</div><!-- .hero-container -->