<?php

$servicesQuery = new WP_Query( array(
	'post_type' => 'services',
	'posts_per_page' => -1,
	'orderby' => 'title',
	'order' => 'ASC',
));

if ( $servicesQuery->have_posts() ) : ?>

<style>

	.services-container {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(min(100%, 275px), 1fr));
		min-height: 100vh;
	}
	.services-container .service {
		position: relative;
		display: grid;
		align-items: end;
		padding: 2em;
	}

	.services-container .service .image-container {
		position: absolute;
		inset: 0;
		z-index: 1;
	}

	.services-container .service .image-container::before {
		content: "";
		position: absolute;
		inset: 0;
		background: linear-gradient(0deg, rgb(var(--primary)) 30%, transparent 70%);
	}

	.services-container .service .image-container img {
		height: 100%;
		object-fit: cover;
		width: 100%;
	}

	.services-container .service .meta {
		position: relative;
		z-index: 2;
	}

	.services-container .service .meta > p {
		display: none;
	}

</style>

	<div class="services-container">
		
		<?php while ( $servicesQuery->have_posts() ) : $servicesQuery->the_post();
		
			$title = get_the_title();
			$link = get_the_permalink();
			$image = wp_get_attachment_image( get_post_thumbnail_id(get_the_id()), "large", true, array( "loading" => "lazy" ) );
			$icon = get_field('service_icon');
			$icon_url = wp_get_attachment_image( $icon, "large", true, array( "loading" => "lazy" ) );
			$service_intro = get_field('service_intro');

		?>

			<a href="<?= $link ?>" class="service">

				<div class="image-container">
					<?= $image ?>
				</div>
        
				<div class="meta">

					<?= $icon_url ?>

					<h2><?= $title ?></h2>

					<?= $service_intro ?>

					<span class="btn-primary">Find out more</span>

				</div>
			
			</a>
		
		<?php endwhile; wp_reset_postdata(); ?>

	</div>

<?php endif; ?>