<?php

function tfc_new_button( $wp_customize ) {

		$wp_customize->add_section(
		'cta_buttons', array(
			'title'    => esc_html__( 'CTA Buttons', 'hestia' ),
			'panel'    => 'hestia_frontpage_sections',
			'priority' => 1,
		)
	);
//move the old button controls over to new section since old section is effed the eff up
	$button_text_control = $wp_customize->get_control( 'hestia_big_title_button_text' );
    if ( $button_text_control ) {
        $button_text_control->section = 'cta_buttons';
    }

	$button_link_control = $wp_customize->get_control( 'hestia_big_title_button_link' );
    if ( $button_link_control ) {
        $button_link_control->section = 'cta_buttons';
    }

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? true : false;
	/* Add the second button in the Big Title section */

	/**
	 * Control for button text
	 */
	$wp_customize->add_setting(
		'tfc_big_title_second_button_text', array(
			'default'           => esc_html__( 'Second Button text', 'tfc' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);
	$wp_customize->add_control(
		'tfc_big_title_second_button_text', array(
			'label'    => esc_html__( 'Second Button text', 'tfc' ),
			'section'  => 'cta_buttons',
			'priority' => 40,
		)
	);

	/**
	 * Control for button link
	 */
	$wp_customize->add_setting(
		'tfc_big_title_second_button_link', array(
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);
	$wp_customize->add_control(
		'tfc_big_title_second_button_link', array(
			'label'    => esc_html__( 'Second Button URL', 'tfc' ),
			'section'  => 'cta_buttons',
			'priority' => 50,
		)
	);

	$wp_customize->selective_refresh->remove_partial( 'hestia_big_title_button' );

	$wp_customize->selective_refresh->add_partial(
		'tfc_big_title_second_button', array(
			'selector'        => '.carousel .buttons',
			'settings'        => array( 'hestia_big_title_button_text', 'hestia_big_title_button_link', 'tfc_big_title_second_button_text', 'tfc_big_title_second_button_link' ),
			'render_callback' => 'tfc_big_title_buttons_callback',
		)
	);

}
add_action( 'customize_register', 'tfc_new_button', 25 );
function tfc_big_title_second_btn() {

	$tfc_big_title_second_btn_text = get_theme_mod( 'tfc_big_title_second_button_text', __( 'Second button text', 'tfc' ) );
	$tfc_big_title_second_btn_link = get_theme_mod( 'tfc_big_title_second_button_link', '#' );

	if ( ! empty( $tfc_big_title_second_btn_text ) && ! empty( $tfc_big_title_second_btn_link ) ) {
		?>
		<a href="<?php echo esc_url( $tfc_big_title_second_btn_link ); ?>" title="<?php echo esc_attr( $tfc_big_title_second_btn_text ); ?>" class="btn btn-right btn-trans btn-lg" <?php echo hestia_is_external_url( $tfc_big_title_second_btn_link ); ?>><?php echo esc_html( $tfc_big_title_second_btn_text ); ?></a>
		<?php
	}
}
add_action( 'hestia_big_title_section_buttons', 'tfc_big_title_second_btn' );

/**
 * Render callback for buttons in Big Title section
 *
 * @since 1.0.0
 */
function tfc_big_title_buttons_callback() {

	$tfc_big_title_first_btn_text  = get_theme_mod( 'hestia_big_title_button_text', __( 'First button text', 'tfc' ) );
	$tfc_big_title_first_btn_link  = get_theme_mod( 'hestia_big_title_button_link', '#' );
	$tfc_big_title_second_btn_text = get_theme_mod( 'tfc_big_title_second_button_text', __( 'Second button text', 'tfc' ) );
	$tfc_big_title_second_btn_link = get_theme_mod( 'tfc_big_title_second_button_link', '#' );

	if ( ! empty( $tfc_big_title_first_btn_text ) ) {
		?>
		<a href="<?php echo esc_url( $tfc_big_title_first_btn_link ); ?>" title="<?php echo esc_attr( $tfc_big_title_first_btn_text ); ?>" class="btn btn-primary btn-lg" <?php echo hestia_is_external_url( $tfc_big_title_first_btn_link ); ?>><?php echo esc_html( $tfc_big_title_first_btn_text ); ?></a>
		<?php
	}

	if ( ! empty( $tfc_big_title_second_btn_text ) ) {
		?>
		<a href="<?php echo esc_url( $tfc_big_title_second_btn_link ); ?>" title="<?php echo esc_attr( $tfc_big_title_second_btn_text ); ?>" class="btn btn-trans btn-right btn-lg" <?php echo hestia_is_external_url( $tfc_big_title_second_btn_link ); ?>><?php echo esc_html( $tfc_big_title_second_btn_text ); ?></a>
		<?php
	}
}

?>