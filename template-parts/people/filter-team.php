<?php

$current_team = $_GET["team"] ?? NULL;

$teams = get_terms(array(
  'taxonomy' => 'team',
  'hide_empty' => false,
));

?>

<select name="team-dropdown" class="cat-list teams-list">

	<option value="" data-slug="" data-id=""><?php esc_attr( _e( 'Filter by Team', 'textdomain' ) ); ?></option>
	
	<?php foreach ( $teams as $team ) :
	
    $id = $team->term_id;
    $slug = $team->slug;
    $title = $team->name;
        
  ?>

    <option class="cat-list_item" data-slug="<?= $id ?>" data-id="<?= $slug ?>" <?php if ($id == $current_team) : echo 'selected'; endif; ?>><?= $title ?></option>	

  <?php endforeach; ?>
	
</select>