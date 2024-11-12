<?php

$card_grid = get_field('card_grid');

if ( $card_grid ) : ?>

  <style>
    .card-grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(min(100%, 275px), 1fr));
      gap: 2em;
    }

    .card-grid-container .card {
      border: solid 2px;
      padding: 2em;
      display: flex;
      gap: 2em;
      flex-direction: column;
      container-type: inline-size;
      /* justify-content: space-between; */
    }

    .card-grid-container .card h3 {
      font-size: min(var(--h3FontSize), 12cqi);
  }
    
    .card-grid-container .card p {
      font-size: min(16px, 9cqi);
      line-height: 1.3;
  }

    .inverted .card-grid-container .card img {
      filter: invert(1);
    }

  </style>

  <div class="card-grid-container">

    <?php foreach( $card_grid as $card ) : 
    
      $card_icon_id = $card['card_icon'];
      $card_icon = wp_get_attachment_image( $card_icon_id, "large", true, array( "loading" => "lazy" ) );
      $card_title = $card['card_title'];
      $card_content = $card['card_content'];

    ?>

      <div class="card">

        <?= $card_icon ?>

        <div class="meta">

          <h3 class="title"><?= $card_title ?></h3>

          <?= $card_content ?>

        </div>

      </div>

    <?php endforeach; ?>

  </div>

<?php endif; ?>