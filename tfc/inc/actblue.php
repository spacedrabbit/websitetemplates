<?php
class tfc_actblue_widget extends WP_Widget {

public function __construct() {
    $widget_options = array( 
      'classname' => 'tfc_actblue_widget',
      'description' => 'ActBlue Widget by TFC',
    );
    parent::__construct( 'tfc_actblue_widget', 'ActBlue Widget by TFC', $widget_options );
  }

public function widget( $args, $instance ) {
  $params=array();
  $dollars = array('25','50','75','100','150','Other'); 
  if (!empty($instance) ){
    $ab_url = $instance[ 'ab_url' ];
    $ab_ref = $instance[ 'ab_ref' ];
    $ab_btn_text = $instance[ 'ab_btn_text' ] ?: 'Donate';
  }else{
    $ab_url = '';
    $ab_ref = '';
    $ab_btn_text = 'Donate';
    $note = '<p>Configure your ActBlue URL in this widget to start getting donations</p>';
  }


  $ab_head_text = ! empty( $instance['ab_head_text'] ) ? $instance['ab_head_text'] : 'Quick Donate'; 
  if (!empty($ab_ref)){
    $params['refcode'] = $ab_ref; 
  }
  $ab_url_button = $ab_url . '?' . 'refcode=' . $ab_ref;
  $ab_url_final = $ab_url . '?' . http_build_query($params);
  echo $args['before_widget']  
  ?>
  <div class="quick-donate">
  
    <h2><?php echo esc_attr( $ab_head_text ); ?></h2>
    <?php echo $note; ?>    
    <div class="row">

      <?php foreach ($dollars as &$value) {
        $value_display = '';
        $css_tag = '';
        $params['amount'] = '';
        $params['amount'] = $value;
        if ($value != 'Other'){
          $value_display = '$' . $value;
        }else{
          $value_display = $value ;
          $css_tag = ' other';
        }
        $ab_url_final = $ab_url . '?' . http_build_query($params);
        echo '<div class="col-xs-6 col-md-4 amount' . $css_tag . '"><a href="' . $ab_url_final . '" target="_new">' . $value_display . '</a></div>';
      }
      ?>
    </div>
    <div class="buttons">
      <a href="<?php echo esc_attr( $ab_url_button ); ?>" title="donate" class="btn btn-primary btn-lg" target="_new"><?php echo esc_attr( $ab_btn_text ); ?></a>
    </div>
  </div>

  <?php echo $args['after_widget']; 

}
public function form( $instance ) {
    $ab_url = ! empty( $instance['ab_url'] ) ? $instance['ab_url'] : ''; 
    $ab_ref = ! empty( $instance['ab_ref'] ) ? $instance['ab_ref'] : ''; 
    $ab_head_text = ! empty( $instance['ab_head_text'] ) ? $instance['ab_head_text'] : 'Quick Donate'; 
    $ab_btn_text = ! empty( $instance['ab_btn_text'] ) ? $instance['ab_btn_text'] : 'Donate'; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'ab_head_text' ); ?>">Headline:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'ab_head_text' ); ?>" name="<?php echo $this->get_field_name( 'ab_head_text' ); ?>" value="<?php echo esc_attr( $ab_head_text ); ?>" />
        </p><p>
      <label for="<?php echo $this->get_field_id( 'ab_url' ); ?>">ActBlue full URL:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'ab_url' ); ?>" name="<?php echo $this->get_field_name( 'ab_url' ); ?>" value="<?php echo esc_attr( $ab_url ); ?>" />
        </p><p>
      <label for="<?php echo $this->get_field_id( 'ab_ref' ); ?>">Reference code (optional):</label>
      <input type="text" id="<?php echo $this->get_field_id( 'ab_ref' ); ?>" name="<?php echo $this->get_field_name( 'ab_ref' ); ?>" value="<?php echo esc_attr( $ab_ref ); ?>" />
      </p><p>
      <label for="<?php echo $this->get_field_id( 'ab_btn_text' ); ?>">Button Text:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'ab_btn_text' ); ?>" name="<?php echo $this->get_field_name( 'ab_btn_text' ); ?>" value="<?php echo esc_attr( $ab_btn_text ); ?>" />
        </p><p>
      </p>
    <?php 
  }

  public function update( $new_instance, $old_instance ) {
  $instance = $old_instance;
  $instance[ 'ab_url' ] = strip_tags( $new_instance[ 'ab_url' ] );
  $instance[ 'ab_ref' ] = strip_tags( $new_instance[ 'ab_ref' ] );
  $instance[ 'ab_btn_text' ] = strip_tags( $new_instance[ 'ab_btn_text' ] );
  $instance[ 'ab_head_text' ] = strip_tags( $new_instance[ 'ab_head_text' ] );
  return $instance;
  }
}

function tfc_register_actblue_widget() { 
  register_widget( 'tfc_actblue_widget' );
}

add_action( 'widgets_init', 'tfc_register_actblue_widget' );
?>