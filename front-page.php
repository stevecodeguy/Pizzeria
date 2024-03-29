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
                echo wp_get_attachment_image(get_field('deal_image'), 'full', '', array("class" => "deal-slider"));
            }
            echo '</div>';
        }

    }
    wp_reset_postdata();
    echo '</div>';
}

?>

</section>


<!------------------------------------------ Random Product -------------------------------------->

<div class="home-related-products">
    <h2 class="popular-products">Popular products</h2>
<?php echo do_shortcode('[products limit="3" columns="3" orderby="popularity"]'); ?>
</div>


<!------------------------------------------ Instagram Feed -------------------------------------->

<div class="instagram">
    <?php echo do_shortcode('[instagram-feed]'); ?>
    </div>

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
    echo '<div class="testimonial-slider slider">';
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
