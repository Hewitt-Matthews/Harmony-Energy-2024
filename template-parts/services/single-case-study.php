<?php

$featured_case_study;

if(is_singular( 'services' )) $featured_case_study = get_field('featured_case_study');
if(is_singular( 'how-we-work' )) $featured_case_study = get_field('featured_case_study_process');
if(is_singular( 'offices' )) $featured_case_study = get_field('featured_case_study_office');

if ( $featured_case_study ) : 

  $title = get_the_title($featured_case_study);
  $link = get_the_permalink($featured_case_study);
  $intro = get_field('case_study_intro', $featured_case_study);
  $featuredImg = wp_get_attachment_image_url( get_post_thumbnail_id($featured_case_study), 'large', false, "" );

?>

  <style>
    .case-study-container {
        position: relative;
        min-height: 100vh;
        background-size: cover;
        padding: 5em calc(calc(100vw - min(1250px, 80vw)) / 2);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: flex-start;
    }

    .case-study-container::before {
        content: "";
        position: absolute;
        inset: 0;
        background-color: rgb(var(--black) / 40%);
    }

    #page-container .case-study-container * { 
      color: rgb(var(--white));
      border-color: rgb(var(--white));
      position: relative;
      z-index: 2;
    }

    .case-study-container p {
      max-width: 600px;
    }

  </style>

  <div class="case-study-container" style="background-image: url(<?= $featuredImg ?>);">

    <h2>Case Study</h2>

    <p><?= $intro ?></p>

    <a class="btn-primary" href="<?= $link ?>">Read Case Study</a>

  </div>

<?php endif; ?>