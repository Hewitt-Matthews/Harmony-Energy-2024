<?php


if(is_singular('services')) {
  $stats =  get_field('service_statistics', get_queried_object_id( ));
} else {
  $stats = get_field('stats', 'option');
}

if ( $stats ) : ?>

<div class="stats-container">

  <?php foreach ( $stats as $stat ) : 
    
    $stat_description = $stat['stat_description'];
    $stat_number = $stat['stat_number'];
    $stat_number_append_text = $stat['stat_number_append_text'];
    
    if(is_singular('services')) {
      $append_text_to_stat_number = $stat['append_text_to_stat_number'];
      if ( $append_text_to_stat_number ) :
        $stat_number_append_text = $stat['stat_number_append'];
      endif;
    }
  ?>

    <div class="stat">

      <div class="number-container">
        <span class="number"><?= $stat_number ?></span><span><?= $stat_number_append_text ?></span>
      </div>

      <div class="description">
        <?= $stat_description ?>
      </div>

    </div>


  <?php endforeach; ?>

</div>

<?php endif; ?>