<?php

$officesQuery = new WP_Query( array(
	'post_type' => 'offices',
	'posts_per_page' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'post__not_in' => array(525, 526) // They don't want to display UK office(s)
));

if ( $officesQuery->have_posts() ) : ?>

  <style>
    .subteams-container .tabs {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(min(100%, 200px), 1fr));
      gap: 2em;
    }
  </style>

  <div class="subteams-container tabs-wrapper">

    <div class="tabs">

      <?php $i = 1; while ( $officesQuery->have_posts() ) : $officesQuery->the_post();
        $title = get_the_title();
      ?>
        <div class="tab">

          <input type="radio" name="tab-group" id="tab-<?= $i ?>" data-tab="tab-<?= $i ?>">
          <label for="tab-<?= $i ?>"><?= $title ?></label>

        </div>
      
      <?php $i++; endwhile; wp_reset_postdata(); ?>

    </div>

    <div class="content-wrapper">
      
        <?php $i = 1; while ( $officesQuery->have_posts() ) : $officesQuery->the_post();
        
        $post_id = get_the_ID();
        $title = get_the_title();
        $link = get_the_permalink();
        $featuredImg = wp_get_attachment_image( get_post_thumbnail_id($post->ID), 'large', false, "" );
        $intro_text = get_field('homepage_text');
        $office_address = get_field('office_address');
        $address_line_1 = $office_address['address_line_1'];
        $address_line_2 = $office_address['address_line_2'];
        $address_line_3 = $office_address['address_line_3'];
        $address_town = $office_address['address_town'];
        $address_county = $office_address['address_county'];
        $address_postcode = $office_address['address_postcode'];
        
        ?>
        
        <div class="tab-content" data-tab="tab-<?= $i ?>">
          
          <div class="image-container">
            <?= $featuredImg ?>
          </div>
          
          <div class="meta">
            <h2><?= $title ?></h2>
            <?= $intro_text ?>
            <a href="<?= $link ?>" class="btn-primary">Learn more</a>
          </div>
        
        </div>
      
      <?php $i++; endwhile; wp_reset_postdata(); ?>

    </div>
    
  </div>

  <script>



  </script>

<?php endif ?>