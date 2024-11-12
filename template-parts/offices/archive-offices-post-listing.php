<?php

$meta_query = array();

$post__in = array();

$atts = shortcode_atts( array(
  'london' => '',
  'knaresborough' => '',
), $args['atts'], 'attributes' );

if ( is_singular('careers')) :

  $office_id = get_field('office_assignment');

  $post__in = array( $office_id );

endif;

if($atts['london'] == "true") :

  $post__in = array(525); // London Office

endif;

if($atts['knaresborough'] == "true") :

  $post__in = array(526); // knaresborough Office

endif;

$officesQuery = new WP_Query( array(
	'post_type' => 'offices',
	'posts_per_page' => -1,
  'post__in' => $post__in,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'meta_query' => $meta_query,
));

if ( $officesQuery->have_posts() ) : ?>

  <style>
    .offices-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(min(100%, 220px), 1fr));
      gap: 2em;
    }

    .offices-container .office {
        border: solid 1px rgb(var(--secondary) / 50%);
        padding: min(3em, 10vw) 2em;
        container-type: inline-size;
    }

    .offices-container .office h2 {
        margin-bottom: 1rem;
        font-size: clamp(20px, 13cqi, var(--h2FontSize));
    }

    .offices-container .office p {
        padding: 0;
        font-size: 16px;
    }
  </style>

  <div class="offices-container">

    <?php while ( $officesQuery->have_posts() ) : $officesQuery->the_post();
      
      $post_id = get_the_ID();
			$title = get_the_title();
      $link = get_the_permalink();
      $office_address = get_field('office_address');
      $address_line_1 = $office_address['address_line_1'];
      $address_line_2 = $office_address['address_line_2'];
      $address_line_3 = $office_address['address_line_3'];
      $address_town = $office_address['address_town'];
      $address_county = $office_address['address_county'];
      $address_postcode = $office_address['address_postcode'];
      
    ?>

      <div class="office">

        <h2><?= $title ?></h2>

        <div class="address">

          <p><?= $address_line_1 ?>,<br>
            <?php if ( $address_line_2 ) : ?>
              <?= $address_line_2 ?>,<br>
            <?php endif; ?>
            <?php if ( $address_line_3 ) : ?>
              <?= $address_line_3 ?>,<br>
            <?php endif; ?>
            <?php if ( $address_town ) : ?>
              <?= $address_town ?>,<br>
            <?php endif; ?>
			  
			<?php if ($address_county && $address_postcode) : ?>
				<?= $address_county ?>,<br>
				<?= $address_postcode ?><br>
			<?php endif; ?>

			<?php if ($address_county && !$address_postcode) : ?>
				<?= $address_county ?><br>
			<?php endif; ?>

        </div>

      </div>
    
    <?php endwhile; wp_reset_postdata(); ?>

  </div>

<?php endif ?>