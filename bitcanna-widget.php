<?php
/*
Plugin Name: Bitcanna Widget
Plugin URI: https://cosmos-tool.com/
Description: Add a widget that displays your bcna address in the site footer 
Version: 1.1.11
Author: atmon3r
Author URI: http://cosmos-tool.com/
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
* Currently plugin version.
* Start at version 1.0.0 and use SemVer - https://semver.org
* Rename this for your plugin and update it as you release new versions.
*/
define( 'BITCANNA_WIDGET', '1.1.11' );

// The widget class
class Bitcanna_Widget extends WP_Widget {

	// Main constructor
	public function __construct() {
		parent::__construct(
			'bitcanna_widget',
			__( 'Bitcanna Widget', 'text_domain' ),
			array(
				'customize_selective_refresh' => true,
			)
		);
	}

	// The widget form (for the backend )
	public function form( $instance ) {

		// Set widget defaults
		$defaults = array(
			'title'    => '',
			'text'     => '',
		);
		
		// Parse current settings with defaults
		extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

		<?php // Widget Title ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php // Text Field ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Bcna adresse:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
		</p>

	<?php }

	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['text']     = isset( $new_instance['text'] ) ? wp_strip_all_tags( $new_instance['text'] ) : '';
		return $instance;
	}

	// Display the widget
	public function widget( $args, $instance ) {

		extract( $args );

		// Check the widget options
		$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$text     = isset( $instance['text'] ) ? $instance['text'] : '';

		// WordPress core before_widget hook (always include )
		echo $before_widget;

		// Display the widget
		$imgPath = plugin_dir_url(__FILE__)."img/4263.png";
		echo '<div align="center" id="content_sc" class="widget-text wp_widget_plugin_box"><img src="'.esc_attr($imgPath).'" /><div>';

			// Display widget title if defined
			if ( $title ) {
				echo $before_title . esc_attr($title) . $after_title;
			}

			// Display text field
			if ( $text ) {
				echo '<br /><p>' . esc_attr($text) . '</p>';
			}

		echo '</div></div>';

		// WordPress core after_widget hook (always include )
		echo $after_widget;

	}

}

function add_bitcanna_css() {
    wp_enqueue_style(
		'bitcannaCss',
		plugin_dir_url(__FILE__).'css/bitcanna.css'
	);	
}
	add_action( 'wp_enqueue_scripts', 'add_bitcanna_css' );

// Register the widget
function my_register_bitcanna_widget() {
	register_widget( 'Bitcanna_Widget' );
}
add_action( 'widgets_init', 'my_register_bitcanna_widget' ); 
