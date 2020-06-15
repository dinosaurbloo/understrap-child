<?php
/**
 * The front-page template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>
<!-- The page post from the page itself. 
//   Deliberately declines to show the page heading so might 
//   want to add a heading within the post where appropriate.  -->

<!-- Get the post -->
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'loop-templates/content', 'page' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
						comments_template();
				endif;?>
			<?php endwhile; ?>
<!-- // end of the loop.  -->
<!-- Now the page post and top widgets are out of the way we can open the main container-->

<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">		
	<main class="site-main" id="main">

<!--We're going to show 3 news headlines in a grid based card row
/*  It uses 'preview-card-holder rather than 'row' to display since
/*	I want a justified content using css-grid -->
<!--The wp_query
/*	As the news_item is a custom post type on this site using the CPT plug in
/*	We're going to use a custom query and then filter on headlines, borrow's heavily from
/*	Chip Bennett answer in
/*	https://wordpress.stackexchange.com/questions/120407/how-to-fix-pagination-for-custom-loops 
/*	and https://wordpress.stackexchange.com/a/84923/149559 from eugene manuilov (it so hurts to hat tip
/*	a united fan - or at least someone who ought to be one with that name)
/*	answer to filter a custom post query. In this instance there will be some news_items,
/*	typically facebook and twitter embeds that just don't work as excerpts so I want to 
//	manually assign those news_items as 'headlines' that I will show on the front-page-->
	
<section id="latest-headlines"><!--Opens the section  -->
	<h2 class="text-center">Latest Headlines<h2> 	
		<div class="preview-card-holder">
        
		<?php
  	// Define custom query parameters
  			$custom_query_args = array( 
		  		'post_type' => 'news_item', 
		  		'posts_per_page' => 3,
		  		'tax_query' => array(
					array (
							'taxonomy' => 'news_section',
							'field' => 'slug',
							'terms' => 'headline',
							)
						),		
					);
	
	// Instantiate custom query
			$custom_query = new WP_Query( $custom_query_args );
	
	// Output custom query loop
				if ( $custom_query->have_posts() ) {
				while ( $custom_query->have_posts() ) {
				$custom_query->the_post();
			
					get_template_part( 'loop-templates/content', 'news' );
				}
			}
//enable wp_query to be used again
    				wp_reset_postdata(); ?>
		</div><!-- /preview-card-holder -->
		<div class="text-center mt-4">
		<a class="btn btn-primary" href="https://www.gorsehill-labour.co.uk/GorseTalk/news-archive/" role="button">All News</a>
		</div>
</section><!-- / latest headlines -->

<!-- Latest post 
// 	Another wp_query to pull and feature the latest post. We're going to show full content on the latest
//	and then we'll have three excerpts similarly formatted to the news items above.
-->


<section id="latest-post">
<h2 class="text-center" style="margin-top:8rem;">The Blog</h2>
<h3 class="text-muted text-center">The focus is primarily on what I've been doing, informed by my politics.</h3>
<h2 class="text-center" style="margin-top:8rem;">Latest Post</h2>
<?php
	$args = array(
        'posts_per_page' => 1
	);
		$query = new WP_query ( $args );
		
		if ( $query->have_posts() ) { ?>
		
			<?php /* Start the Loop */ ?>
				<?php while ( $query->have_posts() ) { $query->the_post(); 

			get_template_part( 'loop-templates/content', 'single' );

	}//endwhile
}//endif
wp_reset_postdata(); ?>
<div class="text-center mt-4">
		<a class="btn btn-primary" href="https://www.gorsehill-labour.co.uk/GorseTalk/blog-2/" role="button">All the blog-posts</a>
		</div>
</section>
<!-- Display last posts 2,3 and 4 in carded excerpts. The first one is shown in full content form above  -->

<section id="recent-posts">
	<h2 class="text-center" style="margin-top:8rem">A few more recent posts<h2>		
	<div class="preview-card-holder">
	<?php
		$args = array(
			'posts_per_page'  => 3,
			'offset'          => 1 //skipping the first post
						);
		$query = new WP_query ( $args );
			if ( $query->have_posts() ) { ?>
			    <?php /* Start the Loop */ ?>
					<?php while ( $query->have_posts() ) { 
						$query->the_post();
							get_template_part( 'loop-templates/content', 'news' );
															}//endwhile
														}//endif
    						wp_reset_postdata(); ?>  
	</div><!-- /preview-card-holder -->
	<div class="text-center mt-4">
		<a class="btn btn-primary" href="https://www.gorsehill-labour.co.uk/GorseTalk/blog-2/" role="button">All the blog-posts</a>
		</div>
</section>
</main>
</div>


  


<?php get_footer();
