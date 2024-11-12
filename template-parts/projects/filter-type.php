<?php

$current_type = $_GET["type"] ?? NULL;

$projectsTypesQuery = new WP_Query( array(
	'post_type' => 'services',
	'fields' => 'ids',
	'posts_per_page' => -1,
	'orderby' => 'title',
  'order' => 'ASC'
));

?>

<select name="type-dropdown" class="cat-list types-list">

	<option value="" data-slug="" data-id=""><?php esc_attr( _e( 'Filter by Type', 'textdomain' ) ); ?></option>
	
	<?php while ( $projectsTypesQuery->have_posts() ) : $projectsTypesQuery->the_post();
	
		$id = get_the_ID( );
		$title = get_the_title( );
		$permalink = get_the_permalink( );
		$slug = basename(get_the_permalink( ));
		   
	?>
	
		<option class="cat-list_item" data-slug="<?= $id ?>" data-id="<?= $slug ?>" <?php if ($id == $current_type) : echo 'selected'; endif; ?>><?= $title ?></option>	
	
	<?php endwhile; wp_reset_postdata(); ?>
</select>