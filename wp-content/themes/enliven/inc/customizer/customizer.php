<?php
/**
 * Enliven Theme Customizer
 *
 * @package Enliven
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function enliven_customize_register( $wp_customize ) {

    require( get_template_directory() . '/inc/customizer/custom-controls/control-custom-content.php' );

    $wp_customize->remove_section( 'themes' );
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $wp_customize->get_section( 'colors' )->panel               = 'enliven_theme_styling';
    $wp_customize->get_section( 'background_image' )->panel     = 'enliven_theme_styling';
    $wp_customize->get_section( 'header_image' )->panel         = 'enliven_header_panel';
    $wp_customize->remove_control( 'header_textcolor' );


    $wp_customize->add_section(
        'enliven_general_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'General Settings', 'enliven' )
        )
    );

    // Footer copyright text.
    $wp_customize->add_setting(
        'footer_copyright_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'enliven_sanitize_html'
        )
    );
    $wp_customize->add_control(
        'footer_copyright_text',
        array(
            'settings'      => 'footer_copyright_text',
            'section'       => 'enliven_general_settings',
            'type'          => 'textarea',
            'label'         => __( 'Footer copyright text', 'enliven' ),
            'description'   => __( 'Copyright or other text to be displayed in the site footer. HTML allowed.', 'enliven' )
        )
    );

    /*$wp_customize->add_setting(
        'enliven_custom_excerpt_length',
        array (
            'default'           => '25',
            'sanitize_callback' => 'esc_attr',
            'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control(
        'enliven_custom_excerpt_length',
        array (
            'label'         => __( 'Excerpt length', 'enliven' ),
            'section'       => 'enliven_general_settings',
            'priority'      => 3,
            'type'          => 'text',
        )
    );*/

    /*$wp_customize->add_setting(
        'enliven_menu_type',
        array(
            'default'           => 'sticky-menu',
            'sanitize_callback' => 'enliven_sanitize_menu_type',
            'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control(
        'enliven_menu_type',
        array(
            'label'     => __( 'Select the menu type.', 'enliven' ),
            'section'   => 'enliven_general_settings',
            'priority'  => 1,
            'type'      => 'radio',
            'choices'   => array (
                'sticky-menu' => __( 'Sticky Menu', 'enliven' ),
                'normal-menu' => __( 'Normal Menu', 'enliven' )
            )
        )
    );*/
    
    // Logo image
    $wp_customize->add_setting(
        'site_logo',
        array(
            'sanitize_callback' => 'enliven_sanitize_image'
        ) 
    ); 
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo',
            array(
                'label'         => __( 'Site Logo', 'enliven' ),
                'section'       => 'title_tagline',
                'settings'      => 'site_logo',
                'description'   => __( 'Upload a logo for your website. Recommended height for your logo is 120px.', 'enliven' ),
            )
        )
    );

    // Logo, title and description chooser
    $wp_customize->add_setting(
        'site_title_option',
        array(
            'default'           => 'text-only',
            'sanitize_callback' => 'enliven_sanitize_select',
            'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control(
        'site_title_option',
        array(
            'label'         => __( 'Display site title / logo.', 'enliven' ),
            'section'       => 'title_tagline',
            'type'          => 'radio',
            'description'   => __( 'Choose your preferred option.', 'enliven' ),
            'choices'   => array (
                'text-only'     => __( 'Display site title and description only.', 'enliven' ),
                'logo-only'     => __( 'Display site logo image only.', 'enliven' ),
                'text-logo'     => __( 'Display both site title and logo image.', 'enliven' ),
                'display-none'  => __( 'Display none', 'enliven' )
            )
        )
    );

    /**
     * Header Panel
     */
    $wp_customize->add_panel (
        'enliven_header_panel',
        array(
            'priority'      => 30,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'Header Settings', 'enliven' ),
            'description'   => __( 'Use this panel to set your header area settings', 'enliven' )
        )
    );

    $wp_customize->add_section ( 
        'enliven_header_type_select', 
        array(
            'title'     => __( 'Header Type.', 'enliven' ),
            'panel'     => 'enliven_header_panel',
            'priority'  => 5
        ) 
    );

    $wp_customize->add_setting(
        'enliven_front_featured_header',
        array(
            'default'           => true,
            'transport'         => 'refresh',
            'sanitize_callback' => 'enliven_sanitize_checkbox'
        )
    );
    $wp_customize->add_control(
        'enliven_front_featured_header',
        array(
            'label'         => __( 'Activate header image with text on Static Front Page.', 'enliven' ),
            'description'   => __( '<br/><b>Note: This works only if slider is not active on frontpage.</b> If you need to activate the slider instead of header image with text on frontpage go to Customizer > Slider > Slider Settings.', 'enliven'),
            'section'       => 'enliven_header_type_select',
            'type'          => 'checkbox'
        )
    );

    /*$wp_customize->add_setting(
        'enliven_blog_featured_header',
        array(
            'default'           => true,
            'transport'         => 'refresh',
            'sanitize_callback' => 'enliven_sanitize_checkbox'
        )
    );
    $wp_customize->add_control(
        'enliven_blog_featured_header',
        array(
            'label'         => __( 'Activate header image with text on Blog Page.', 'enliven' ),
            'description'   => __( '<br/><b>Note: This works only if slider is not active on blog.</b> If you need to activate the slider instead of header image with text on blog go to Customizer > Slider > Slider Settings and mark "Activate Slider on blog".', 'enliven'),
            'section'       => 'enliven_header_type_select',
            'type'          => 'checkbox'
        )
    );*/

    // Main Page Header Type.
    $wp_customize->add_setting(
        'enliven_main_header_type',
        array(
            'default'           => 'alternate-image',
            'sanitize_callback' => 'enliven_sanitize_select',
            'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control(
        'enliven_main_header_type',
        array(
            'label'         => __( 'Page Header Type', 'enliven' ),
            'section'       => 'enliven_header_type_select',
            'type'          => 'radio',
            'description'   => __( 'Select the header type for all pages.', 'enliven' ),
            'choices'   => array (
                'header-image'      => __( 'Header Image.', 'enliven' ),
                'featured-image'    => __( 'Featured Image.', 'enliven' ),
                'alternate-image'   => __( 'Featured Image or Header Image.', 'enliven' ),
                'none'              => __( 'Only Menu', 'enliven' )
            )
        )
    );    

    $wp_customize->add_section ( 
        'enliven_header_content', 
        array(
            'title'     => __( 'Header Text.', 'enliven' ),
            'panel'     => 'enliven_header_panel',
            'priority'  => 5
        ) 
    );


    $wp_customize->add_setting(
        'header_title',
        array(
            'default'           => __( 'Welcome to Enliven', 'enliven' ),
            'sanitize_callback' => 'enliven_sanitize_text',
        )
    );

    $wp_customize->add_control(
        'header_title',
        array(
            'label'     => __( 'Header Title', 'enliven' ),
            'section'   => 'enliven_header_content',
            'type' => 'text',
        )
    );    

    $wp_customize->add_setting(
        'header_description',
        array(
            'default'            => __( 'The Ultimate Business WordPress Theme', 'enliven' ),
            'sanitize_callback'  => 'enliven_sanitize_textarea',
        )
    );

    $wp_customize->add_control(
        'header_description',
        array(
            'label'         => __( 'Header description.', 'enliven' ),
            'section'       => 'enliven_header_content',
            'type'          => 'textarea',
        )
    );   

    // Button 1 Text
    $wp_customize->add_setting(
        'header_btn_one_text',
        array(
            'default'           => __( 'Download', 'enliven' ),
            'sanitize_callback' => 'enliven_sanitize_text',
            'transport'         => 'refresh'
        )
    );    
    
    $wp_customize->add_control(
        'header_btn_one_text',
        array(
            'label'         => __( 'First button text.', 'enliven' ),
            'section'       => 'enliven_header_content',
            'type'          => 'text',
        )
    );  

    // Button 1 URL
    $wp_customize->add_setting(
        'header_btn_one_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'enliven_sanitize_url',
            'transport'         => 'refresh'
        )
    );    
    
    $wp_customize->add_control(
        'header_btn_one_url',
        array(
            'label'         => __( 'First button url.', 'enliven' ),
            'section'       => 'enliven_header_content',
            'type'          => 'text',
        )
    );     


    // Button 2 Text
    $wp_customize->add_setting(
        'header_btn_two_text',
        array(
            'default'           => __( 'Preview', 'enliven' ),
            'sanitize_callback' => 'enliven_sanitize_text',
            'transport'         => 'refresh'
        )
    );    
    
    $wp_customize->add_control(
        'header_btn_two_text',
        array(
            'label'         => __( 'Second button text.', 'enliven' ),
            'section'       => 'enliven_header_content',
            'type'          => 'text',
        )
    );  

    // Button 2 URL
    $wp_customize->add_setting(
        'header_btn_two_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'enliven_sanitize_url',
            'transport'         => 'refresh'
        )
    );    
    
    $wp_customize->add_control(
        'header_btn_two_url',
        array(
            'label'         => __( 'Second button url.', 'enliven' ),
            'section'       => 'enliven_header_content',
            'type'          => 'text',
        )
    ); 


    /**
     * Slider
     */
    $wp_customize->add_panel (
        'enliven_slider_panel',
        array(
            'priority'      => 35,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'Slider', 'enliven' ),
            'description'   => __( 'Use this panel to set your slider settings.', 'enliven' )
        )
    );

    $wp_customize->add_section ( 
        'enliven_slider_settings', 
        array(
            'title'     => __( 'Slider Settings.', 'enliven' ),
            'priority'  => 30,
            'panel'     => 'enliven_slider_panel'
        ) 
    );

    $wp_customize->add_setting(
        'enliven_front_slider',
        array(
            'default'           => false,
            'transport'         => 'refresh',
            'sanitize_callback' => 'enliven_sanitize_checkbox'
        )
    );
    $wp_customize->add_control(
        'enliven_front_slider',
        array(
            'label'         => __( 'Activate slider on static frontpage.', 'enliven' ),
            'section'       => 'enliven_slider_settings',
            'type'          => 'checkbox'
        )
    );

    $wp_customize->add_setting(
        'enliven_slider_blog_header',
        array(
            'default'           => false,
            'transport'         => 'refresh',
            'sanitize_callback' => 'enliven_sanitize_checkbox'
        )
    );
    $wp_customize->add_control(
        'enliven_slider_blog_header',
        array(
            'label'         => __( 'Activate slider on blog.', 'enliven' ),
            'section'       => 'enliven_slider_settings',
            /*'description'   => __( 'This setting only works if the blog is not set as front page.' ), */
            'type'          => 'checkbox'
        )
    );    

    $wp_customize->add_setting(
        'display_slider_title',
        array(
            'default'           => true,
            'transport'         => 'refresh',
            'sanitize_callback' => 'enliven_sanitize_checkbox'
        )
    );
    $wp_customize->add_control(
        'display_slider_title',
        array(
            'label'         => __( 'Display page title as slide title.', 'enliven' ),
            'section'       => 'enliven_slider_settings',
            'type'          => 'checkbox'
        )
    ); 

    $wp_customize->add_setting(
        'slider_content_switcher',
        array(
            'default'           => 'display-excerpt',
            'sanitize_callback' => 'enliven_sanitize_select',
            'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control(
        'slider_content_switcher',
        array(
            'label'         => __( 'Select what to display as slide content.', 'enliven' ),
            'section'       => 'enliven_slider_settings',
            'type'          => 'radio',
            //'description'   => __( 'Choose your preferred option.', 'enliven' ),
            'choices'   => array (
                'display-excerpt'   => __( 'Display page excerpt.', 'enliven' ),
                'display-content'   => __( 'Display all page content.', 'enliven' ),
                'display-none'      => __( 'Display none', 'enliven' )
            )
        )
    );   

    for ( $i=1; $i <= 5; $i++ ) {

        $wp_customize->add_section( 
            'enliven_slide_' . $i, 
            array(
                'title'     => sprintf( __( 'Slide %d.', 'enliven' ), $i ),
                'priority'  => 30,
                'panel'     => 'enliven_slider_panel',
                'description'   => __( 'Featured image of the selected page will be displayed as the slide image.', 'enliven' )
            ) 
        );

        // Page select for slider
        $wp_customize->add_setting( 
            'slider_page_' . $i, 
            array(
                'default'           => '',
                'sanitize_callback' => 'absint'
            )
        );

        $wp_customize->add_control( 
            'slider_page_' . $i, 
            array(
                'label'         => sprintf( __( 'Select a page for slide %d.', 'enliven' ), $i ),
                'section'       => 'enliven_slide_' . $i,
                'type'          => 'dropdown-pages'
            ) 
        );

        // Button 1 Text.
        $wp_customize->add_setting(
            'slide_' . $i . '_btn_one_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'enliven_sanitize_text',
                'transport'         => 'refresh'
            )
        );    
        
        $wp_customize->add_control(
            'slide_' . $i . '_btn_one_text',
            array(
                'settings'      => 'slide_' . $i . '_btn_one_text',
                'label'         => sprintf( __( 'Slide %d first button text.', 'enliven' ), $i ),
                'section'       => 'enliven_slide_' . $i,
                'type'          => 'text',
            )
        );  

        // Button 1 URL
        $wp_customize->add_setting(
            'slide_' . $i . '_btn_one_url',
            array(
                'default'           => '',
                'sanitize_callback' => 'enliven_sanitize_url',
                'transport'         => 'refresh'
            )
        );    
        
        $wp_customize->add_control(
            'slide_' . $i . '_btn_one_url',
            array(
                'settings'      => 'slide_' . $i . '_btn_one_url',
                'label'         => sprintf( __( 'Slide %d first button url.', 'enliven' ), $i ),
                'section'       => 'enliven_slide_' . $i,
                'type'          => 'text',
            )
        );        

        // Button 2 text.
        $wp_customize->add_setting(
            'slide_' . $i . '_btn_two_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'enliven_sanitize_text',
                'transport'         => 'refresh'
            )
        );    
        
        $wp_customize->add_control(
            'slide_' . $i . '_btn_two_text',
            array(
                'settings'      => 'slide_' . $i . '_btn_two_text',
                'label'         => sprintf( __( 'Slide %d second button text.', 'enliven' ), $i ),
                'section'       => 'enliven_slide_' . $i,
                'type'          => 'text',
            )
        );

        // Button 2 URL
        $wp_customize->add_setting(
            'slide_' . $i . '_btn_two_url',
            array(
                'default'           => '',
                'sanitize_callback' => 'enliven_sanitize_url',
                'transport'         => 'refresh'
            )
        );    
        
        $wp_customize->add_control(
            'slide_' . $i . '_btn_two_url',
            array(
                'settings'      => 'slide_' . $i . '_btn_two_url',
                'label'         => sprintf( __( 'Slide %d second button url.', 'enliven' ), $i ),
                'section'       => 'enliven_slide_' . $i,
                'type'          => 'text',
            )
        );           

    }   

    /**
     * Menu - Sticky, Fixed
     */
    /*$wp_customize->add_section(
        'enliven_menu_options',
        array(
            'priority'      => 160,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'Menu Settings', 'enliven' ),
            'panel'         => 'enliven_header_panel'
        )
    );


    /**
     * Front Page Options
     */
    /*$wp_customize->add_section( 'enliven_frontpage', array(
        'title'    => __( 'Front Page Settings', 'enliven' ),
        'priority' => 30,
    ) );*/

    /**
     * Blog Settings
     */
    $wp_customize->add_section( 'enliven_blog_section', array(
        'title'         => __( 'Blog Settings', 'enliven' ),
        'priority'      => 35,
    ) );

    $wp_customize->add_setting(
        'blog_page_title',
        array(
            'default'           => __( 'Blog', 'enliven' ),
            'sanitize_callback' => 'enliven_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'blog_page_title',
        array(
            'label'         => __( 'Blog title', 'enliven' ),
            //'description'   => __( 'Leave this empty to display the default blog page title', 'enliven' ),
            'section'       => 'enliven_blog_section',
            'type'          => 'text',
        )
    );    

    $wp_customize->add_setting(
        'blog_subtitle',
        array(
            'default'           => __( 'Latest Articles.', 'enliven' ),
            'sanitize_callback' => 'enliven_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'blog_subtitle',
        array(
            'label'     => __( 'Blog secondary title', 'enliven' ),
            'section'   => 'enliven_blog_section',
            'type'      => 'text',
        )
    );

    $wp_customize->add_setting( 
        'blog-header-image',
        array(
            'sanitize_callback' => 'enliven_sanitize_image'
        ) 
    );  
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'blog-header-image',
            array(
                'label'         => __( 'Blog Header Image', 'enliven' ),
                'section'       => 'enliven_blog_section',
                'settings'      => 'blog-header-image'
            )
        )
    );


    /**
     * Portfolio Settings
     */
    $wp_customize->add_section( 'enliven_portfolio_section', array(
        'title'             => __( 'Portfolio Settings', 'enliven' ),
        'priority'          => 36,
        'description'       => __( 'This section settings is only for portfolio archive page.', 'enliven' ),
        'active_callback'   => 'is_jetpack_cpt_active'
    ) );

    $wp_customize->add_setting(
        'portfolio_page_title',
        array(
            'default'           => __( 'Portfolio', 'enliven' ),
            'sanitize_callback' => 'enliven_sanitize_text',
        )
    );

    $wp_customize->add_control(
        'portfolio_page_title',
        array(
            'label'     => __( 'Portfolio archive title', 'enliven' ),
            'section'   => 'enliven_portfolio_section',
            'type' => 'text',
        )
    );    

    $wp_customize->add_setting(
        'portfolio_page_subtitle',
        array(
            'default'           => __( 'What we have done so far.', 'enliven' ),
            'sanitize_callback' => 'enliven_sanitize_text',
        )
    );

    $wp_customize->add_control(
        'portfolio_page_subtitle',
        array(
            'label'     => __( 'Portfolio archive secondary title', 'enliven' ),
            'section'   => 'enliven_portfolio_section',
            'type'      => 'text',
        )
    );

    $wp_customize->add_setting(
        'portfolio_page_description',
        array(
            'default'            => '',
            'sanitize_callback'  => 'enliven_sanitize_textarea',
        )
    );

    $wp_customize->add_control(
        'portfolio_page_description',
        array(
            'label'         => __( 'Portfolio archive description.', 'enliven' ),
            'section'       => 'enliven_portfolio_section',
            'type'          => 'textarea',
        )
    );    

    $wp_customize->add_setting( 
        'portfolio-header-image',
        array(
            'sanitize_callback' => 'enliven_sanitize_image'
        ) 
    ); 
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'portfolio-header-image',
            array(
                'label'     => __( 'Portfolio Header Image', 'enliven' ),
                'section'   => 'enliven_portfolio_section',
                'settings'  => 'portfolio-header-image'
            )
        )
    );

    /**
     * Testimonial Settings
     */
    $wp_customize->add_section( 'enliven_testimonial_section', array(
        'title'             => __( 'Testimonial Settings', 'enliven' ),
        'priority'          => 36,
        'description'       => __( 'This section settings is only for testimonial archive page.', 'enliven' ),
        'active_callback'   => 'is_jetpack_cpt_active'
    ) );

    $wp_customize->add_setting(
        'testimonial_page_title',
        array(
            'default'           => __( 'Testimonial', 'enliven' ),
            'sanitize_callback' => 'enliven_sanitize_text',
        )
    );

    $wp_customize->add_control(
        'testimonial_page_title',
        array(
            'label'     => __( 'Testimonial archive title', 'enliven' ),
            'section'   => 'enliven_testimonial_section',
            'type' => 'text',
        )
    );    

    $wp_customize->add_setting(
        'testimonial_page_subtitle',
        array(
            'default'           => __( 'What others say about us?', 'enliven' ),
            'sanitize_callback' => 'enliven_sanitize_text',
        )
    );

    $wp_customize->add_control(
        'testimonial_page_subtitle',
        array(
            'label'     => __( 'Testimonial archive secondary title', 'enliven' ),
            'section'   => 'enliven_testimonial_section',
            'type'      => 'text',
        )
    );

    $wp_customize->add_setting(
        'testimonial_page_description',
        array(
            'default'            => '',
            'sanitize_callback'  => 'enliven_sanitize_textarea',
        )
    );

    $wp_customize->add_control(
        'testimonial_page_description',
        array(
            'label'         => __( 'Testimonial archive description.', 'enliven' ),
            'section'       => 'enliven_testimonial_section',
            'type'          => 'textarea',
        )
    );    

    $wp_customize->add_setting( 
        'testimonial-header-image',
        array(
            'sanitize_callback' => 'enliven_sanitize_image'
        ) 
    ); 
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'testimonial-header-image',
            array(
                'label'     => __( 'Testimonial Header Image', 'enliven' ),
                'section'   => 'enliven_testimonial_section',
                'settings'  => 'testimonial-header-image'
            )
        )
    );

    /**
     * Styling Options.
     */
    $wp_customize->add_panel( 
        'enliven_theme_styling', 
        array(
            'title'         => __( 'Site Styling', 'enliven' ),
            'description'   => __( 'Use this section to setup the homepage slider and featured posts.', 'enliven' ),
            'priority'      => 37, 
        ) 
    );

    $wp_customize->add_setting(
        'site_main_color',
        array(
            'default'           => '#ea7054',
            'sanitize_callback' => 'enliven_sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_main_color',
            array(
                'settings'      => 'site_main_color',
                'section'       => 'colors',
                'label'         => __( 'Site Main Color', 'enliven' ),
                'description'   => __( 'Pick a main color for the site.', 'enliven' )
            )
        )
    );    

    $wp_customize->add_setting(
        'button_background_color',
        array(
            'default'           => '#325edd',
            'sanitize_callback' => 'enliven_sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'button_background_color',
            array(
                'settings'      => 'button_background_color',
                'section'       => 'colors',
                'label'         => __( 'Button Background Color', 'enliven' ),
                //'description'   => __( 'Pick button background color.', 'enliven' )
            )
        )
    );     

     $wp_customize->add_setting(
        'button_text_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'enliven_sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'button_text_color',
            array(
                'settings'      => 'button_text_color',
                'section'       => 'colors',
                'label'         => __( 'Button Text Color', 'enliven' ),
                //'description'   => __( 'Pick button text color.', 'enliven' )
            )
        )
    );   

    $wp_customize->add_setting(
        'button_background_hover_color',
        array(
            'default'           => '#153DB0',
            'sanitize_callback' => 'enliven_sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'button_background_hover_color',
            array(
                'settings'      => 'button_background_hover_color',
                'section'       => 'colors',
                'label'         => __( 'Button Hover Background Color', 'enliven' ),
                //'description'   => __( 'Pick button background color.', 'enliven' )
            )
        )
    );        

    $wp_customize->add_setting(
        'button_text_hover_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'enliven_sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'button_text_hover_color',
            array(
                'settings'      => 'button_text_hover_color',
                'section'       => 'colors',
                'label'         => __( 'Button Hover Text Color', 'enliven' ),
                //'description'   => __( 'Pick button background color.', 'enliven' )
            )
        )
    ); 

    /**
     * Custom CSS section
     */
    $wp_customize->add_section( 
        'enliven_custom_css', 
        array(
            'title'         => __( 'Custom CSS', 'enliven' ),
            'panel'         => 'enliven_theme_styling'
        ) 
    );

    $wp_customize->add_setting(
        'custom_css',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'enliven_sanitize_css'
        )
    );
    $wp_customize->add_control(
        'custom_css',
        array(
            'section'       => 'enliven_custom_css',
            'type'          => 'textarea',
            'label'         => __( 'Custom CSS', 'enliven' ),
            'description'   => __( 'Define custom CSS be used for your site. Do not enclose in script tags.', 'enliven' ),
        )
    );

    /**
     * Layout settings.
     */
    $wp_customize->add_section(
        'enliven_layout_options',
        array (
            'priority'      => 37,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => __( 'Layout Settings', 'enliven' )
        )
    );
    /* Site width */
    $wp_customize->add_setting(
        'enliven_main_layout',
        array (
            'default'           => 'enliven-full-width',
            'sanitize_callback' => 'enliven_sanitize_main_layout',
            'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control(
        'enliven_main_layout',
        array(
            'label'     => __( 'Select the main layout for site.', 'enliven' ),
            'section'   => 'enliven_layout_options',
            'priority'  => 1,
            'type'      => 'radio',
            'choices'   => array (
                'enliven-full-width' => __( 'Full width layout', 'enliven' ),
                'enliven-boxed'      => __( 'Boxed layout - 1240px', 'enliven' )
            )
        )
    );
    /* Post sidebar position */
    $wp_customize->add_setting(
        'enliven_post_sidebar_position',
        array (
            'default'           => 'right',
            'sanitize_callback' => 'enliven_sanitize_sidebar_position',
            'transport'         => 'refresh'
        )
    );
    $wp_customize->add_control(
        'enliven_post_sidebar_position',
        array (
            'label'         => __( 'Default sidebar position.', 'enliven' ),
            'section'       => 'enliven_layout_options',
            'priority'      => 2,
            'type'          => 'radio',
            'choices'       => array (
                'left'  => __( 'Left', 'enliven' ),
                'right' => __( 'Right', 'enliven' )
            ),
        )
    );  

    $wp_customize->add_section( 
        'enliven_pro_details', 
        array(
            'title'         => __( 'Enliven Pro', 'enliven' ),
            'priority'      => 120
        ) 
    );

    $wp_customize->add_setting( 
        'enliven_pro_desc', 
        array(
            'sanitize_callback' => 'enliven_sanitize_html'
        ) 
    );

    $wp_customize->add_control( 
        new Enliven_Custom_Content( 
            $wp_customize, 
            'enliven_pro_desc', 
            array(
                'section'       => 'enliven_pro_details',
                'priority'      => 20,
                'label'         => __( 'Do you want more features?', 'enliven' ),
                'content'       => __( 'Then consider buying <a href="http://themezhut.com/themes/enliven-pro/" target="_blank">Enliven Pro.</a><h4>Enliven Pro Features.</h4><ol><li>Google Fonts.</li><li>Unlimited Colors.</li><li>WooCommerce Support</li><li>Advanced Widgets.</li><li>Extra Widgets.<ul class="enl-bend-ul"><li>Contact Widget</li><li>Single Page Widget</li><li>Employees / Team Widget</li><li>Youtube Video Widget</li><li>And more widgets will come in future updates.</li></ul></li><li>Layout Options.</li><li>More Customizer Options.</li><li>Released under GPL.</li><li>Free updates.</li><li>Theme Support</li></ol>And more..<p><a class="button" href="http://themezhut.com/demo/enliven-pro/" target="_blank">Enliven Pro Demo</a><a class="button button-primary" href="http://themezhut.com/themes/enliven-pro/" target="_blank">Enliven Pro Details</a></p>', 'enliven' ) . '</p>',
                //'description'     => __( 'Optional: Example Description.', 'enliven' ),
            ) 
        ) 
    );  


}
add_action( 'customize_register', 'enliven_customize_register' );


