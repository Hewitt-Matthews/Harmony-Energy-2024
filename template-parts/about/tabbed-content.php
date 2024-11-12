<?php

$tabbed_content = get_field('tabbed_content');

if ( $tabbed_content ) : ?>

  <div class="tabbed-content tabs-wrapper">

    <div class="tabs">

      <?php $i = 1; foreach( $tabbed_content as $tab ) :
        $tab_title = $tab['tab_title'];
      ?>
        <div class="tab">

          <input type="radio" name="tab-group" id="tab-<?= $i ?>" data-tab="tab-<?= $i ?>">
          <label for="tab-<?= $i ?>"><?= $tab_title ?></label>

        </div>
      
      <?php $i++; endforeach; ?>

    </div>

    <div class="content-wrapper">
      
        <?php $i = 1; foreach( $tabbed_content as $tab ) :
        
          $tab_title = $tab['tab_title'];
          $content = $tab['tab_content'];
          $image_id = $tab['tab_image'];
          $image = wp_get_attachment_image( $image_id, "large", true, array( "loading" => "lazy" ) );
          
        ?>
        
        <div class="tab-content" data-tab="tab-<?= $i ?>">
          
          <div class="image-container">
            <?= $image ?>
          </div>
          
          <div class="meta">
            <?= $content ?>
          </div>
        
        </div>
      
      <?php $i++; endforeach; ?>

    </div>

  </div>

<?php endif; ?>