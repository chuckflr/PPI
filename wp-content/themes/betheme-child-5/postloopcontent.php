<?php

// Standard Post Format

?>
	<?php 
			$bg_color = "";
			$bg_hdr_color = "";
			$categories = get_the_category();
      $post_cat = $categories[0]->name;
			
			if($post_cat == "Breaking News"){
        $bg_color = "#F16051";
				$bg_hdr_color = "#F58E83";
      } else if($post_cat == "Newsletter"){
        $bg_color = "#1B7AA9";
				$bg_hdr_color = "#27A2DE";
      } else if($post_cat == "Employment Law Updates"){
        $bg_color = "#FF9F11";
				$bg_hdr_color = "#FFBF5D";
      } else if($post_cat == "New Features"){
        $bg_color = "#389A80";
				$bg_hdr_color = "#4FBF9F";
      } else {
        $bg_color = "gainsboro";
				$bg_hdr_color = "hsl(0, 0%, 90%)";
      }
	?>
    <div class="column one-third" style="background-color: <?php echo $bg_hdr_color; ?>;">

            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="nws-img">
                <?php 
										if($post_cat == "Breaking News"){
                        echo "<img src='/wp-content/uploads/sites/2/2017/10/breaking_news.svg'>";
                    } else if($post_cat == "Newsletter"){
                        echo "<img src='/wp-content/uploads/sites/2/2017/10/newsletter.svg'>";
                    } else if($post_cat == "Employment Law Updates"){
                        echo "<img src='/wp-content/uploads/sites/2/2017/10/employment_law_updates.svg'>";
                    } else if($post_cat == "New Features"){
                        echo "<img src='/wp-content/uploads/sites/2/2017/10/iconfinder-icon.svg'>";
                    } else {
                        echo "<img src='/wp-content/uploads/sites/2/2017/10/other.svg'>";
                    }

                    
                ?>
            </a>

		
        <div class="content-box" style="background-color: ;">
<h1>
                <?php 
										if($post_cat == "Breaking News"){
                        echo "Breaking News";
                    } else if($post_cat == "Newsletter"){
                        echo "Newsletter";
                    } else if($post_cat == "Employment Law Updates"){
                        echo "Employment Law Updates";
                    } else if($post_cat == "New Features"){
                        echo "New Features";
                    } else {
                        echo "Other";
                    }
                ?>
            </h1>
            <h2> <a href="<?php the_permalink(); ?>" > <?php the_title(); ?> </a> </h2>
			<?php echo "<small class='postdate'>" . get_the_date() . "</small>"; ?>
            <?php the_excerpt(); ?>

        </div>
    
    </div>