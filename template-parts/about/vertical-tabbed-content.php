<?php

$tabbed_content = get_field('vertical_tabbed_content');

if ( $tabbed_content ) : ?>

  <div class="vertical-tabs tabs-wrapper">

    <div class="tabs">

      <?php $i = 1; foreach( $tabbed_content as $tab ) :
         $tab_title = $tab['tab_title'];
		 $content = $tab['tab_content'];
      ?>
        <div class="tab">

			<input type="radio" name="vertical-tab-group" id="vertical-tab-<?= $i ?>" data-tab="vertical-tab-<?= $i ?>">
			<label for="vertical-tab-<?= $i ?>"><?= $tab_title ?></label>
			
			<div class="mobile-content">
				 <?= $content ?>
			</div>

        </div>
      
      <?php $i++; endforeach; ?>

    </div>

    <div class="content-wrapper">
      
        <?php $i = 1; foreach( $tabbed_content as $tab ) :

          $content = $tab['tab_content'];
          
        ?>
        
        <div class="tab-content" data-tab="vertical-tab-<?= $i ?>">
          
            <?= $content ?>

        </div>
      
      <?php $i++; endforeach; ?>

    </div>
  
  </div>

<?php endif; ?>