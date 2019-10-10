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

//---------------------------------- ABOUT FAMILY CUSTOM FIELD ---------------------------------------
echo "<div class='about-family-info-wrapper'>";

echo "<ul class='about-family-contain-1'>";

if (function_exists('get_field')){
    if(get_field('about_family_images_1')){
        echo "<li class='about-family-img-1'>";
            echo wp_get_attachment_image(get_field('about_family_images_1'), 'large', '', array("class" => "alignleft"));
        echo"</li>"; 
    };
};
if(function_exists('get_field')){
    if(get_field('about_family_text_1')){
        echo "<li class='about-family-text'>";
            the_field('about_family_text_1');
        echo"</li>";
    }
}
echo"</ul>";// end about-family-contain-1


echo "<ul class='about-family-contain-2'>";

if (function_exists('get_field')){
    if(get_field('about_family_images_2')){ 
        echo "<li class='about-family-img-2'>";
            echo wp_get_attachment_image(get_field('about_family_images_2'), 'large', '', array("class" => "alignright"));
        echo"</li>"; 
    };
};
if(function_exists('get_field')){
    if(get_field('about_family_text_2')){
        echo "<li class='about-family-text'>"; 
            the_field('about_family_text_2');
         echo"</li>";
    }
}
echo"</ul>";// end about-family-contain-2

echo"</div>";// end image wrapper

?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
