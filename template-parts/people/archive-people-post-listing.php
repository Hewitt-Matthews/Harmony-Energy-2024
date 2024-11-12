<?php

wp_enqueue_script( 'people_filter', get_stylesheet_directory_uri() . '/js/people-filter.js', array(), THEME_VERSION);

    $meta_query = array(
//         array(
//             'key' => 'is_ceo',
//             'value' => true,
//             'compare' => '!=',
//             'type' => 'BOOLEAN',
//         )
    );



$peopleQuery = new WP_Query( array(
    'post_type' => 'people',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    //'orderby' => 'menu_order',
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => $meta_query,
    'post__not_in' => array( 396 ), // Exclude the team member with ID 396 (Peter Kavanagh)
));



if ( $peopleQuery->have_posts() ) : ?>

<style>
	.people-container {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(min(100%, 275px), 1fr));
		gap: 2em;
	}
	.people-container .person {
		position: relative;
		display: flex;
		align-items: flex-end;
		height: min(400px, 80vw);
		padding: 1em;
		background-size: cover;
		background-position: center;
		cursor: pointer;
	}

	.people-container .person > .meta {
		position: relative;
		z-index: 2;
	}
	
	.people-container .person > .meta * {
		color: rgb(var(--white));
	}
	
	.people-container .person p.position {
		padding: 0;
	}

	.people-container .person p.position + p {
		font-size: 0.75em;
	}

	.people-container .person:hover > .meta * {
		text-decoration: underline;
	}

	.people-container .person dialog span.btn-primary.close {
		margin-top: 1em;
	}

	.people-container .person dialog span.btn-primary.close:hover {
		background-color: white;
		color: rgb(0, 69, 119);
	}
		
	.people-container .person::after,
	.people-container .person dialog::after {
		content: "";
		position: absolute;
		inset: 0;
		background: linear-gradient(0deg, rgb(var(--black) / 80%), rgb(var(--black) / 0%));
		transition: 300ms;
	}
	
	.people-container .person:hover::after {
		background: linear-gradient(0deg, rgb(var(--harmonyBlue) / 80%), rgb(var(--black) / 0%));
	}

	.people-container .person dialog.modal[open] {
		max-width: none;
		max-height: none;
		width: 100%;
		height: 100%;
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
		align-items: center;
		background-size: cover;
	}

	.people-container .person dialog * {
		position: relative;
		z-index: 2;
		color: white;
		border-color: white;
	}

	

</style>

<!-- 	<div class="no-results"></div> -->

	<div class="people-container">

<!--     <template>
      
      <div class="person open-modal" data-post-id="">
        <div class="meta">
          <h3 class="post-name"></h3>
          <p class="post-position"></p>
        </div>
        <dialog class="modal" id="" class="modal">
          <div class="empty"></div>
          <div class="modal-content">
            <h2 class="modal-name"></h2>
            <div class="modal-content-inner">
              <p class="position"></p>
              <p class="content"></p>
              <span class="btn-primary close">Close</span>
            </div>
          </div>
        </dialog>
      </div>
      
    </template> -->

		<?php while ( $peopleQuery->have_posts() ) : $peopleQuery->the_post();
		
      		$post_id = get_the_ID();
			$name = get_the_title();
      		$content = get_the_content();
			$position = get_field('position');
			$isCEO = get_field('is_ceo');
			$location = get_the_title(get_field('office')) == "London, UK" ? "UK" : get_the_title(get_field('office'));
			$team_obj_list = get_the_terms( $post_id, 'team' );
			$terms_string = join(', ', wp_list_pluck($team_obj_list, 'name'));
			$image = wp_get_attachment_image_url( get_post_thumbnail_id(get_the_id()), "large");

		?>
			
		<div class="person open-modal" data-post-id="<?= $post_id ?>" style="background-image: url(<?= $image ?>);" data-location="<?= $location ?>" data-team="<?= $terms_string ?>" data-isceo="<?= $isCEO ?>">

			<div class="meta">

				<h3><?= $name ?></h3>

				<p class="position"><?= $position ?></p>
				<p class="location"><?= $location ?></p>

			</div>

			<dialog id="person-<?= $post_id ?>" class="modal" style="background-image: url(<?= $image ?>);">
				<div class="empty"></div>
				<div class="modal-content">
					<h2><?= $name ?></h2>
					<div class="modal-content-inner">
						<p class="position"><?= $position ?></p>
						<p><?= $content ?></p>
						<span class="btn-primary close">Close</span>
					</div>
				</div>
			</dialog>

		</div>
		
		<?php endwhile; wp_reset_postdata(); ?>

	</div>

<?php endif; ?>