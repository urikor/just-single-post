<?php
/**
 * Template for big image.
 */
?>

<a href="<?php echo esc_url( get_the_permalink( $post ) ); ?>">
	<h2 class='widget-title'><?php echo esc_html( $post_title ); ?></h2>
</a>
<figure class="item">
	<a href="<?php echo esc_url( get_the_permalink( $post ) ); ?>">
		<div class="img-hold">
			<?php echo get_the_post_thumbnail( $post, $image_size ); ?>
		</div>
		<figcaption>
			<?php if ( $content = get_post_field( 'post_content', $post ) ) : ?>
				<b><span><?php echo wp_trim_words( esc_html( $content ), 30 ); ?></span></b>
			<?php endif; ?>
		</figcaption>
	</a>
</figure>
