<?php

$highlighted_post = get_field('highlighted_post', 81);

if ( $highlighted_post ) : 

  $permalink = get_permalink( $highlighted_post );
  $title = get_the_title( $highlighted_post );
  $excerpt = get_field('sub_title', $highlighted_post) ?: limit_text(get_the_excerpt($highlighted_post), 20) . '...';
  $image_url = get_field('banner', $highlighted_post);
  $image_id = attachment_url_to_postid($image_url);
  

?>

  <style>

    .blog .et_pb_section_0_tb_body .et_pb_code_inner {
        position: static;
    }

    .highlighted-post .featured-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100vw;
        opacity: 0.7;
        z-index: -1;
		height: 100%;
    }

    .highlighted-post .featured-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .highlighted-post :is(h1, p) {
      color: rgb(var(--white));
      max-width: 1000px;
    }

    .highlighted-post .btn-primary {
        margin-top: 1em;
    }

  </style>

  <div class="highlighted-post">

    <div class="featured-image">

      <?= wp_get_attachment_image( $image_id, "large", true, array( "loading" => "lazy" ) ); ?>

    </div>

    <h1><?= $title ?></h1>
    <p><?= $excerpt ?></p>

    <a class="btn-primary" href="<?= $permalink ?>">Read article</a>

  </div>

<?php endif; ?>