<?php

$category = get_queried_object();

$category_slug = $category->slug;

$posts_per_page = 75;

$meta_query = array();

if ( is_front_page() ) :

  $posts_per_page = 2;

endif;

if ( is_singular('post') ) :

	$posts_per_page = 2;

	$category = get_the_category();

  	$category_slug = $category[0]->slug;

	$postID = get_the_ID();

endif;

if ( is_singular('offices') ) :

	$posts_per_page = 2;

	//Hiding Office meta query until they have posts for each office
	// $meta_query = array(
	// 	array(
	// 	'key' => 'post_office',
	// 	'value' => '"' . get_queried_object_ID() . '"',
	// 	'compare' => 'LIKE'
	// 	)
	// );

endif;

$latestPosts = new WP_Query( array(
	'post_type' => 'post',
	'posts_per_page' => $posts_per_page,
	'post_status' => 'publish',
	'category_name' => $category_slug ? $category_slug : NULL,
  	'meta_query' => $meta_query,
	'post__not_in' => array($postID)
));

?>

<style>
	.posts-container {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(min(400px, 100%), 1fr));
		gap: 2em;
	}

	<?php if(is_home()) :?>

		.posts-container {
			grid-template-columns: repeat(auto-fit, minmax(min(300px, 100%), 1fr));
		}

	<?php endif; ?>

	.posts-container .post .image-container {
		border: solid 1px rgb(var(--secondary) / 50%);
		border-bottom: none;
    	display: grid;
	}
	
	.posts-container .post {
		 max-width: 650px;
	}

	.posts-container .post .image-container img {
		aspect-ratio: 16/9;
		object-fit: cover;
	}

	.posts-container .post .meta {
		border: solid 1px rgb(var(--secondary) / 50%);
		padding: 2em;
	}

	.posts-container .post .meta h3 {
    	font-size: min(28px, var(--h3FontSize));
	}

	.posts-container .post .btn-primary {
		display: none;
	}
	.posts-container .post .meta a:hover h5 {
		text-decoration: underline;
	}
  	.posts-container .sign-up-container {
		grid-column: 1 / -1;
		--fullWidth: calc(calc(calc(100vw - min(1250px,80vw)) / 2) / -1);
		margin: 7em var(--fullWidth) 5em;
	}
	.posts-container .sign-up-container-hide {
		display: none;
	}
</style>

<?php if ( $latestPosts->have_posts() ) : ?>

	<div class="posts-container">
			
		<?php $count = 1; $num = $latestPosts->post_count; while ( $latestPosts->have_posts() ) : $latestPosts->the_post(); 

			$title = get_the_title();
			$link = get_the_permalink();
			$featuredImg = wp_get_attachment_image( get_field('thumbnail'), 'large', false, "" );
			$excerpt = get_field('sub_title') ? limit_text(get_field('sub_title'), 20) . '...' : limit_text(get_the_excerpt(), 20) . '...';

		?>

			<a href="<?= $link ?>">
				<div class="post">

					<div class="image-container">
						<?= $featuredImg ?>
					</div>
				
					<div class="meta">
						<h3><?= $title ?></h3>
						<p class="excerpt"><?= $excerpt ?></p>
					</div>
					
				</div>
			</a>

		<?php $count++; endwhile; wp_reset_postdata();  ?>
		
	</div>

<?php endif; ?>