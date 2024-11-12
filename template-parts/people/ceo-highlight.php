<?php

wp_enqueue_script( 'ceo_filter', get_stylesheet_directory_uri() . '/js/ceo-filter.js', array(), THEME_VERSION);

$meta_query = array(
  array(
    'key' => 'is_ceo',
    'value' => true,
    'compare' => '=',
    'type' => 'BOOLEAN',
  )
);

if ( is_singular('offices') ) :

  $officeID = get_the_ID();

  $meta_query = array(
    'relation' => 'AND',
    array(
      'key' => 'is_ceo',
      'value' => true,
      'compare' => '=',
      'type' => 'BOOLEAN',
    ),
    array(
      'key' => 'office',
      'value' => $officeID,
      'compare' => '='
    )
  );

endif;

if (is_page(341)) :
  
  // Get current location filter - If not set then default to London ID
  $officeID = $_GET["location"] ?? 525;

  $meta_query = array(
    'relation' => 'AND',
    array(
      'key' => 'is_ceo',
      'value' => true,
      'compare' => '=',
      'type' => 'BOOLEAN',
    ),
    array(
      'key' => 'office',
      'value' => $officeID,
      'compare' => '='
    )
  );

endif;

$ceoQuery = new WP_Query( array(
	'post_type' => 'people',
	'posts_per_page' => 1,
	'meta_query' => $meta_query
));

if ( $ceoQuery->have_posts() ) : ?>

  <style>

    .ceo-container {
        background: rgb(var(--primary) / 20%);
        border-radius: 2em;
        padding: 3em;
    }

    .single-offices .ceo-container {
        background: rgb(var(--secondary));
    }

    .ceo-container .person {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(min(300px, 100%), 1fr));
        gap: 2em;
    }

    .ceo-container .person .meta * {
      color: rgb(var(--secondary));
    }

    .single-offices .ceo-container .person .meta * {
      color: rgb(var(--primary));
      border-color: rgb(var(--primary));
    }
	  
	.ceo-container  a.open-ceo.btn-primary {
   		margin-top: 1em;
	}

    .ceo-container .person img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .ceo-container .person + dialog::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(0deg, rgb(var(--black) / 80%), rgb(var(--black) / 0%));
    }

    .ceo-container .person + dialog.modal[open] {
      max-width: none;
      max-height: none;
      width: 100%;
      height: 100%;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      align-items: center;
      background-size: cover;
    }

    .ceo-container .person + dialog * {
      position: relative;
      z-index: 2;
      color: rgb(var(--secondary));
    }

  </style>

  <div class="ceo-container">

    <template>
			<div class="person">
        <div class="image-container">
          <div class="post-image"></div>
        </div>
        <div class="meta">
          <h3 class="post-name"></h3>
          <p class="post-position position"></p>
          <p class="quote"></p>
          <a href="#ceo" class="post-link open-ceo btn-primary">Learn more</a>
        </div>
			</div>

      <dialog id="ceo" class="modal">
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
		</template>

    <?php while ( $ceoQuery->have_posts() ) : $ceoQuery->the_post();
		
			$name = get_the_title();
      		$content = get_the_content();
			$position = get_field('position');
      		$quote = get_field('quote');
			$image = wp_get_attachment_image( get_post_thumbnail_id(get_the_id()), "large", true, array( "loading" => "lazy" ) );
      		$bg_image = wp_get_attachment_image_url( get_post_thumbnail_id(get_the_id()), "large" );
		?>

			<div class="person">

        <div class="image-container">
          <?= $image ?>
        </div>
        
        <div class="meta">

          <h3><?= $name ?></h3>

          <p class="position"><?= $position ?></p>

          <?= $quote ?>

          <a href="" class="open-ceo btn-primary">Learn More</a>

        </div>

			</div>

      <dialog id="ceo" class="modal" style="background-image: url(<?= $bg_image ?>);">
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
		
		<?php endwhile; wp_reset_postdata(); ?>

  </div>

<?php endif; ?>