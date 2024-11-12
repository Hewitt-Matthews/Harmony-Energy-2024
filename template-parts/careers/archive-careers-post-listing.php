<?php

$meta_query = array();

$careersQuery = new WP_Query( array(
	'post_type' => 'careers',
	'posts_per_page' => 3,
	'orderby' => 'date',
	'order' => 'ASC',
	'meta_query' => $meta_query,
));

if ( $careersQuery->have_posts() ) : ?>

<style>
	.careers-container {
		display: grid;
		gap: 2em;
	}
	.careers-container .careers {
		display: grid;
		gap: 1em;
		border: solid 2px rgb(var(--secondary) / 20%);
		padding: 2em;
	}

	.careers-container .careers .buttons > a:first-child {
		margin-right: 1em;
	}
</style>

	<div class="careers-container">
		
		<?php while ( $careersQuery->have_posts() ) : $careersQuery->the_post();
		
      		$post_id = get_the_ID();
			$title = get_the_title();
			$salary = get_field('salary');
			$location = get_field('position_location');
			$link = get_the_permalink();

		?>

			<div class="careers">

				<div class="info">
					<h3><?= $title ?></h3>
					<p><?= $location . " | " ?: "" ?><?= $salary ?></p>
				</div>

				<div class="buttons">
					
					<a class="btn-primary" href="<?= $link ?>#apply">Apply now</a>
					<a class="btn-primary" href="<?= $link ?>">Learn more</a>

				</div>


			</div>
		
		<?php endwhile; wp_reset_postdata(); ?>

	</div>

<?php endif; ?>