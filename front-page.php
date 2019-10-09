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


<!------------------------------------------ Deals Slider -------------------------------------->


<section class="front-slider">

<?php

$args = array('post_type' => 'ms-deals', 'posts_per_page' => -1);
$query = new WP_Query($args);
if ($query->have_posts()) {
    echo '<div class="deal-slider slider">';
    while ($query->have_posts()) {
        $query->the_post();
        the_content();

        if (function_exists('get_field')) {

            echo '<div class="deal-image">';
            if (get_field('deal_image')) {
                echo wp_get_attachment_image(get_field('deal_image'), 'large', '', array("class" => "alignleft"));
            }
            echo '</div>';
        }

    }
    wp_reset_postdata();
    echo '</div>';
}

?>

</section>


<!------------------------------------------ Instagram Feed -------------------------------------->

    <?php echo do_shortcode('[instagram-feed]'); ?>


<!------------------------------------------ Testimonials Slider -------------------------------------->

<section class="front-slider">

<?php if (function_exists('get_field')) {

    if (get_field('testimonials')) {
        echo '<h2 class="testimonials-title">';
        the_field('testimonials');
        echo '</h2>';
    }
}
?>

<?php

$args = array('post_type' => 'ms-testimonial', 'posts_per_page' => -1);
$query = new WP_Query($args);
if ($query->have_posts()) {
    echo '<div class="slider">';
    while ($query->have_posts()) {
        echo '<div class="testimonial-slider">';
        $query->the_post();
        the_content();
        echo '</div>';
    }
    wp_reset_postdata();
    echo '</div>';
}

?>

</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
