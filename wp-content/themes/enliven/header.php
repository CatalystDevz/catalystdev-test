<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Enliven
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'enliven' ); ?></a>

    <?php do_action('enliven_before_header'); ?>

	<header id="masthead" class="site-header <?php echo enliven_header_class(); ?>" role="banner">
        <div class="container">
            <div class="row">
                <div class="col-xs-10 col-md-4 col-lg-4">
                    <div class="site-branding">
                        <?php  
                        
                            $logo = get_theme_mod( 'site_logo', '' );
                            $title_option = get_theme_mod( 'site_title_option', 'text-only' );

                            if ( $title_option == 'logo-only' && ! empty($logo) ) { ?>
                                <div class="site-logo">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
                                </div>
                            <?php } 

                            if ( $title_option == 'text-logo' && ! empty($logo) ) { ?>
                                <div class="site-logo">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
                                </div>
                                <div class="site-title-text">
                                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                    <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
                                </div>
                            <?php } 

                            if ( $title_option == 'text-only' ) { ?>
                                <div class="site-title-text">
                                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                    <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
                                </div>

                        <?php } ?>
                    </div><!-- .site-branding -->
                </div><!-- .bootstrap-cols -->
                <div class="col-xs-2 col-md-8 col-lg-8">
                    <nav id="site-navigation" class="main-navigation" role="navigation">
                        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
                    </nav><!-- #site-navigation -->
                    <a href="#" class="navbutton" id="main-nav-button"></a>
                </div><!-- .bootstrap-cols -->
            </div><!-- .row -->
        </div><!-- .container -->
	</header><!-- #masthead -->
        <div class="responsive-mainnav-outer">
        <div class="responsive-mainnav container"></div>
    </div>

    <?php do_action('enliven_after_header'); ?>

    <?php 
        enliven_header_background();
    ?>

	<div id="content" class="site-content">