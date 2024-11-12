<?php

$currentID = get_the_ID();

$office_address = get_field('office_address', $currentID);

if ( $office_address['address_line_1'] ) : 

  $address_line_1 = $office_address['address_line_1'];
  $address_line_2 = $office_address['address_line_2'];
  $address_line_3 = $office_address['address_line_3'];
  $address_town = $office_address['address_town'];
  $address_county = $office_address['address_county'];
  $address_postcode = $office_address['address_postcode'];

?>

  <style>
    .address-container {
      color: #ffffff;
    }
  </style>

  <div class="address-container">

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

<?php endif; ?>