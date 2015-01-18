<?php



class PXLSRecentPostsWidget extends WP_Widget {
	function PXLSRecentPostsWidget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'pxls-recent-posts', 'description' => 'A widget that shows recent posts in a sidebar in a specific visual manner.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'pxls-recent-posts-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'pxls-recent-posts-widget', 'PXLS Recent Posts Widget', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
		$numberposts = $instance['numberposts'];
		$title = $instance['title'];


		echo '<ul>';

		$args = array( 'numberposts' => $numberposts );
		$recent_posts = wp_get_recent_posts( $args );

		echo '<h3>' . $title . '</h3>';
		
		foreach( $recent_posts as $recent ){
			echo '<li>';
			echo '<a href="' . get_permalink( $recent["ID"] ) . '" title="Look ' . esc_attr( $recent["post_title"] ) . '" >' . $recent["post_title"] . '</a>';
			echo '</li> ';
		}

		echo '</ul>';
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['numberposts'] = strip_tags( $new_instance['numberposts'] );

		return $instance;
	}
	
	
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'numberposts' => '5' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'numberposts' ); ?>">Number of Posts:</label>
			<input id="<?php echo $this->get_field_id( 'numberposts' ); ?>" name="<?php echo $this->get_field_name( 'numberposts' ); ?>" value="<?php echo $instance['numberposts']; ?>" style="width:100%;" />
		</p>


<?php
	}
}

function load_pxls_recent_posts_widget() {
	register_widget( 'PXLSRecentPostsWidget' );
}
add_action( 'widgets_init', 'load_pxls_recent_posts_widget' );

