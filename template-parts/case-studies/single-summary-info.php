<?php

$current_status = get_field('current_status');
$summary_info = get_field('offset_info');

if ( $summary_info ) : ?>

  <style>

    .summary {
      display: grid;
      grid-template-columns: min(100%, 300px) 1fr;
      gap: 2em;
    }

    .status.info {
      position: sticky;
      align-self: flex-start;
      top: 2em;
      border-bottom: solid 1px;
      padding-bottom: 2em;
    }

    .summary .offset-container > .info {
        border-bottom: solid 1px;
        border-top: none;
        padding-top: 0;
        padding-bottom: 2em;
    }

  </style>

  <div class="summary">

    <div class="status info">

    <h3 class="title">
      <?= $current_status ?>
    </h3>

    Current Status

    </div>

    <div class="offset-container">

      <?php foreach( $summary_info as $info ) : 
      
        $info_title = $info['info_title'];
        $info_text = $info['info_text'];

      ?>

        <div class="info">

          <h3 class="title">
            <?= $info_title ?>
          </h3>

          <?= $info_text ?>

        </div>

      <?php endforeach; ?>

    </div>
  
  </div>

<?php endif; ?>