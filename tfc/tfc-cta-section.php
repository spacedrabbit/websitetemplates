<?php
/**
 * CTA section for the homepage.
 *
 */


    function tfc_cta() {
?>
<section class="tfc-cta tfc-cta-line" id="tfc_cta" data-sorder="tfc_cta">
<div class="row">
        <div class="col-md-6 col-sm-12 left col-equal">
                <?php if ( is_active_sidebar( 'cta-left-widgets' ) ) : ?>
                        <div class="widget-container">
                            <?php dynamic_sidebar( 'cta-left-widgets' ); ?>
                        </div>
                <?php else: ?>
                <h2>Widget Area</h2>
                <h4>CTA Left Widgets</h4>
                <p>You can put any widget content in this area.  We suggest an ActBlue Quick Donate widget, a contact form, or a welcome message.</p>
                <?php endif; ?>
                    </div>                  
                    <div class="col-md-6 col-sm-12 right col-equal">                        
                <?php if ( is_active_sidebar( 'cta-right-widgets' ) ) : ?>
                        <div class="widget-container">
                            <?php dynamic_sidebar( 'cta-right-widgets' ); ?>
                        </div>
                <?php else: ?>
                <h2>Widget Area</h2>
                <h4>CTA Right Widgets</h4>
                <p>Find these widget settings under Frontpage Sections in the Customizer!</p>
                <?php endif; ?>
                    </div>
 </div>
 <div class="clearfix"></div>
</section>
<?php    }
?>