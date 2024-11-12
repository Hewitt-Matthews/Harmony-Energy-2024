<?php

$authors = new WP_Query( array(
	'post_type' => 'people',
	'fields' => 'ids',
	'posts_per_page' => -1,
	'orderby' => 'title',
  'order' => 'ASC',
));

?>

<style>

	.cat-list.author-list {
		padding: 1em;
		margin-left: auto;
		display: inline-block;
	}
	
	.cat-list.author-list:focus {
		border-color: rgb(var(--primary));
	}

</style>

<select name="categories-dropdown" class="cat-list author-list">

	<option value="" data-slug="all" data-id=""><?php esc_attr( _e( 'Author', 'textdomain' ) ); ?></option>

	<?php while ( $authors->have_posts() ) : $authors->the_post();
	
		$name = get_the_title();
		$id = get_the_id();
	
	?>
	
		<option class="cat-list_item" data-slug="<?= $id ?>" data-id="<?= $id ?>"><?= $name ?></option>
	
	<?php endwhile; wp_reset_postdata(); ?>

</select>