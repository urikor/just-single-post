<?php
/**
 * Template for thumbnail float image.
 */
?>

<a href="<?php echo esc_url( get_the_permalink( $post ) ); ?>">
	<?php if ( $content = get_post_field( 'post_content', $post ) ) : ?>
		<div class="description">
			<?php echo wp_trim_words( esc_html( $content ), 30 ); ?>
		</div>
	<?php endif; ?>
	<?php echo get_the_post_thumbnail( $post, $image_size ); ?>
</a>

