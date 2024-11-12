<?php

wp_enqueue_script( 'projects_filter', get_stylesheet_directory_uri() . '/js/projects-filter.js', array(), THEME_VERSION);

$meta_query = array();

$projectsQuery = new WP_Query( array(
	'post_type' => 'he-projects',
	'posts_per_page' => -1,
  'post_status' => 'publish',
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'meta_query' => $meta_query,
));

if ( $projectsQuery->have_posts() ) : ?>

<style>
	.projects-container {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(min(100%, 275px), 1fr));
		gap: 1.5em 1em;
	}
	.projects-container .project {
		padding: 1em;
    	border: 1px solid rgb(var(--secondary));
		position: relative; /* Ensure the project div is positioned */
		transition: background-color 0.3s ease; /* Smooth transition for background color */
	}

	.projects-container .project .meta * {
		margin: 0;
		padding: 0;
		text-align: center;
	}

	.projects-container .project .meta {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 0.3em;
		color: white; /* Default text color for meta content */
	}

/* 	.projects-container .project .meta  .post-power {
		font-size: var(--h2FontSize);
	} */

/* 	.projects-container .project .meta  .post-power span {
		font-size: 24px;
	} */

	.projects-container .project p.status {
		text-transform: uppercase;
		color: rgb(var(--secondary) / 50%);
	}

	.projects-container .project .type {
		display: inline-block;
		background-color: rgb(var(--secondary) / 0%);
		border: solid 2px rgb(var(--secondary));
		border-radius: 50px;
		padding: 1em 1.5em;
		line-height: 1;
		font-weight: 400;
	}
	
	/* Hover effect for clickable projects */
	.projects-container .project.clickable:hover {
		background-color: white; /* Change background to white */
	}

	/* Change text color on hover for clickable projects */
	.projects-container .project.clickable:hover .meta,
	.projects-container .project.clickable:hover .meta * {
		color: rgb(0, 69, 119) !important; /* Change text color to rgb(0, 69, 119) on hover */
	}

	.projects-container .project.clickable:hover .type {
		border-color: rgb(0, 69, 119); /* Change border color to rgb(0, 69, 119) on hover */
	}

</style>

	<div class="no-results"></div>

	<div class="projects-container">

    <template>
			<div class="project">
				<div class="meta">
				<div class="type"></div>
				<div class="title"><h3></h3></div>
				<div class="post-power"></div>
				<p class="location"></p>
				<p class="info"></p>
				<p class="status"></p>
				</div>
			</div>
		</template>

		<?php while ( $projectsQuery->have_posts() ) : $projectsQuery->the_post();
		
      $post_id = get_the_ID(); // Get the current post ID
			$name = get_the_title();
			$statuses = get_the_terms($post_id, 'project-status');
			$project_type_id = get_field('project_type');
			$project_type = get_the_title($project_type_id);
			$project_specific_location_name = get_field('project_specific_location_name');
			$project_info = get_field('project_info');
			$project_power = get_field('project_power');

			// Use Weglot's language detection
			$current_language = weglot_get_current_language();
			$project_url = '';

			// Determine the project URL based on the current language
			if ($current_language === 'fr') {
				$project_url = get_field('project_url_fr', $post_id); // Fetch French URL
			} elseif ($current_language === 'de') {
				$project_url = get_field('project_url_de', $post_id); // Fetch German URL
			} elseif ($current_language === 'pl') {
				$project_url = get_field('project_url_pl', $post_id); // Fetch Polish URL
			} elseif ($current_language === 'it') {
				$project_url = get_field('project_url_it', $post_id); // Fetch Italian URL
			} else {
				$project_url = get_field('project_url_en', $post_id); // Default to English URL
			}
			
		?>

		<?php if (!empty($project_url)) : ?> <!-- Check if the project URL is not empty -->
			<a href="<?= esc_url($project_url) ?>" target="_blank" rel="noopener noreferrer" class="project clickable"> <!-- Make project div clickable -->
		<?php else : ?>
			<div class="project"> <!-- Non-clickable project div -->
		<?php endif; ?>

				<div class="meta">

					<p class="type"><?= $project_type ?></p>

					<p class="title"><p><?= $name ?></p></p>

					<?php if($project_power) : ?>
						<p class="post-power"><?= $project_power ?></p>
					<?php endif; ?>

					<p class="location"><?= $project_specific_location_name ?></p>
					<?php if($project_info) : ?>
						<p class="info"><?= $project_info ?></p>
					<?php endif; ?>

					<?php foreach ($statuses as $status) : ?>
						<p class="status"><?= $status->name ?></p>
					<?php endforeach; ?>

				</div>

		<?php if (!empty($project_url)) : ?>
			</a> <!-- End of clickable project div -->
		<?php else : ?>
			</div> <!-- End of non-clickable project div -->
		<?php endif; ?>
		
		<?php endwhile; wp_reset_postdata(); ?>

	</div>

<?php endif; ?>