/**
 * Sanitize text box.
 * 
 * @param string $input
 * @return string
 */
function enliven_sanitize_text( $input ) {
    return esc_html( $input );
}


/**
 * Sanitize checkbox.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function enliven_sanitize_checkbox( $checked ) {
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * URL sanitization.
 * 
 * @see esc_url_raw() https://developer.wordpress.org/reference/functions/esc_url_raw/
 *
 * @param string $url URL to sanitize.
 * @return string Sanitized URL.
 */
function enliven_sanitize_url( $url ) {
    return esc_url_raw( $url );
}

/**
 * Select sanitization
 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function enliven_sanitize_select( $input, $setting ) {
    
    // Ensure input is a slug.
    $input = sanitize_key( $input );
    
    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;
    
    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Sanitize textarea.
 * 
 * @param string $input
 * @return string
 */
function enliven_sanitize_textarea( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Sanitize image.
 *
 * @param string               $image   Image filename.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string The image filename if the extension is allowed; otherwise, the setting default.
 */
function enliven_sanitize_image( $image, $setting ) {
    /*
     * Array of valid image file types.
     *
     * The array includes image mime types that are included in wp_get_mime_types()
     */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
    // Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
    // If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}


/**
 * Sanitize the Sidebar Position value.
 *
 * @param string $position.
 * @return string (left|right).
 */
function enliven_sanitize_sidebar_position( $position ) {
    if ( ! in_array( $position, array( 'left', 'right' ) ) ) {
        $position = 'right';
    }
    return $position;
}

/**
 * Sanitize the layout width postion value.
 *
 * @param string $layout.
 * @return string (full-width|fixed-width).
 */
function enliven_sanitize_main_layout( $layout ) {
    if ( ! in_array( $layout, array( 'enliven-full-width', 'enliven-boxed' ) ) ) {
        $layout = 'enliven-full-width';
    } 

    return $layout;
}
/**
 * Sanitize the menu_type
 *
 * @param string $menu_type.
 * @return string (sticky-menu|normal-menu).
 */
function enliven_sanitize_menu_type( $menu_type ) {
    if ( ! in_array( $menu_type, array( 'sticky-menu', 'normal-menu' ) ) ) {
        $menu_type = 'sticky-menu';
    } 

    return $menu_type;
}

/**
 * HTML sanitization 
 *
 * @see wp_filter_post_kses() https://developer.wordpress.org/reference/functions/wp_filter_post_kses/
 *
 * @param string $html HTML to sanitize.
 * @return string Sanitized HTML.
 */
function enliven_sanitize_html( $html ) {
    return wp_filter_post_kses( $html );
}

/**
 * CSS sanitization.
 * 
 * @see wp_strip_all_tags() https://developer.wordpress.org/reference/functions/wp_strip_all_tags/
 *
 * @param string $css CSS to sanitize.
 * @return string Sanitized CSS.
 */
function enliven_sanitize_css( $css ) {
    return wp_strip_all_tags( $css );
}

/**
 * Checks whether the Jetpack Custom Content Type is active
 * @return bool
 */
function is_jetpack_cpt_active() {
    if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'custom-content-types' ) ) {
        return true;
    } else {
        return false;
    }
}

