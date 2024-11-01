<?php
/*
 * Plugin name: Life Meter Widget
 * Plugin URI: http://www.bythegram.ca
 * Description: A life meter widget and shortcode that you can use to display how you are feeling, for the video game nerd in us all
 * Version: 0.1.3
 * Author: Adam Graham 
 * 
 */

if (!class_exists("life_meter_widget")) {
/**
 * The CSS
 */
function LifeMeter_Styles() {
        wp_enqueue_style( 'LifeMeter-Plugin-Style', plugin_dir_url( __FILE__ ) . 'life-meter-style.css', array(), '0.1', 'screen' );
}
add_action( 'wp_enqueue_scripts', 'LifeMeter_Styles' );	
 
/**
 * Shortcode
 */
 //[life_meter]
function life_meter_func( $atts ){
	extract( shortcode_atts( array(
		'life' => '90',
		'hearts' => '5'
	), $atts ) );
	$ihearts = intval($hearts);
	$width = ($ihearts*40);
	$html = '<div class="lm_holder" style="width:'.$width.'px;">';
	$html .= '<div class="lm_bar" style="width:'.$width.'px;">';
	$html .= '<span class="my_meter" style="width:'.$life.'%;"></span>';
	$html .= '</div>';
	$html .= '<ul class="my_lifemeter" style="width:'.$width.'px;">';
	for ($i = 0; $i < $ihearts; $i++) {
	$html .= '<li></li>';
	}
	$html .= '</ul>';
	$html .= '</div>';
	return $html;
}
add_shortcode( 'life_meter', 'life_meter_func' );

	class life_meter_widget extends WP_Widget {

		function life_meter_widget() {

			$widget_ops = array('classname' => 'life_meter_widget', 'description' => 'Show your health by inputting the percent of the life meter you wish filled' );
			$this->WP_Widget('life_meter_widget', 'Life Meter Widget', $widget_ops);
		}
 		/* This is the code that gets displayed on the UI side,
		 * what readers see.
		 */
		function widget($args, $instance) {
			extract($args);
			$metername = $instance['metername'];
			$health = $instance['health'];
			$caption = $instance['caption'];
          		$hearts = intval($instance['hearts']);
			$width = ($hearts*40);
			echo $before_widget;
			echo $before_title . $metername . $after_title;
			echo '<div class="lm_holder" style="width:'.$width.'px;">';
			echo '<div class="lm_bar" style="width:'.$width.'px;">';
			echo '<span class="my_meter" style="width:'.$health.'%;"></span>';
			echo '</div>';
			echo '<ul class="my_lifemeter" style="width:'.$width.'px;">';
			for ($i = 0; $i < $hearts; $i++) {
			echo '<li></li>';
			}
			echo '</ul>';
			echo '</div>';
			echo $before_title . $caption . $after_title;
			echo $after_widget;
		}

		function update($new_instance, $old_instance) {
			return $new_instance;
		}
 		/* Back end, the interface shown in Appearance -> Widgets
		 * administration interface.
		 */

		function form($instance) {

           	$metername = esc_attr($instance['metername']);
          	$health = esc_attr($instance['health']);
		$caption = esc_attr($instance['caption']);
		$hearts = esc_attr($instance['hearts']);
?>
<p>
  <label for="<?php echo $this->get_field_id('metername'); ?>">
    <?php _e('Meter Name:','your-theme'); ?>
  </label>
  <input type="text" name="<?php echo $this->get_field_name('metername'); ?>" value="<?php echo $metername; ?>" class="widefat" id="<?php echo $this->get_field_id('metername'); ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id('health'); ?>">
    <?php _e('Health %','your-theme'); ?>
  </label>
    <input type="text" name="<?php echo $this->get_field_name('health'); ?>" value="<?php echo $health; ?>" class="widefat" id="<?php echo $this->get_field_id('health'); ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id('hearts'); ?>">
    <?php _e('How Many Hearts?','your-theme'); ?>
  </label>
    <input type="text" name="<?php echo $this->get_field_name('hearts'); ?>" value="<?php echo $hearts; ?>" class="widefat" id="<?php echo $this->get_field_id('hearts'); ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id('caption'); ?>">
    <?php _e('Caption','your-theme'); ?>
  </label>
    <input type="text" name="<?php echo $this->get_field_name('caption'); ?>" value="<?php echo $caption; ?>" class="widefat" id="<?php echo $this->get_field_id('caption'); ?>" />
</p>
<?php
	}			
	}
 
	function life_meter_widget_init() {
		register_widget('life_meter_widget');
	}

	add_action('widgets_init', 'life_meter_widget_init'); 

}

$wpdpd = new life_meter_widget();

?>
