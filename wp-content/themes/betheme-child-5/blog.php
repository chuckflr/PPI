<?php 
/*
Template Name: News Blog Page 
*/ 
get_header(); ?>

<div id="blog-post-wrapper" class="section_wrapper">
    <div class="column three-fourth">
        <?php 

            $currentPage = get_query_var('paged');

            $args = array(
                'post_type' => 'post',
                'order' => 'DESC', 
                'posts_per_page' => 9,
                'paged' => $currentPage
            );

            $the_query = new WP_Query($args);
            if($the_query -> have_posts()): 
                while ($the_query -> have_posts()): $the_query -> the_post();
                    get_template_part('postloopcontent', get_post_format());
                endwhile;
            echo "<div class='pagination'>";
               echo paginate_links(array(
                    'total' => $the_query -> max_num_pages
                ));
            echo "</div>";
            endif;
        ?>
    </div>

    
        <!-- .four-columns - sidebar -->
		<?php get_sidebar(); ?>

   

</div>

<?php get_footer(); ?>