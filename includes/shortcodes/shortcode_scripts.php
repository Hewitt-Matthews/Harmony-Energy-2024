<?php
	
	
// // // // // // // // // // // // 
// 
// 
// 
// Shortcode/Loop Styles and Scripts Funtions
// 
// 
// 
//  // // // // // // // // // // // 

// // THIS IS NOT CURRENTLY IN USE AND IS ONLY HERE FOR TEMPLATE PURPOSES
// Call in testimonial styles if certain shortcodes are used that requires them
function testimonial_loop_styles() {
    global $post;
	
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'testimonialsLoop') ) {
		wp_enqueue_style( 'testimonial_loop_styles', get_stylesheet_directory_uri() . '/css/testimonial-loop-styles.css');
    }
}
add_action( 'wp_enqueue_scripts', 'testimonial_loop_styles');


?>