<?php
/**
 * The template for displaying Location Page
 *
 * This is the template that displays the location page.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package lmpizza
 */

get_header();
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAp6PoLDNvrN3WlJh9qsKwGJyrsPuTPhZo"></script>

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			$location1 = get_field('map_site_1');
			
			if( !empty($location1) ):
				?>
				<div class="acf-map">
					<div class="marker" data-lat="<?php echo $location1['lat']; ?>" data-lng="<?php echo $location1['lng']; ?>"></div>
				</div>
			<?php endif;

			$location2 = get_field('map_site_2');

			if( !empty($location2) ):
			?>
				<div class="acf-map">
					<div class="marker" data-lat="<?php echo $location2['lat']; ?>" data-lng="<?php echo $location2['lng']; ?>"></div>
				</div>
			<?php endif;
			
		endwhile; // End of the loop.
		?>
		
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
