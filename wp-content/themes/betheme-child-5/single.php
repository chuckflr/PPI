<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */
?>
<!DOCTYPE html>
<?php 
	if( $_GET && key_exists('mfn-rtl', $_GET) ):
		echo '<html class="no-js" lang="ar" dir="rtl">';
	else:
?>
<html class="no-js<?php echo mfn_user_os(); ?>" <?php language_attributes(); ?><?php mfn_tag_schema(); ?>>
<?php endif; ?>

<!-- head -->
<head>

<!-- meta -->
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php 
	if( mfn_opts_get('responsive') ){
		if( mfn_opts_get('responsive-zoom') ){
			echo '<meta name="viewport" content="width=device-width, initial-scale=1" />';
		} else {
			echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
		}
		 
	}
?>

<?php do_action('wp_seo'); ?>

<link rel="shortcut icon" href="<?php mfn_opts_show( 'favicon-img', THEME_URI .'/images/favicon.ico' ); ?>" />	
<?php if( mfn_opts_get('apple-touch-icon') ): ?>
<link rel="apple-touch-icon" href="<?php mfn_opts_show( 'apple-touch-icon' ); ?>" />
<?php endif; ?>	

<!-- wp_head() -->
<?php wp_head(); ?>
</head>

<!-- body -->
<body <?php body_class(); ?>>
	
	<?php do_action( 'mfn_hook_top' ); ?>

	<?php get_template_part( 'includes/header', 'sliding-area' ); ?>
	
	<?php if( mfn_header_style( true ) == 'header-creative' ) get_template_part( 'includes/header', 'creative' ); ?>
	
	<!-- #Wrapper -->
	<div id="Wrapper">
	
		<?php 
			// Featured Image | Parallax ----------
			$header_style = '';
				
			if( mfn_opts_get( 'img-subheader-attachment' ) == 'parallax' ){
				
				if( mfn_opts_get( 'parallax' ) == 'stellar' ){
					$header_style = ' class="bg-parallax" data-stellar-background-ratio="0.5"';
				} else {
					$header_style = ' class="bg-parallax" data-enllax-ratio="0.3"';
				}
				
			}
		?>
		
		<?php if( mfn_header_style( true ) == 'header-below' ) echo mfn_slider(); ?>

		<!-- #Header_bg -->
		<div id="Header_wrapper" <?php echo $header_style; ?>>
	
			<!-- #Header CLEAR ALL STYLES AND TAKE OUT ECHO "CATEGORY" . POST_CAT-->
			<header id="Header" style="color: white; text-align: center;">
				<?php if( mfn_header_style( true ) != 'header-creative' ) get_template_part( 'includes/header', 'top-area' ); ?>	
				<?php if( mfn_header_style( true ) != 'header-below' ) echo mfn_slider(); ?>
			
				<div class="bg-hdr" style="background-image: url('/wp-content/uploads/sites/2/2017/10/min-hdr.jpg');">
					
					<?php if( get_field('custom_text') ): ?>
						<h2 class="custom-text"><?php the_field('custom_text'); ?></h2>
					<?php endif; ?>

					<?php if( get_field('custom_bottom_text') ): ?>
						<h2 class="custom-bottom-text"><?php the_field('custom_bottom_text'); ?></h2>
					<?php endif; ?>

					<?php

						// $the_query = new WP_Query( $args );
	
						// // The Loop
						// if ( $the_query->have_posts() ) {
						
						// 	while ( $the_query->have_posts() ) {
						// 		$the_query->the_post();
						// 		echo get_post_meta( get_the_ID(), 'meta_box_text', true);
						// 		}
						
							
						// 	/* Restore original Post Data */
						// 	wp_reset_postdata();
						
						// } else {
						
						// echo '';
							
						// }
					?>

				</div>

				<div class="bg-txt">
					<?php the_title( '<h1 style="text-align: right; color: black;">', '</h1>' ); ?>
					<?php if( get_field('custom_text_02') ): ?>
						<!--<h2 class="custom-text-02"></h2>-->
					<?php endif; ?>

				</div>
        
        <svg class="a-t_bottom" x="0" y="0" width="100" height="100" xmlns=http://www.w3.org/2000/svg viewBox="0 0 100 100" preserveAspectRatio="none">
          <defs>
              <clipPath id="a-t_b">
                  <polygon points="0,100 100,0 100,100 0,100" />
              </clipPath>
          </defs>
          <rect x="0" y="0" width="100" height="100" clip-path="url(#a-t_b)" />
       </svg>
				
			</header>
				
			<?php 
				if( ( mfn_opts_get('subheader') != 'all' ) && 
					( ! get_post_meta( mfn_ID(), 'mfn-post-hide-title', true ) ) &&
					( get_post_meta( mfn_ID(), 'mfn-post-template', true ) != 'intro' )	){

					
					$subheader_advanced = mfn_opts_get( 'subheader-advanced' );
					
					$subheader_style = '';
					
					if( mfn_opts_get( 'subheader-padding' ) ){
						$subheader_style .= 'padding:'. mfn_opts_get( 'subheader-padding' ) .';';
					}				
					
					
					if( is_search() ){
						// Page title -------------------------
						
						echo '<div id="Subheader" style="'. $subheader_style .'">';
							echo '<div class="container">';
								echo '<div class="column one">';

									if( trim( $_GET['s'] ) ){
										global $wp_query;
										$total_results = $wp_query->found_posts;
									} else {
										$total_results = 0;
									}

									$translate['search-results'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-results','results found for:') : __('results found for:','betheme');								
									echo '<h1 class="title">'. $total_results .' '. $translate['search-results'] .' '. esc_html( $_GET['s'] ) .'</h1>';
									
								echo '</div>';
							echo '</div>';
						echo '</div>';
						
						
					} elseif( ! mfn_slider_isset() || ( is_array( $subheader_advanced ) && isset( $subheader_advanced['slider-show'] ) ) ){
						// Page title -------------------------
						
						
						// Subheader | Options
						$subheader_options = mfn_opts_get( 'subheader' );


						if( is_home() && ! get_option( 'page_for_posts' ) && ! mfn_opts_get( 'blog-page' ) ){
							$subheader_show = false;
						} elseif( is_array( $subheader_options ) && isset( $subheader_options[ 'hide-subheader' ] ) ){
							$subheader_show = false;
						} elseif( get_post_meta( mfn_ID(), 'mfn-post-hide-title', true ) ){
							$subheader_show = false;
						} else {
							$subheader_show = true;
						}
						
						
						// title
						if( is_array( $subheader_options ) && isset( $subheader_options[ 'hide-title' ] ) ){
							$title_show = false;
						} else {
							$title_show = true;
						}
						
						
						// breadcrumbs
						if( is_array( $subheader_options ) && isset( $subheader_options[ 'hide-breadcrumbs' ] ) ){
							$breadcrumbs_show = false;
						} else {
							$breadcrumbs_show = true;
						}
						
						if( is_array( $subheader_advanced ) && isset( $subheader_advanced[ 'breadcrumbs-link' ] ) ){
							$breadcrumbs_link = 'has-link';
						} else {
							$breadcrumbs_link = 'no-link';
						}
						
						
						// Subheader | Print
						if( $subheader_show ){
							echo '<div id="Subheader" style="'. $subheader_style .'">';
								echo '<div class="container">';
									echo '<div class="column one">';
										
										// Title
										if( $title_show ){
											$title_tag = mfn_opts_get( 'subheader-title-tag', 'h1' );
											echo '<'. $title_tag .' class="title">'. mfn_page_title() .'</'. $title_tag .'>';
										}
										
										// Breadcrumbs
										if( $breadcrumbs_show ){
											mfn_breadcrumbs( $breadcrumbs_link );
										}
										
									echo '</div>';
								echo '</div>';
							echo '</div>';
						}
						
					}
					
					
				}
			?>
		
		</div>
		
		<?php 
			// Single Post | Template: Intro
			if( get_post_meta( mfn_ID(), 'mfn-post-template', true ) == 'intro' ){
				get_template_part( 'includes/header', 'single-intro' );
			}
		?>
		
		<?php do_action( 'mfn_hook_content_before' );?>
		


<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">
			<?php
			
				if( get_post_meta( get_the_ID(), 'mfn-post-template', true ) == 'builder' ){
						
					// Template | Builder -----------------------------------------------
						
					$single_post_nav = array(
						'hide-sticky'	=> false,
						'in-same-term'	=> false,
					);
						
					$opts_single_post_nav = mfn_opts_get( 'prev-next-nav' );
					if( isset( $opts_single_post_nav['hide-sticky'] ) ){
						$single_post_nav['hide-sticky'] = true;
					}

											// single post navigation | sticky
          /*
					if( ! $single_post_nav['hide-sticky'] ){
						if( isset( $opts_single_post_nav['in-same-term'] ) ){
							$single_post_nav['in-same-term'] = true;
						}
							
						$post_prev = get_adjacent_post( $single_post_nav['in-same-term'], '', true );
						$post_next = get_adjacent_post( $single_post_nav['in-same-term'], '', false );
							
						echo mfn_post_navigation_sticky( $post_prev, 'prev', 'icon-left-open-big' ); 
						echo mfn_post_navigation_sticky( $post_next, 'next', 'icon-right-open-big' );
					}
          */
				
					
						
				} else {
						
					// Template | Default -----------------------------------------------
						
					while( have_posts() ){
						the_post();
						get_template_part( 'includes/content', 'single' );
					}
	
				}



			?>
      
      <div class="source-link">
				<?php if( get_field('source_link') ): ?>
          <strong>Sources:</strong><br><br> <?php the_field('source_link'); ?>
				<?php endif; ?>
			</div>
      
		</div>
		
		<!-- .four-columns - sidebar -->
		<?php get_sidebar(); ?>
			
	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags