<?php 
  function hestia_the_footer_content() {
    /**
     * Array holding all registered footer widgets areas
     */
    $hestia_footer_widgets_ids = array(
      'footer-one-widgets',
      'footer-two-widgets',
      'footer-three-widgets',
    );
    $hestia_footer_class       = 'col-md-4';

    /**
     *  Enabling alternative footer style
     */
    $footer_style = get_theme_mod( 'hestia_alternative_footer_style', 'black_footer' );
    switch ( $footer_style ) {
      case 'black_footer':
        $footer_class = 'footer-black';
        break;
      case 'white_footer':
        $footer_class = '';
        break;
      default:
        $footer_class = 'footer-black';
    }


    /**
     * Check if the selected footer widgets areas are not empty
     */
    if ( ! empty( $hestia_footer_widgets_ids ) ) {
      foreach ( $hestia_footer_widgets_ids as $hestia_footer_widget_item ) {
        $footer_has_widgets = is_active_sidebar( $hestia_footer_widget_item );
        if ( $footer_has_widgets ) {
          break;
        }
      }
    }

    hestia_before_footer_trigger();
    ?>
    <footer class="footer <?php echo esc_attr( $footer_class ); ?> footer-big">
      <?php hestia_before_footer_content_trigger(); ?>
      <div class="container">
        <?php
        if ( $footer_has_widgets ) {
          ?>
          <div class="content">
            <div class="row">



              <?php
              if ( ! empty( $hestia_footer_widgets_ids ) ) {
                foreach ( $hestia_footer_widgets_ids as $hestia_footer_widget_item ) {
                  if ( is_active_sidebar( $hestia_footer_widget_item ) ) {
                    echo '<div class="' . $hestia_footer_class . '">';
                    dynamic_sidebar( $hestia_footer_widget_item );
                    echo '</div>';
                  }
                }
              }
              ?>
            </div>
          </div>
          <hr/>
          <?php
        }
        ?>
        <?php hestia_before_footer_widgets_trigger(); ?>
        <?php hestia_after_footer_widgets_trigger(); ?>
        <div class="bottom-footer-content">
          <?php
          hesta_bottom_footer_content();
          ?>
        </div>
      </div>
      <?php hestia_after_footer_content_trigger(); ?>
    </footer>
    <?php
    hestia_after_footer_trigger();
  }

  function hesta_bottom_footer_content( $is_callback = false ) {
    if ( ! $is_callback ) {
      ?>
        <p class="copyright center">Powered by <a href="http://www.techforcampaigns.org" target="_blank">Tech for Campaigns</a></p>
      <?php
    }
  }

  ?>