/**
 * HEX Color sanitization
 *
 * @see sanitize_hex_color() https://developer.wordpress.org/reference/functions/sanitize_hex_color/
 * @link sanitize_hex_color_no_hash() https://developer.wordpress.org/reference/functions/sanitize_hex_color_no_hash/
 *
 * @param string               $hex_color HEX color to sanitize.
 * @param WP_Customize_Setting $setting   Setting instance.
 * @return string The sanitized hex color if not empty; otherwise, the setting default.
 */
function enliven_sanitize_hex_color( $hex_color, $setting ) {
    // Sanitize $input as a hex value without the hash prefix.
    $hex_color = sanitize_hex_color( $hex_color );
    
    // If $input is a valid hex value, return it; otherwise, return the default.
    return ( ! empty( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function enliven_customize_preview_js() {
    wp_enqueue_script( 'enliven_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0.0', true );
}
add_action( 'customize_preview_init', 'enliven_customize_preview_js' );

/**
 * Enqueue the customizer stylesheet.
 */
function enliven_enqueue_customizer_stylesheets() {

    wp_register_style( 'enliven-customizer-css', get_template_directory_uri() . '/inc/customizer/assets/customizer.css', NULL, NULL, 'all' );
    wp_enqueue_style( 'enliven-customizer-css' );
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );

}
add_action( 'customize_controls_print_styles', 'enliven_enqueue_customizer_stylesheets' );
