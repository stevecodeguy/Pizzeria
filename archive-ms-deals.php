<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mindset_Starter
 */

get_header();
?>
<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<header class="page-header">
				<?php
				// the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

    <?php
		$args = array(
			'post_type' => 'ms-deals',
			'posts_per_page' => -1,
		);
		
		$query = new WP_Query($args);
		if($query -> have_posts()){
			while($query ->have_posts()){
			$query ->the_post();
			the_content();
	 }	
	wp_reset_postdata();
}
	?>





            </main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();