<?php

function hestia_features( $is_shortcode = false ) {

        // When this function is called from selective refresh, $is_shortcode gets the value of WP_Customize_Selective_Refresh object. We don't need that.
        if ( ! is_bool( $is_shortcode ) ) {
            $is_shortcode = false;
        }

        $hide_section = get_theme_mod( 'hestia_features_hide', false );
        $default_subtitle = current_user_can( 'edit_theme_options' ) ? esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'themeisle-companion' ) : false;
        $default_content = current_user_can( 'edit_theme_options' ) ? tfc_get_features_default() : false;
        $hestia_features_content  = get_theme_mod( 'hestia_features_content', $default_content );
        $section_is_empty = empty( $hestia_features_content );

        /* Don't show section if Disable section is checked or it doesn't have any content. Show it if it's called as a shortcode */
        if ( $is_shortcode === false && ( $section_is_empty || (bool) $hide_section === true ) ) {
            if ( is_customize_preview() ) {
                echo '<section class="hestia-features" id="features" data-sorder="hestia_features" style="display: none"></section>';
            }
            return;
        }

        $wrapper_class = $is_shortcode === true ? 'is-shortcode' : '';
        $container_class = $is_shortcode === true ? '' : 'container';

        hestia_before_features_section_trigger();
        ?>
        <section class="hestia-features <?php echo esc_attr( $wrapper_class ); ?>" id="features" data-sorder="hestia_features">
            <?php hestia_before_features_section_content_trigger(); ?>
            <div class="<?php echo esc_attr( $container_class ); ?>">
                <?php
                hestia_top_features_section_content_trigger();

                tfc_features_content( $hestia_features_content );

                ?>
                <?php hestia_bottom_features_section_content_trigger(); ?>
            </div>
            <?php hestia_after_features_section_content_trigger(); ?>
        </section>
        <?php
        hestia_after_features_section_trigger();
    }

function tfc_features_content( $hestia_features_content, $is_callback = false ) {
    if ( ! $is_callback ) {
    ?>
        <div class="hestia-features-content">
        <?php
    }
    if ( ! empty( $hestia_features_content ) ) :

        $hestia_features_content = json_decode( $hestia_features_content );
            echo '<div class="row" ' . ( function_exists( 'hestia_add_animationation') ? hestia_add_animationation( 'fade-up' ) : '' ) . '>';
            $feature_count = count($hestia_features_content);
            $tfc_features_col_class = "col-md-4";
            switch ($feature_count) {
                case 1:
                    $tfc_features_col_class = "col-md-12";
                    break;
                case 2:
                    $tfc_features_col_class = "col-md-6";
                    break;
                case 3:
                    $tfc_features_col_class = "col-md-4";
                    break;
                case 4:
                    $tfc_features_col_class = "col-md-3";
                    break;
            }
            foreach ( $hestia_features_content as $features_item ) :
                $icon = ! empty( $features_item->icon_value ) ? apply_filters( 'hestia_translate_single_string', $features_item->icon_value, 'Features section' ) : '';
                $image = ! empty( $features_item->image_url ) ? apply_filters( 'hestia_translate_single_string', $features_item->image_url, 'Features section' ) : '';
                $title = ! empty( $features_item->title ) ? apply_filters( 'hestia_translate_single_string', $features_item->title, 'Features section' ) : '';
                $text = ! empty( $features_item->text ) ? apply_filters( 'hestia_translate_single_string', $features_item->text, 'Features section' ) : '';
                $link = ! empty( $features_item->link ) ? apply_filters( 'hestia_translate_single_string', $features_item->link, 'Features section' ) : '';
                $button = ! empty( $features_item->text2 ) ? apply_filters( 'hestia_translate_single_string', $features_item->text2, 'Features section' ) : 'Read More';
                ?>
                <div class="col-xs-12 <?php echo $tfc_features_col_class; ?> feature-box">
                    <div class="hestia-info">
                        <?php
                        if ( ! empty( $link ) ) {
                            $link_html = '<a href="' . esc_url( $link ) . '"';
                            if ( function_exists( 'hestia_is_external_url' ) ) {
                                $link_html .= hestia_is_external_url( $link );
                            }
                            $link_html .= '>';
                            echo wp_kses_post( $link_html );
                        }
                            ?>
                            <?php if ( ! empty( $title ) ) : ?>
                                <h4 class="info-title"><?php echo esc_html( $title ); ?></h4>
                            <?php endif; ?>
                            <?php if ( ! empty( $link ) ) : ?>
                        </a>
                    <?php endif; ?>
            <?php if ( ! empty( $text ) ) : ?>
                            <p><?php echo wp_kses_post( html_entity_decode( $text ) ); ?></p>
                        <?php endif; ?>
                        <?php if ( ! empty( $link ) ) : ?>
                                    <a href="<?php echo esc_url( $link ); ?>" class="btn btn-trans">
                                        <?php echo $button; ?>
                                    </a>
                                    <?php endif; ?>
                    </div>
                </div>
                <?php
            endforeach;
            echo '</div>';
        endif;
    if ( ! $is_callback ) {
    ?>
        </div>
        <?php
    }
}

 function tfc_get_features_default() {
    return apply_filters(
        'hestia_features_default_content', json_encode(
            array(
                array(
                    'title'      => esc_html__( 'Healthcare', 'themeisle-companion' ),
                    'text'       => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'themeisle-companion' ),
                    'link'       => '#',
                    'text2' => 'Read More'
                ),
                array(
                    'title'      => esc_html__( 'Democracy', 'themeisle-companion' ),
                    'text'       => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'themeisle-companion' ),
                    'link'       => '#',
                    'text2' => 'Read More'
                ),
                array(
                    'title'      => esc_html__( 'Economy', 'themeisle-companion' ),
                    'text'       => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'themeisle-companion' ),
                    'link'       => '#',
                    'text2' => 'Read More'
                ),
            )
        )
    );
}   
?>