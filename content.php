<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<div class="card shadow">
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<div class="card-body">

	<header class="entry-header">

		<?php
		the_title(
			sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></h2>'
		);
		?>

		<?php if ( 'post' == get_post_type() ) : ?>

			<div class="entry-meta">
				<?php understrap_posted_on(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->
</div>

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
	<div class="card-body">

	<div class="entry-content text-black-50">

		<?php the_excerpt(); ?>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
				'after'  => '</div>',
			)
		);
		?>

	</div><!-- .entry-content -->
	</div>

	<footer class="entry-footer">
<div class="card-body">
		<?php understrap_entry_footer(); ?>
	</div>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
</div>
