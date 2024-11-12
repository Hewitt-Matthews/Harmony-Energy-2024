<?php

$current_location = $_GET["location"] ?? NULL;

$peopleLocationsQuery = new WP_Query( array(
	'post_type' => 'offices',
	'fields' => 'ids',
	'posts_per_page' => -1,
	'orderby' => 'title',
  'order' => 'ASC'
));

?>

<style>
	.categories-container {
		display: flex;
		flex-wrap: wrap;
		gap: 1em;
		justify-content: flex-start;
		padding: 0!important;
	}
	.categories-container li {
		list-style: none;
	}
	.categories-container span {
		color: #ffffff;
		opacity: 0.7;
	}
	.categories-container span:hover {
		text-decoration: underline;
		opacity: 0.9;
	}
	.categories-container span.active {
		text-decoration: underline;
		font-weight: 600;
		opacity: 1;
	}
</style>

<ul class="categories-container locations-list">
	
	<!-- Output the UK span before the loop -->
    <li>
        <span class="btn-primary" data-slug="uk" data-id="uk" data-title="UK">
            UK
        </span>
    </li>
	
	<?php // Flag to check if UK span has been output
		  $ukSpanOutput = false;
	
	while ( $peopleLocationsQuery->have_posts() ) : $peopleLocationsQuery->the_post(); 
	
		$id = get_the_ID( );
		$title = get_the_title( );
		$permalink = get_the_permalink( );
		$slug = basename(get_the_permalink( ));
	
        // Skip "Knaresborough" and "London"
        if ($slug === 'knaresborough' || $slug === 'london') {
            continue;
        } 
	?>
	
		<li>
			<span class="btn-primary" data-slug="<?= $id ?>" data-id="<?= $slug ?>" data-title="<?= $title ?>">
				<?= $title ?>
			</span>
		</li>
	
	<?php endwhile; wp_reset_postdata(); ?>
	
</ul>