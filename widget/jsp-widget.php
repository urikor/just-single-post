<?php
/**
 * Just Single Post Widget.
 * Class JSP_Widget
 *
 * @package Wordpress.
 */

/**
 * Class JSP_Widget
 */
class JSP_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct( 'jsp_widget', 'Just Single Post Widget',
			array( 'description' => 'A simple widget to show single post' )
		);
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 * @param array $instance Previously saved values from database.
	 * @return mixed
	 *   Print form.
	 */
	public function form( $instance ) {
		$title     = ! empty ( $instance['title'] ) ? esc_html( $instance['title'] ) : '';
		$auto_text = ! empty ( $instance['auto_text'] ) ? esc_html( $instance['auto_text'] ) : '';
		$layout    = ! empty ( $instance['layout'] ) ? esc_html( $instance['layout'] ) : 'big';

		$titleId   = $this->get_field_id( 'title' );
		$titleName = $this->get_field_name( 'title' );
		echo '<label for="' . $titleId . '">' . __( 'Title' ) . '</label><br>';
		echo '<input id="' . $titleId . '"
			type="text" name="' . $titleName . '" value="' . $title . '" style="width:100%"><br>';

		$titleId   = $this->get_field_id( 'auto_text' );
		$titleName = $this->get_field_name( 'auto_text' );
		echo '<label for="' . $titleId . '">' . __( 'Post' ) . '</label><br>';
		echo '<input id="' . $titleId . '" class="posts-choose"
			type="text" name="' . $titleName . '" value="' . $auto_text . '" style="width:100%"><br>';
		echo '<div class="posts-replace"></div>';

		$layoutId   = $this->get_field_id( 'layout' );
		$layoutName = $this->get_field_name( 'layout' );
		echo '<label for="' . $layoutId . '">' . __( 'Choose kind of layout' ) . '</label><br>';
		echo '<select id="' . $layoutId . '" name="' . $layoutName . '">';
			echo '<option ' . selected( $layout, 'big' ) . 'value="big">' . __( 'Big title and image' ) . '</option>';
			echo '<option ' . selected( $layout, 'left' ) . 'value="left">' . __( 'Image left' ) . '</option>';
			echo '<option ' . selected( $layout, 'right' ) . 'value="right">' . __( 'Image right' ) . '</option>';
		echo '</select><br>';
	}

	/**
	 * Updates widget variables.
	 *
	 * @param array $newInstance New value.
	 * @param array $oldInstance Old value.
	 * @return array
	 */
	public function update( $newInstance, $oldInstance ) {
		$values              = array();
		$values['title']     = htmlentities( $newInstance['title'] );
		$values['auto_text'] = htmlentities( $newInstance['auto_text'] );
		$values['layout']    = htmlentities( $newInstance['layout'] );

		return $values;
	}

	/**
	 * Widget output.
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Values array.
	 */
	public function widget( $args, $instance ) {

		$post   = ! empty ( $instance['auto_text'] ) && is_numeric( $instance['auto_text'] ) ? $instance['auto_text'] : null;
		$layout = ! empty ( $instance['layout'] ) ? $instance['layout'] : 'big';

		if ( $post ) {
			$post_title = ( $tit = get_the_title( $post ) ) ? $tit : null;
			$image_size = ( 'big' === $layout ) ? 'medium' : 'thumbnail';

			echo $args['before_widget'];

			if ( isset( $post ) ) {
				echo '<div class="info ' . esc_html( $layout ) . '">';
				if ( 'big' === $layout ) {
					include plugin_dir_path( __FILE__ ) . 'tpl/big.php';
				} else {
					include plugin_dir_path( __FILE__ ) . 'tpl/left-right.php';
				}
				echo '</div>';
			}

			echo $args['after_widget'];
		}
	}
}

/**
 * Register the widget.
 */
function jsp_register() {
	register_widget( 'JSP_Widget' );
}
add_action( 'widgets_init', 'jsp_register' );
