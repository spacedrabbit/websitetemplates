<?php

/**
 * Change default fonts.
 *
 * @since 1.0.0
 */
function tfc_change_defaults( $wp_customize ) {

    $selective_refresh = isset( $wp_customize->selective_refresh ) ? true : false;

    $tfc_no_box = $wp_customize->get_setting( 'hestia_general_layout' );
    if ( ! empty( $tfc_no_box ) ) {
        $tfc_no_box->default = 0;
    }
// hide all the extra frontpage sections

    $tfc_no_contact = $wp_customize->get_setting( 'hestia_contact_hide' );
    if ( ! empty( $tfc_no_contact ) ) {
        $tfc_no_contact->default = true;
    }    
    $tfc_no_about = $wp_customize->get_setting( 'hestia_about_hide' );
    if ( ! empty( $tfc_no_about ) ) {
        $tfc_no_about->default = true;
    } 
    $tfc_no_sub = $wp_customize->get_setting( 'hestia_subscribe_hide' );
    if ( ! empty( $tfc_no_sub ) ) {
        $tfc_no_sub->default = true;
    } 
    $tfc_no_blog = $wp_customize->get_setting( 'hestia_blog_hide' );
    if ( ! empty( $tfc_no_blog ) ) {
        $tfc_no_blog->default = true;
    }
    $tfc_no_team = $wp_customize->get_setting( 'hestia_team_hide' );
    if ( ! empty( $tfc_no_team ) ) {
        $tfc_no_team->default = true;
    } 
    $tfc_no_clients_bar = $wp_customize->get_setting( 'hestia_clients_bar_hide' );
    if ( ! empty( $tfc_no_clients_bar ) ) {
        $tfc_no_clients_bar->default = true;
    }
    $tfc_testimonials_bar = $wp_customize->get_setting( 'hestia_testimonials_hide' );
    if ( ! empty( $tfc_testimonials_bar ) ) {
        $tfc_testimonials_bar->default = true;
    }

    $wp_customize->add_setting( 'tfc_color', array(

      'capability' => 'edit_theme_options',
      'default' => 'podium',
      'sanitize_callback' => 'tfc_sanitize_radio',
      'transport'         => 'postMessage',
    ) );


    $wp_customize->add_control( 'tfc_color', array(
      'type' => 'radio',
      'section' => 'colors', 
      'label' => __( 'Color Scheme' ),
      'description' => __( 'Select your design' ),
      'choices' => array(
        'modblue' => __( 'Blue Wave' ),
        'podium' => __( 'Podium' ),
        'modmult' => __( 'Movement' )
      ),
        'render_callback' => 'tfc_color_callback'
    ) );


    $wp_customize->add_setting( 'tfc_head_color', array(

      'capability' => 'edit_theme_options',
      'default' => 'false',
      'sanitize_callback' => 'tfc_sanitize_checkbox',
    ) );


    $wp_customize->add_control( 'tfc_head_color', array(
      'type' => 'checkbox',
      'section' => 'colors', 
      'label' => __( 'White Background for Header' ),
      'description' => __( 'Better for some logos' )
    ) );

    $wp_customize->remove_control('hestia_features_title');
    $wp_customize->remove_control('hestia_features_subtitle');

    $wp_customize->add_control(
    new Hestia_Repeater(
        $wp_customize, 'hestia_features_content', array(
            'label'                             => esc_html__( 'Features Content', 'themeisle-companion' ),
            'section'                           => 'hestia_features',
            'priority'                          => 15,
            'add_field_label'                   => esc_html__( 'Add new Feature', 'themeisle-companion' ),
            'item_name'                         => esc_html__( 'Feature', 'themeisle-companion' ),
            'customizer_repeater_title_control' => true,
            'customizer_repeater_text_control'  => true,
            'customizer_repeater_link_control'  => true,
            'customizer_repeater_text2_control' => true,
    )));
    $wp_customize->selective_refresh->add_partial(
        'hestia_features_content', array(
            'selector' => '.hestia-features-content',
            'settings' => 'hestia_features_content',
        )
    );

    $wp_customize->remove_control('background_color');
    $wp_customize->remove_control('accent_color');

}

add_action( 'customize_register', 'tfc_change_defaults', 999 );


/**
 * Render callback for color change
 *
 * @since 1.0.0
 */
function tfc_color_callback() {

    $tfc_color_setting  = get_theme_mod( 'tfc_color','tfc' );
    tfc_accent_color($tfc_color_setting);
}

function tfc_font_default_frontend() {
    $scheme = get_theme_mod( 'tfc_color','tfc' );
    if ($scheme === 'modblue'){
        return 'Montserrat';
    }
    if ($scheme === 'modmult'){
        return 'Libre Franklin';
    }
    return 'Libre Baskerville'; //default/podium  
}
function tfc_font_default_body_frontend() {
    $scheme = get_theme_mod( 'tfc_color','tfc' );
    if ($scheme === 'modblue'){
        return 'Montserrat';
    }
    if ($scheme === 'modmult'){
        return 'Source Serif Pro';
    }
    return 'Open Sans'; //default/podium
}
add_filter( 'hestia_headings_default', 'tfc_font_default_frontend' );
add_filter( 'hestia_body_font_default', 'tfc_font_default_body_frontend' );

/**
 * Change default value of accent color
 *
 * @return string - default accent color
 * @since 1.0.0
 */
function tfc_accent_color($tfc_color_setting) {
     if (empty ($tfc_color_setting))  {
       $tfc_color_setting  = get_theme_mod( 'tfc_color','tfc' );
     } 
    if ($tfc_color_setting == 'modblue'){
        return '#A62A22';
    }
    if ($tfc_color_setting == 'modmult'){
        return '#183E58';
    }else {
        return '#8A332D';
    }
}
add_filter( 'hestia_accent_color_default', 'tfc_accent_color' );

function tfc_sanitize_checkbox( $checked ) {
  // Boolean check.
  return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function tfc_sanitize_radio( $input, $setting ) {

  // Ensure input is a slug.
  $input = sanitize_key( $input );

  // Get list of choices from the control associated with the setting.
  $choices = $setting->manager->get_control( $setting->id )->choices;

  // If the input is a valid key, return it; otherwise, return the default.
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function tfc_sanitize_select( $input, $setting ) {

  // Ensure input is a slug.
  $input = sanitize_key( $input );

  // Get list of choices from the control associated with the setting.
  $choices = $setting->manager->get_control( $setting->id )->choices;

  // If the input is a valid key, return it; otherwise, return the default.
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function tfc_header_background_default() {
    return get_stylesheet_directory_uri() . '/assets/img/header.jpg';
}
add_filter( 'hestia_big_title_background_default', 'tfc_header_background_default' );


?>