<?php

require_once __DIR__ . '/../../functions.php';

/******************************************************************************************
 * People
 ******************************************************************************************/
function getPeople() {
	
	$posts = array();
	
  $location = $_GET["location"] ?? NULL;
  $team = $_GET["team"] ?? NULL;

  $tax_query = array();

  $meta_query = array(
    'relation' => 'AND',
    array(
      'key' => 'is_ceo',
      'value' => true,
      'compare' => '!=',
      'type' => 'BOOLEAN',
    )
  );

	if ( $location ) :

		$meta_query[] = array(
      'key'		=> 'office',
      'value'		=> $location,
      'compare'	=> 'LIKE'
    );

	endif;

  if ( $team ) :

    $tax_query[] = array(
      'taxonomy' => 'team',
      'terms' => $team,
      'field' => 'id',
      'operator' => 'IN'
    );

	endif;

  $peopleQuery = new WP_Query([
		'post_type' => 'people',
		'posts_per_page' => -1,
		'post_status' => 'publish',
    'orderby' => 'menu_order',
	  'order' => 'ASC',
		'meta_query' => $meta_query,
    'tax_query' => $tax_query
	]);

	while ( $peopleQuery->have_posts() ) : $peopleQuery->the_post();
	
    $image = wp_get_attachment_image_url( get_post_thumbnail_id(get_the_id()), "large");

		$position = get_field('position');

		array_push($posts, array(
			"title" => html_entity_decode(get_the_title()),
			"id" => get_the_ID(),
			"position" => $position,
			"image" => $image,
      "content" => get_the_content()
		));
	
	endwhile;

	return array(
		"posts" => $posts,
    "total" => $peopleQuery->max_num_pages
	);

}
// /wp-json/he/v1/people/posts/
add_action( 'rest_api_init', function () {
	register_rest_route( 'he/v1', '/people/posts/', array(
		'methods' => 'GET',
		'callback' => 'getPeople',
	));
});

function getCEO() {
	
	$posts = array();
	
  $location = $_GET["location"] ?? NULL;

  $meta_query = array(
    'relation' => 'AND',
    array(
      'key' => 'is_ceo',
      'value' => true,
      'compare' => '=',
      'type' => 'BOOLEAN',
    )
  );

	if ( $location ) :

		$meta_query[] = array(
      'key'		=> 'office',
      'value'		=> $location,
      'compare'	=> '='
    );

	endif;

  $peopleQuery = new WP_Query([
		'post_type' => 'people',
		'posts_per_page' => 1,
		'post_status' => 'publish',
    'orderby' => 'menu_order',
	  'order' => 'ASC',
		'meta_query' => $meta_query
	]);

	while ( $peopleQuery->have_posts() ) : $peopleQuery->the_post();
	
    $image = wp_get_attachment_image( get_post_thumbnail_id(get_the_id()), "large", true, array( "loading" => "lazy" ) );
	$bgimage = wp_get_attachment_image_url( get_post_thumbnail_id(get_the_id()), "large");

		$position = get_field('position');
    $quote = get_field('quote');

		array_push($posts, array(
			"title" => html_entity_decode(get_the_title()),
			"id" => get_the_ID(),
			"position" => $position,
			"image" => $image,
			"bgimage" => $bgimage,
      "content" => get_the_content(),
      "quote" => $quote
		));
	
	endwhile;

	return array(
		"posts" => $posts,
    "total" => $peopleQuery->max_num_pages
	);

}
// /wp-json/he/v1/people/ceo/
add_action( 'rest_api_init', function () {
	register_rest_route( 'he/v1', '/people/ceo/', array(
		'methods' => 'GET',
		'callback' => 'getCEO',
	));
});

/******************************************************************************************
 * Projects
 ******************************************************************************************/
function getProjects() {
	
	$posts = array();

  $location = $_GET["location"] ?? NULL;
  $type = $_GET["type"] ?? NULL;
  $status = $_GET["status"] ?? NULL;

  $tax_query = array();
  $meta_query = array();

  if ( $location ) :

		$tax_query[] = array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'project-location',
        'field'    => 'id',
        'terms'    => $location,
        'operator' => 'IN'
      )
		);

	endif;

  if ( $type ) :

    $meta_query[]	= array(
			'relation' => 'AND',
			array(
				'key'		=> 'project_type',
        'value'		=> $type,
        'compare'	=> '='
			)
		);

  endif;

  if ( $status ) :

    $tax_query[] = array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'project-status',
        'field'    => 'id',
        'terms'    => $status,
        'operator' => 'IN'
      )
		);

  endif;

  $query = new WP_Query([
		'post_type' => 'he-projects',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'orderby' => 'menu_order',
    'order' => 'ASC',
		'meta_query' => $meta_query,
    'tax_query' => $tax_query
	]);

	while ( $query->have_posts() ) : $query->the_post();
	
    $post_id = get_the_ID();
    $name = get_the_title();
    $statuses = get_the_terms($post_id, 'project-status');
    $project_type_id = get_field('project_type');
    $project_type = get_the_title($project_type_id);

		array_push($posts, array(
			"title" => html_entity_decode(get_the_title()),
			"id" => get_the_ID(),
      "type" => $project_type,
      "power" => get_field('project_power'),
      "location" => get_field('project_specific_location_name'),
      "info" => get_field('project_info'),
			"statuses" => $statuses
		));
	
	endwhile;

	return array(
		"posts" => $posts,
    "total" => $query->max_num_pages
	);

}
// /wp-json/he/v1/projects/posts/
add_action( 'rest_api_init', function () {
	register_rest_route( 'he/v1', '/projects/posts/', array(
		'methods' => 'GET',
		'callback' => 'getProjects',
	));
});

