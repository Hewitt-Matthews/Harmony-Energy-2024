<?php

$causes = get_field('causes');

if ( $causes ) : ?>

  <style>
    .causes-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr));
      gap: 2em;
    }

    .causes-container .cause img {
        border: solid 1px rgb(var(--white));
        padding: 2em;
        width: 100%;
        height: min(180px, 80vw);
        object-fit: contain;
        margin-bottom: 1em;
    }

    .causes-container .cause * {
        color: rgb(var(--white));
    }

    .causes-container .cause a:hover {
      text-decoration: underline;
    }

  </style>

  <div class="causes-container">

    <?php foreach( $causes as $cause ) : 
    
      $cause_image_id = $cause['cause_image'];
      $cause_image = wp_get_attachment_image( $cause_image_id, 'large', false, "" );
      $cause_title = $cause['cause_title'];
      $cause_text = $cause['cause_text'];
      $cause_link = $cause['cause_link'];

    ?>

      <div class="cause">

        <?php if ( $cause_link ) : ?>
          <a href="<?= $cause_link ?>" class="">
        <?php endif; ?>

          <?= $cause_image ?>

          <h2><?= $cause_title ?></h2>

          <p><?= $cause_text ?></p>

        <?php if ( $cause_link ) : ?>
          </a>
        <?php endif; ?>

      </div>

    <?php endforeach; ?>

  </div>

<?php endif; ?>