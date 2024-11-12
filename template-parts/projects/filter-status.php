<?php

$current_status = $_GET["status"] ?? NULL;

$statuses = get_terms(array(
  'taxonomy' => 'project-status',
  'hide_empty' => false,
));

?>

<select name="status-dropdown" class="cat-list statuses-list">

	<option value="" data-slug="" data-id=""><?php esc_attr( _e( 'Filter by Status', 'textdomain' ) ); ?></option>
	
  <?php foreach ( $statuses as $status ) :
	
    $id = $status->term_id;
    $slug = $status->slug;
    $title = $status->name;
        
  ?>

    <option class="cat-list_item" data-slug="<?= $id ?>" data-id="<?= $slug ?>" <?php if ($id == $current_status) : echo 'selected'; endif; ?>><?= $title ?></option>	

  <?php endforeach; ?>
	
</select>