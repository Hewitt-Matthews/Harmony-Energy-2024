<?php

  $logos = get_field('company_logos', 'option');

?>

<style>

  .logos-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(min(100%, 250px), 1fr));
      gap: 4em 3em;
      align-items: center;
    }

    .logos-container img {
        filter: grayscale(1) brightness(0);
    }

</style>

<?php if ( $logos ) : ?>

  <div class="logos-container">

    <?php foreach( $logos as $logo ) : ?>

      <div class="logo">

        <?= wp_get_attachment_image( $logo, "large", true, array( "loading" => "lazy" ) ); ?>

      </div>

    <?php endforeach; ?>

  </div>

<?php endif; ?>