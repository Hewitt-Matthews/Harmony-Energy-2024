<?php

$case_study_content_image = get_field('case_study_content_image');

if ( $case_study_content_image ) : 
  
  $content_image_id = $case_study_content_image['content_image'];
  $content_image = wp_get_attachment_image( $content_image_id, "large", true, array( "loading" => "lazy" ) );
  $content_image_description = apply_filters( 'wp_get_attachment_caption', wp_get_attachment_caption($content_image_id), $content_image_id );
  
  ?>

  <style>
    figure.content-image-container {
        display: grid;
    }

    figure.content-image-container  figcaption {
        border: solid 1px rgb(var(--secondary));
        padding: 1em;
        border-top: none;
        /* Hide Caption for now */
        display: none;
    }

    figure.content-image-container img {
        width: 100%;
    }

    figure.content-image-container figcaption:empty {
        display: none;
    }

  </style>
	<?php if($content_image_id): ?>
  <figure class="content-image-container">
    <?= $content_image ?>
    <figcaption><?= $content_image_description ?></figcaption>
  </figure>
	<?php endif; ?>

<?php endif; ?>