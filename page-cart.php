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
	<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script> -->

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
while (have_posts()):
    the_post();

    get_template_part('template-parts/content', 'page');

    // If comments are open or we have at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()):
        comments_template();
    endif;

    if (function_exists('get_field')) {

    }

endwhile; // End of the loop.
?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
