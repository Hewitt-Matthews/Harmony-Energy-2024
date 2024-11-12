<?php

$gallery = get_field('gallery');

if ( $gallery ) : ?>

  <style>

    .gallery-container {
      margin: 0 calc(calc(calc(100vw - min(1250px, 80vw)) / 2) / -1);
    }

    .gallery-container .image-container {
        width: 80%;
        padding: 0 1em;
        /* height: 100%; */
    }

    .gallery-container .image-container img {
        /* height: 100%; */
        aspect-ratio: 16 / 9;
        object-fit: cover;
        object-position: bottom;
    }

    .flickity-button {
        height: 100%;
        width: 10%;
        border-radius: 0;
        opacity: 0;
    }

    .flickity-button:active {
      opacity: 0;
    }

    .flickity-button:disabled {
      display: none;
    }

    .gallery-container .flickity-viewport:has(.flickity-prev-next-button.next:hover) > div {
        transition: 300ms;
    }

    .gallery-container:has(.flickity-prev-next-button.next:hover) .flickity-viewport > div {
        left: -50px!important;
    }

    .gallery-container:has(.flickity-prev-next-button.previous:hover) .flickity-viewport > div {
        left: 50px!important;
    }

    .flickity-lightbox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .flickity-lightbox img {
        max-width: 80%;
        max-height: 80%;
    }

  </style>

  <div class="gallery-container">

    <?php foreach( $gallery as $image ) : ?>

      <div class="image-container">
        <?php echo wp_get_attachment_image( $image, 'full' ); ?>
      </div>

    <?php endforeach; ?>

  </div>

  <script>

    jQuery(document).ready(function($) {
        $('.gallery-container').flickity({
            // options
            cellAlign: 'center',
            contain: false,
            wrapAround: true,
            pageDots: false,
            fullscreen: true,
            lazyLoad: 1
        });

        const imageContainers = document.querySelectorAll('.gallery-container .image-container');
        imageContainers.forEach(container => {
          container.style.height = '100%';
        })

        $('.gallery-container').on( 'click', '.image-container.is-selected img', function() {
            let imgSrc = $(this).attr('src');
            $('body').append('<div class="flickity-lightbox"><img src="' + imgSrc + '"></div>');
        });

        $('body').on('click', '.flickity-lightbox', function() {
            $(this).remove();
        });
    });

  </script>

<?php endif; ?>