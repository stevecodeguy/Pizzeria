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

endwhile; // End of the loop.

//---------------------------------- ABOUT FAMILY REPEATER ---------------------------------------

// check if the repeater field has rows of data
if (have_rows('about_family')):

    // loop through the rows of data
    while (have_rows('about_family')): the_row();

        echo '<div class="">';
        if (get_sub_field('family_photo')) {
            echo wp_get_attachment_image(get_sub_field('family_photo'), 'medium', '', array("class" => "alignleft"));
        }

        the_sub_field('description');
        echo '</div>';
    endwhile;

else:

    // no rows found

endif;

?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