/******************************************************************************************
 * Blog
 ******************************************************************************************/
function getPosts($request) {
	
	$posts = array();
	$offset = isset($_GET["offset"]) && !empty($_GET["offset"]) ? $_GET["offset"] : 0;
	
	$service = isset($_GET["category"]) ? $_GET["category"] : 'all';
	$author = isset($_GET["authorinfo"]) ? $_GET["authorinfo"] : 'all';
	
	if ( $service == 'all' && $author == 'all' ) :
	
		$query = new WP_Query([
			'post_type' => 'post',
			'posts_per_page' => 9,
			'post_status' => 'publish',
			'offset' => $offset
		]);
	
	elseif ( $service != 'all' && $author == 'all' ) :
	
		$query = new WP_Query([
			'post_type' => 'post',
			'posts_per_page' => 9,
			'post_status' => 'publish',
			'offset' => $offset,
			'meta_query' => array(				
				array(
					'key' => 'services',
					'value' => $service,
					'compare' => 'LIKE',
				)
			)
		]);
	
	elseif ( $service == 'all' && $author != 'all' ) :
	
		$query = new WP_Query([
			'post_type' => 'post',
			'posts_per_page' => 9,
			'post_status' => 'publish',
			'offset' => $offset,
			'meta_query' => array(				
				array(
					'key' => 'item_author',
					'value' => $author,
					'compare' => 'LIKE',
				)
			)
		]);
	
	else : 
	
		$query = new WP_Query([
			'post_type' => 'post',
			'posts_per_page' => 9,
			'post_status' => 'publish',
			'offset' => $offset,
			'meta_query' => array(
				'relation' => 'AND',				
				array(
					'key' => 'services',
					'value' => $service,
					'compare' => 'LIKE',
				),
				array(
					'key' => 'item_author',
					'value' => $author,
					'compare' => 'LIKE',
				)
			)
		]);
	
	endif;

	while ( $query->have_posts() ) : $query->the_post();
	
		array_push($posts, array(
			"title" => html_entity_decode(get_the_title()),
			"link" => get_the_permalink(),
			"excerpt" => get_the_excerpt(),
			"image" => wp_get_attachment_image( get_post_thumbnail_id(get_the_ID()), 'large', false, "" )
		));
	
	endwhile;

	return array(
		"posts" => $posts,
		"offset" => $offset,
		"noMorePosts" => count($posts) == 0
	);

}
// /wp-json/project/v1/blog/posts/
add_action( 'rest_api_init', function () {
	register_rest_route( 'project/v1', '/blog/posts/', array(
		'methods' => 'GET',
		'callback' => 'getPosts',
	));
});

/******************************************************************************************
 * Case Studies
 ******************************************************************************************/
function getCaseStudies($request) {
	
	$posts = array();
	// $offset = htmlspecialchars($_GET["offset"]);
	$offset = isset($_GET["offset"]) && !empty($_GET["offset"]) ? $_GET["offset"] : 0;
	
	$service = isset($_GET["category"]) ? $_GET["category"] : 'all';
	$author = isset($_GET["authorinfo"]) ? $_GET["authorinfo"] : 'all';
	
	if ( $service == 'all' && $author == 'all' ) :
	
		$query = new WP_Query([
			'post_type' => 'case-studies',
			'posts_per_page' => 9,
			'post_status' => 'publish',
			'offset' => $offset
		]);
	
	elseif ( $service != 'all' && $author == 'all' ) :
	
		$query = new WP_Query([
			'post_type' => 'case-studies',
			'posts_per_page' => 9,
			'post_status' => 'publish',
			'offset' => $offset,
			'meta_query' => array(				
				array(
					'key' => 'services',
					'value' => $service,
					'compare' => 'LIKE',
				)
			)
		]);
	
	elseif ( $service == 'all' && $author != 'all' ) :
	
		$query = new WP_Query([
			'post_type' => 'case-studies',
			'posts_per_page' => 9,
			'post_status' => 'publish',
			'offset' => $offset,
			'meta_query' => array(				
				array(
					'key' => 'item_author',
					'value' => $author,
					'compare' => 'LIKE',
				)
			)
		]);
	
	else : 
	
		$query = new WP_Query([
			'post_type' => 'case-studies',
			'posts_per_page' => 9,
			'post_status' => 'publish',
			'offset' => $offset,
			'meta_query' => array(
				'relation' => 'AND',				
				array(
					'key' => 'services',
					'value' => $service,
					'compare' => 'LIKE',
				),
				array(
					'key' => 'item_author',
					'value' => $author,
					'compare' => 'LIKE',
				)
			)
		]);
	
	endif;

	while ( $query->have_posts() ) : $query->the_post();
	
		array_push($posts, array(
			"title" => html_entity_decode(get_the_title()),
			"link" => get_the_permalink(),
			"excerpt" => get_the_excerpt(),
			"image" => wp_get_attachment_image( get_post_thumbnail_id(get_the_ID()), 'large', false, "" )
		));
	
	endwhile;

	return array(
		"posts" => $posts,
		"offset" => $offset,
		"noMorePosts" => count($posts) == 0
	);

}
// /wp-json/project/v1/case-studies/posts/
add_action( 'rest_api_init', function () {
	register_rest_route( 'project/v1', '/case-studies/posts/', array(
		'methods' => 'GET',
		'callback' => 'getCaseStudies',
	));
});