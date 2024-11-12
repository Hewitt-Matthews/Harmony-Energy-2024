<?php

$current_location = $_GET["location"] ?? NULL;

$locations = get_terms(array(
  'taxonomy' => 'project-location',
  'hide_empty' => false,
));

?>

<select name="location-dropdown" class="cat-list locations-list">

	<option value="" data-slug="" data-id=""><?php esc_attr( _e( 'Filter by Location', 'textdomain' ) ); ?></option>
	
	<?php foreach ( $locations as $location ) :
	
    $id = $location->term_id;
    $slug = $location->slug;
    $title = $location->name;
        
  ?>

    <option class="cat-list_item" data-slug="<?= $id ?>" data-id="<?= $slug ?>" <?php if ($id == $current_location) : echo 'selected'; endif; ?>><?= $title ?></option>	

  <?php endforeach; ?>

</select>