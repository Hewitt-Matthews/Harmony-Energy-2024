<?php

$latestPosts = new WP_Query( array(
	'post_type' => 'post',
	'posts_per_page' => 2,
	'post_status' => 'publish',
	'post__not_in' => array(get_the_ID())
));

?>

<style>
	
	.sidebar-posts-container {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(min(300px, 100%), 1fr));
		gap: 2em;
	}
	
	.sidebar-posts-container .image-container {
		position: relative;
	}
	
	.sidebar-posts-container .post-image {
		max-height: 300px;
		object-fit: cover;
	}
	
	.sidebar-posts-container .category {
		color: rgb(0 0 0 / 50%);
		text-transform: uppercase;
		letter-spacing: 1px;
		line-height: 1;
		padding: 1em 0 0.5em;
	}
	
	.sidebar-posts-container h5 {
		font-size: 29px;
	}

	.sidebar-posts-container .excerpt {
		color: rgb(0 0 0 / 50%);
	}

</style>

<?php if ( $latestPosts->have_posts() ) : ?>

	<div class="sidebar-posts-container">
			
		<?php while ( $latestPosts->have_posts() ) : $latestPosts->the_post(); 

			$title = get_the_title();
			$link = get_the_permalink();
			$category = get_the_category()[0]->name;
			$featuredImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			$excerpt = get_the_excerpt();

		?>

			<div class="post">

				<a href="<?= $link ?>">
					<div class="image-container">
						<img class="post-image" src="<?= $featuredImg[0] ?>" alt="" height="470" width="450" />
					</div>
				</a>
				<div class="meta">
					<p class="category"><?= $category ?></p>
					<h3><?= $title ?></h3>
					<p class="excerpt"><?= $excerpt ?></p>
				</div>

			</div>

		<?php endwhile; 
			wp_reset_postdata();  ?>

	</div>

<?php endif; ?>