<?php

$currentID = get_the_ID();

$office_statistics = get_field('office_statistics', $currentID);

if ( $office_statistics ) : ?>

  <div class="stats-container">

    <?php foreach ( $office_statistics as $stat ) : 
      
      $stat_description = $stat['stat_description'];
      $stat_number = $stat['stat_number'];
      $append_text_to_stat_number = $stat['append_text_to_stat_number'];
      if ( $append_text_to_stat_number ) :
        $stat_number_append = $stat['stat_number_append'];
      endif;

    ?>

      <div class="stat">

        <div class="number">
          <?= $stat_number ?> <?php if ( $append_text_to_stat_number ) : ?><?= $stat_number_append ?><?php endif; ?>
        </div>
        <div class="description">
          <?= $stat_description ?>
        </div>

      </div>

    <?php endforeach; ?>
    
  </div>

<?php endif; ?>