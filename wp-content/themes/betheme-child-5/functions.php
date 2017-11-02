<?php

/* ---------------------------------------------------------------------------
 * Child Theme URI | DO NOT CHANGE
 * --------------------------------------------------------------------------- */
define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );


/* ---------------------------------------------------------------------------
 * Define | YOU CAN CHANGE THESE
 * --------------------------------------------------------------------------- */

// White Label --------------------------------------------
define( 'WHITE_LABEL', false );

// Static CSS is placed in Child Theme directory ----------
define( 'STATIC_IN_CHILD', false );


/* ---------------------------------------------------------------------------
 * Enqueue Style
 * --------------------------------------------------------------------------- */
add_action( 'wp_enqueue_scripts', 'mfnch_enqueue_styles', 101 );
function mfnch_enqueue_styles() {
	
	// Enqueue the parent stylesheet
// 	wp_enqueue_style( 'parent-style', get_template_directory_uri() .'/style.css' );		//we don't need this if it's empty
	
	// Enqueue the parent rtl stylesheet
	if ( is_rtl() ) {
		wp_enqueue_style( 'mfn-rtl', get_template_directory_uri() . '/rtl.css' );
	}
	
	// Enqueue the child stylesheet
	wp_dequeue_style( 'style' );
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() .'/style.css' );
	
}


/* ---------------------------------------------------------------------------
 * Load Textdomain
 * --------------------------------------------------------------------------- */
add_action( 'after_setup_theme', 'mfnch_textdomain' );
function mfnch_textdomain() {
    load_child_theme_textdomain( 'betheme',  get_stylesheet_directory() . '/languages' );
    load_child_theme_textdomain( 'mfn-opts', get_stylesheet_directory() . '/languages' );
}




/* ---------------------------------------------------------------------------
 * Custom Meta Box
 * --------------------------------------------------------------------------- */

 function custom_text_box_markup()
{
	    wp_nonce_field(basename(__FILE__), "meta_box_nonce");

    ?>
        <div>
            <label for="meta_box_text">Text</label>
            <input name="meta_box_text" type="text" value="<?php echo get_post_meta($object->ID, "meta_box_text", true); ?>">   
	    </div>
    <?php  
}

function add_custom_text_box()
{
    //add_meta_box("demo-meta-box", "Custom Text Box", "custom_text_box_markup", "page", "side", "high", null);
}

add_action("add_meta_boxes", "add_custom_text_box");

