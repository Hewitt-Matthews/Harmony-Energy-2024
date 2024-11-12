<?php

$pre_offset_info_content = get_field('pre_offset_info_content');
$offset_info = get_field('offset_info');

if ( $offset_info ) : ?>

  <div class="offset-container">

    <?php if ( $pre_offset_info_content ) : ?>

      <div class="pre-offset">
        <?= $pre_offset_info_content ?>
      </div>

    <?php endif; ?>

    <?php $i = 1; foreach( $offset_info as $info ) : 
    
      $info_title = $info['info_title'];
      $info_text = $info['info_text'];

    ?>

      <div class="info">

        <div class="number"><?= $i < 10 ? '0' . $i : $i; ?></div>

        <h3 class="title">
          <?= $info_title ?>
        </h3>

        <?= $info_text ?>

      </div>

    <?php $i++; endforeach; ?>

    <div class="empty-div"></div>

  </div>

<?php endif; ?>