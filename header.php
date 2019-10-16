<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package lmpizza
 */

?>
<!doctype html>
<html <?php language_attributes();?>>
<head>
	<meta charset="<?php bloginfo('charset');?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head();?>
</head>

<body <?php body_class();?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'lmpizza');?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
		<?php do_action('apply_header_images'); ?>
			<?php
			
if (function_exists('the_custom_logo')) {
    the_custom_logo();
}

the_header_image_tag();

if (is_front_page() && is_home()):
?>
				<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name');?></a></h1>
				<?php
else:
?>

				<?php
endif;
$lmpizza_description = get_bloginfo('description', 'display');
if ($lmpizza_description || is_customize_preview()):
?>
			<?php endif;?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<?php esc_html_e('Menu', 'lmpizza');?>
			</button>
			<?php
			wp_nav_menu(array(
				'theme_location' => 'menu-1',
				'menu_id' => 'primary-menu',
			));
			?>
		</nav><!-- #site-navigation -->

		<nav id="product-navigation" class="product-navigation">
			<?php
			

				// check if the repeater field has rows of data
				if( have_rows('product_menu','options') ):
			
					 // loop through the rows of data
					while ( have_rows('product_menu','options') ) : the_row();
						// display a sub field value
					
								
					
						if(get_sub_field('icon') ): ?>
						
						
					<div class="icon-wrapper">
						<?php $term = get_sub_field('link');//check taxonomy link
								if($term):?>
									<a href="<?php echo get_term_link($term->term_id, 'product_cat')?>">
									
								 <?php elseif(get_sub_field('link-2')):?><!-- if it's not taxonomy then check page link -->
									<a href= " <?php the_sub_field('link-2') ?>">
								<?php else:?>
									<a href="#">
								<?php endif; ?>
						
						<div class="icon">
							<?php the_sub_field('icon')?></a>					
						</div>
					</div>
				<?php
					 endif;
								
					endwhile;
					
				else :
				
					// no rows found
				
				endif;
			
			


?>
		</nav><!-- #site-navigation -->


	</header><!-- #masthead -->

	<div id="content" class="site-content">