function save_custom_meta_box($post_id, $page, $update)
{
    if (!isset($_POST["meta_box_nonce"]) || !wp_verify_nonce($_POST["meta_box_nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_pages", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "page";
    if($slug != $page->post_type)
        return $post_id;

    $meta_box_text_value = "";

    if(isset($_POST["meta_box_text"]))
    {
        $meta_box_text_value = $_POST["meta_box_text"];
    }   
    update_post_meta($post_id, "meta_box_text", $meta_box_text_value);

}

add_action("save_post", "save_custom_meta_box", 10, 3);


//cruz
function add_attachments_to_categories() {
    
    register_taxonomy_for_object_type( 'category', 'attachment' );

}

add_action( 'init' , 'add_attachments_to_categories' );
//end

function create_post_type_blog()
{
    register_taxonomy_for_object_type('category', 'ppi-blog'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'ppi-blog');
    register_post_type('ppi-blog', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('PPI Blog', 'BeTheme'), // Rename these to suit
            'singular_name' => __('PPI Blog', 'BeTheme'),
            'add_new' => __('Add New', 'BeTheme'),
            'add_new_item' => __('Add New PPI Blog', 'BeTheme'),
            'edit' => __('Edit', 'BeTheme'),
            'edit_item' => __('Edit PPI Blog', 'BeTheme'),
            'new_item' => __('New PPI Blog', 'BeTheme'),
            'view' => __('View PPI Blog', 'BeTheme'),
            'view_item' => __('View PPI Blog', 'BeTheme'),
            'search_items' => __('Search PPI Blog', 'BeTheme'),
            'not_found' => __('No PPI Blog found', 'BeTheme'),
            'not_found_in_trash' => __('No PPI Blog in Trash', 'BeTheme')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'rewrite' => array('slug' => 'ppi-blog', 'with_front' => false), // custom url slug (path)
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ),
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

add_action('init', 'create_post_type_blog'); // Add our PPI Blog Custom Post Type


function betheme_child_styles()
{
    wp_register_style( 'Font_Awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
    wp_enqueue_style('Font_Awesome');
}
add_action('init', 'betheme_child_styles', 10, 2);

/* ---------------------------------------------------------------------------
 * Override theme functions
 * 
 * if you want to override theme functions use the example below
 * --------------------------------------------------------------------------- */
// require_once( get_stylesheet_directory() .'/includes/content-portfolio.php' );






/**
 * Use radio inputs instead of checkboxes for term checklists in specified taxonomies.
 *
 * @param   array   $args
 * @return  array
 */
function wpse_139269_term_radio_checklist( $args ) {
    if ( ! empty( $args['taxonomy'] ) && $args['taxonomy'] === 'category' /* <== Change to your required taxonomy */ ) {
        if ( empty( $args['walker'] ) || is_a( $args['walker'], 'Walker' ) ) { // Don't override 3rd party walkers.
            if ( ! class_exists( 'WPSE_139269_Walker_Category_Radio_Checklist' ) ) {
                /**
                 * Custom walker for switching checkbox inputs to radio.
                 *
                 * @see Walker_Category_Checklist
                 */
                class WPSE_139269_Walker_Category_Radio_Checklist extends Walker_Category_Checklist {
                    function walk( $elements, $max_depth, $args = array() ) {
                        $output = parent::walk( $elements, $max_depth, $args );
                        $output = str_replace(
                            array( 'type="checkbox"', "type='checkbox'" ),
                            array( 'type="radio"', "type='radio'" ),
                            $output
                        );

                        return $output;
                    }
                }
            }

            $args['walker'] = new WPSE_139269_Walker_Category_Radio_Checklist;
        }
    }

    return $args;
}

add_filter( 'wp_terms_checklist_args', 'wpse_139269_term_radio_checklist' );
add_filter( 'wp_terms_checklist_args', 'wpse_139269_term_radio_checklist_start_el_version', 10, 2 );
function wpse_139269_term_radio_checklist_start_el_version( $args, $post_id ) {
    if ( ! empty( $args['taxonomy'] ) && $args['taxonomy'] === 'YOUR-TAXONOMY' ) {
        if ( empty( $args['walker'] ) || is_a( $args['walker'], 'Walker' ) ) { // Don't override 3rd party walkers.
            if ( ! class_exists( 'WPSE_139269_Walker_Category_Radio_Checklist_Start_El_Version' ) ) {
                class WPSE_139269_Walker_Category_Radio_Checklist_Start_El_Version extends Walker_Category_Checklist {
                    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
                        if ( empty( $args['taxonomy'] ) ) {
                            $taxonomy = 'category';
                        } else {
                            $taxonomy = $args['taxonomy'];
                        }

                        if ( $taxonomy == 'category' ) {
                            $name = 'post_category';
                        } else {
                            $name = 'tax_input[' . $taxonomy . ']';
                        }

                        $args['popular_cats'] = empty( $args['popular_cats'] ) ? array() : $args['popular_cats'];
                        $class = in_array( $category->term_id, $args['popular_cats'] ) ? ' class="popular-category"' : '';

                        $args['selected_cats'] = empty( $args['selected_cats'] ) ? array() : $args['selected_cats'];

                        /** This filter is documented in wp-includes/category-template.php */
                        if ( ! empty( $args['list_only'] ) ) {
                            $aria_cheched = 'false';
                            $inner_class = 'category';

                            if ( in_array( $category->term_id, $args['selected_cats'] ) ) {
                                $inner_class .= ' selected';
                                $aria_cheched = 'true';
                            }

                            $output .= "\n" . '<li' . $class . '>' .
                                '<div class="' . $inner_class . '" data-term-id=' . $category->term_id .
                                ' tabindex="0" role="checkbox" aria-checked="' . $aria_cheched . '">' .
                                esc_html( apply_filters( 'the_category', $category->name ) ) . '</div>';
                        } else {
                            $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" .
                            '<label class="selectit"><input value="' . $category->term_id . '" type="radio" name="'.$name.'[]" id="in-'.$taxonomy.'-' . $category->term_id . '"' .
                            checked( in_array( $category->term_id, $args['selected_cats'] ), true, false ) .
                            disabled( empty( $args['disabled'] ), false, false ) . ' /> ' .
                            esc_html( apply_filters( 'the_category', $category->name ) ) . '</label>';
                        }
                    }
                }
            }
            $args['walker'] = new WPSE_139269_Walker_Category_Radio_Checklist_Start_El_Version;
        }
    }
    return $args;
}
