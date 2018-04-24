<?php
class tfc_paid_for_widget extends WP_Widget {

public function __construct() {
    $widget_options = array( 
      'classname' => 'tfc_paid_for_widget',
      'description' => 'Paid For Widget by TFC',
    );
    parent::__construct( 'tfc_paid_for_widget', 'Paid For Widget by TFC', $widget_options );
  }

public function widget( $args, $instance ) {
  $params=array();
  if (!empty($instance) ){
    $line1 = $instance[ 'line1' ]?: 'Paid for and authorized by';
    $line2 = $instance[ 'line2' ];
    $line3 = $instance[ 'line3' ];
    $line4 = $instance[ 'line4' ];
  }else{
    $line1 = 'Paid for and authorized by';
    $line2 = 'Jill McCandidate for Office';
    $line3 = 'Address';
    $line4 = 'City, State Zip';
  }

  echo $args['before_widget']  
  ?>
    <div class="paid-for">
      <p><?php echo esc_attr( $line1 ); ?></p>
      <p><?php echo esc_attr( $line2 ); ?></p>
      <p><?php echo esc_attr( $line3 ); ?></p>
      <p><?php echo esc_attr( $line4 ); ?></p>
    </div>
  <?php echo $args['after_widget']; 

}
public function form( $instance ) {
    $line1 = ! empty( $instance['line1'] ) ? $instance['line1'] : 'Paid for and authorized by'; 
    $line2 = ! empty( $instance['line2'] ) ? $instance['line2'] : ''; 
    $line3 = ! empty( $instance['line3'] ) ? $instance['line3'] : ''; 
    $line4 = ! empty( $instance['line4'] ) ? $instance['line4'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'line1' ); ?>">Line 1:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'line1' ); ?>" name="<?php echo $this->get_field_name( 'line1' ); ?>" value="<?php echo esc_attr( $line1 ); ?>" />
        </p><p>
      <label for="<?php echo $this->get_field_id( 'line2' ); ?>">Line 2:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'line2' ); ?>" name="<?php echo $this->get_field_name( 'line2' ); ?>" value="<?php echo esc_attr( $line2 ); ?>" />
        </p><p>
      <label for="<?php echo $this->get_field_id( 'line3' ); ?>">Line 3:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'line3' ); ?>" name="<?php echo $this->get_field_name( 'line3' ); ?>" value="<?php echo esc_attr( $line3 ); ?>" />
      </p><p>
      <label for="<?php echo $this->get_field_id( 'line4' ); ?>">Line 4:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'line4' ); ?>" name="<?php echo $this->get_field_name( 'line4' ); ?>" value="<?php echo esc_attr( $line4 ); ?>" />
        </p><p>
      </p>
    <?php 
  }

  public function update( $new_instance, $old_instance ) {
  $instance = $old_instance;
  $instance[ 'line1' ] = strip_tags( $new_instance[ 'line1' ] );
  $instance[ 'line2' ] = strip_tags( $new_instance[ 'line2' ] );
  $instance[ 'line3' ] = strip_tags( $new_instance[ 'line3' ] );
  $instance[ 'line4' ] = strip_tags( $new_instance[ 'line4' ] );
  return $instance;
  }
}

function tfc_paid_for_widget() { 
  register_widget( 'tfc_paid_for_widget' );
}

add_action( 'widgets_init', 'tfc_paid_for_widget' );
?>