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
		
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				// check if the repeater field has rows of data
				if( have_rows('map') ):

					// loop through the rows of data
				while ( have_rows('map') ) : the_row();
				echo '<div class="location-wrapper">';
					echo '<div class="location-information-wrapper">';
						echo '<h3>'; 
							echo the_sub_field('location_title'); 
						echo '</h3>';

						echo '<p>' ;
						echo "Address : ";
							echo  the_sub_field('address');
						echo '</p>';

						echo '<p class="location-phone-num">';
							echo "Call : ";
							echo the_sub_field('phone') ;
						echo '</p>';

					echo '</div>';
					// the_sub_field('hours', );
					if( have_rows('hours') ):
						echo '<div class="open-hour-wrapper">';
							echo '<ul class="open-hours">';
							while ( have_rows('hours') ) : the_row();
								echo '<li>Mon: ' . get_sub_field('monday') . '</li>';
								echo '<li>Tue: ' . get_sub_field('tuesday') . '</li>';
								echo '<li>Wed: ' . get_sub_field('wednesday') . '</li>';
								echo '<li>Thurs: ' . get_sub_field('thursday') . '</li>';
								echo '<li>Fri: ' . get_sub_field('friday') . '</li>';
								echo '<li>Sat: ' . get_sub_field('saturday') . '</li>';
								echo '<li>Sun: ' . get_sub_field('sunday') . '</li>';
							endwhile;
							echo '</ul>';
						echo'</div>';
						echo '</div>';//location-wrapper
					endif;

					// display a sub field value
					$location = get_sub_field('map_site');
				
					if( !empty($location) ):
						?>
						<div class="acf-map">
							<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
						</div>
						
					<?php endif;
		
				endwhile;
			
				else :

				// no rows found

				endif;
				
			endwhile; // End of the loop.
			?>
		
		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
