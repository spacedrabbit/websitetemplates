<?php
/**
 * Customizer functionality for the CTA section.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Hook controls for CTA section to Customizer.
 *
 * @since Hestia 1.0
 * @modified 1.1.49
 */
function tfc_cta_customize_register( $wp_customize ) {

    $selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';


    $cta_left_widgets = $wp_customize->get_section( 'sidebar-widgets-cta-left-widgets' );
    $cta_right_widgets = $wp_customize->get_section( 'sidebar-widgets-cta-right-widgets' );
    if ( ! empty( $cta_left_widgets ) ) {
        $cta_left_widgets->panel    = 'hestia_frontpage_sections';
        $cta_left_widgets->priority = apply_filters( 'hestia_section_priority', 05, 'sidebar-widgets-cta-left-widgets' );
    }
    if ( ! empty( $cta_right_widgets ) ) {
        $cta_right_widgets->panel    = 'hestia_frontpage_sections';
        $cta_right_widgets->priority = apply_filters( 'hestia_section_priority', 05, 'sidebar-widgets-cta-right-widgets' );
    }
}
add_action( 'customize_register', 'tfc_cta_customize_register' );

function tfc_footer_bar_customize_register( $wp_customize ) {

    $selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

    $footer_bottom_widgets = $wp_customize->get_section( 'sidebar-widgets-footer-bottom-widgets' );
    if ( ! empty( $footer_bottom_widgets ) ) {
        $footer_bottom_widgets->priority = apply_filters( 'hestia_section_priority', 65, 'sidebar-widgets-footer-bottom-widgets' );
    }

}
add_action( 'customize_register', 'tfc_footer_bar_customize_register' );
?>