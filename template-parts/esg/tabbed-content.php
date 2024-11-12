<?php

$tabbed_content = get_field('tabbed_content_esg');

if ( $tabbed_content ) : ?>

  <div class="vertical-tabs tabs-wrapper">

    <div class="tabs">

      <?php $i = 1; foreach( $tabbed_content as $tab ) :
        $tab_title = $tab['tab_title'];
		 $content = $tab['tab_content'];
      ?>
        <div class="tab">

          <input type="radio" name="tab-group" id="tab-<?= $i ?>" data-tab="tab-<?= $i ?>">
          <label for="tab-<?= $i ?>"><?= $tab_title ?></label>
			
			<div class="mobile-content">
				 <?= $content ?>
			</div>

        </div>
      
      <?php $i++; endforeach; ?>

    </div>

    <div class="content-wrapper">
      
        <?php $i = 1; foreach( $tabbed_content as $tab ) :
        
          $tab_title = $tab['tab_title'];
          $content = $tab['tab_content'];
          //$image = $tab['tab_image'];
          
        ?>
        
        <div class="tab-content" data-tab="tab-<?= $i ?>">
          
            <?= $content ?>

        </div>
      
      <?php $i++; endforeach; ?>

    </div>

  </div>

<?php endif; ?>