<?php

$offices = get_field('offices', 'option');

if ( $offices ) : ?>

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

    <?php foreach( $offices as $office ) : 
      
      $office_location = $office['office_location'];
      $office_address = $office['office_address'];
      $address_line_1 = $office_address['address_line_1'];
      $address_line_2 = $office_address['address_line_2'];
      $address_line_3 = $office_address['address_line_3'];
      $address_town = $office_address['address_town'];
      $address_county = $office_address['address_county'];
      $address_postcode = $office_address['address_postcode'];
      
    ?>

      <div class="office">

        <h2><?= $office_location ?></h2>

        <div class="address">

          <p><?= $address_line_1 ?>,
          <?php if ( $address_line_2 ) : ?>
            <?= $address_line_2 ?>,<br>
          <?php endif; ?>
          <?php if ( $address_line_3 ) : ?>
            <?= $address_line_3 ?>,<br>
          <?php endif; ?>
          <?php if ( $address_town ) : ?>
            <?= $address_town ?>,<br>
          <?php endif; ?>
          <?php if ( $address_county ) : ?>
            <?= $address_county ?>,<br>
          <?php endif; ?>
            <?= $address_postcode ?></p>

        </div>

      </div>
    
    <?php endforeach; ?>

  </div>

<?php endif ?>