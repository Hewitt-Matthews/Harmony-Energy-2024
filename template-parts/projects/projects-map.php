<?php

$currentServiceID = NULL;
$map_title = ' Projects';

if ( is_singular('services') ) :
  $currentServiceID = get_the_ID();
  $map_title = get_the_title() . ' Projects';
endif;

// Get all project types
$projectsTypesQuery = new WP_Query( array(
	'post_type' => 'services',
	'fields' => 'ids',
	'posts_per_page' => -1,
	'orderby' => 'title',
  'order' => 'ASC'
));

// Get all project statuses
$statuses = get_terms(array(
  'taxonomy' => 'project-status',
  'hide_empty' => false,
));

?>

<style>

  .map-container {
    height: 100vh;
  }

  .map-container > .filters {
    position: absolute;
    top: 2em;
    left: calc(calc(100vw - min(1250px, 80vw)) / 2);
    z-index: 2;
  }

  .page-id-916 .map-container > .filters {
      top: 5em;
  }

  #page-container .map-container > .filters * {
      color: rgb(var(--white));
  }

  #page-container .map-container > .filters *:not(h2) {
    font-size: 6cqi;
    line-height: 1;
  }

  .map-container > .filters > div {
    --padding: min(2rem, 4vw);
    padding: var(--padding);
    border-radius: calc(var(--padding) / 2);
    background-color: rgb(var(--black) / 60%);
    width: min(300px, 45vw);
    container-type: inline-size;
  }

  .filter-dropdowns {
    margin-top: var(--padding);
    display: grid;
    gap: min(0.3em, var(--padding));
  }

  .filter-dropdowns select {
      padding: 0.5em;
      border-radius: 0.5em;
      background-color: transparent;
      color: #fff;
  }

  .filter-dropdowns select option {
      color: rgb(var(--black))!important;
  }

  ul.key-list {
      padding: 0;
      list-style: none;
      display: grid;
      gap: 1em;
  }

  ul.key-list li {
      --padding: 1.5em;
      position: relative;
      padding-left: var(--padding);
  }

/*   ul.key-list li:nth-child(1) {
      --backgroundColour: rgb(113 112 112);
  }

  ul.key-list li:nth-child(2) {
      --backgroundColour: rgb(61 205 255);
  }

  ul.key-list li:nth-child(3) {
      --backgroundColour: rgb(111 207 37);
  }

  ul.key-list li:nth-child(4) {
      --backgroundColour: rgb(0 69 119);
  }

  ul.key-list li:nth-child(5) {
      --backgroundColour: rgb(110 168 178);
  } */
	
	ul.key-list li:nth-child(1) {
		--backgroundColour: rgb(61 205 255);
  	}

	ul.key-list li:nth-child(2) {
		--backgroundColour: rgb(111 207 37);
	}

  ul.key-list li::before {
      content: "";
      --circleSize: calc(var(
      --padding) / 1.5);
      position: absolute;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
      background-color: var(--backgroundColour);
      width: var(--circleSize);
      height: var(--circleSize);
      border-radius: 50%;
  }

  #map {
    height: 100%;
  }

  #map :is(h2, p) {
      color: rgb(var(--black));
  }

  div#map h2 {
      font-size: 20px;
      font-weight: 600;
  }

</style>

<div class="map-container">
 
  <div class="filters">

    <h2><?= $map_title  ?></h2>
  
    <div class="key">
  
      <ul class="key-list">
<!--         <li>Pre Application Stage</li>
        <li>In planning</li>
        <li>Consented</li> -->
        <li>Under Construction</li>
        <li>Operational</li>
      </ul>
  
    </div>
  
    <div class="filter-dropdowns">
     
      <select id="type-filter">
      
        <option value="0">All Types</option>
        
        <?php while ( $projectsTypesQuery->have_posts() ) : $projectsTypesQuery->the_post();
      
          $id = get_the_ID( );
          $title = get_the_title( );
          $permalink = get_the_permalink( );
          $slug = basename(get_the_permalink( ));
            
        ?>
      
          <option class="" data-id="<?= $id ?>" value="<?= $id ?>" <?php if ($id == $currentServiceID) : echo 'selected'; endif; ?>><?= $title ?></option>	
      
        <?php endwhile; wp_reset_postdata(); ?>
          
      </select>
      
      <select id="status-filter">
      
        <option value="0">All Status</option>
      
        <?php foreach ( $statuses as $status ) :
      
          $id = $status->term_id;
          $slug = $status->slug;
          $title = $status->name;
              
        ?>
      
          <option class="" data-id="<?= $id ?>" value="<?= $id ?>"><?= $title ?></option>	
      
        <?php endforeach; ?>
      
      </select>
      
    </div>
  
  </div>
    
  <div id="map"></div>

</div>
