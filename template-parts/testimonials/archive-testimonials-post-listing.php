<?php

$testimonialsQuery = new WP_Query( array(
  'post_type' => 'testimonials',
  'posts_per_page' => -1
));

if ( $testimonialsQuery ) : ?>

<style>
  .testimonials-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(min(100%, 400px), 1fr));
    gap: 2em;
  }
  .testimonials-container .testimonial {
    display: flex;
    flex-direction: column;
    gap: 2em;
    background-color: #ffffff;
    border-radius: 25px;
    padding: 2em;
  }
  .testimonials-container .testimonial:nth-of-type(5) {
    background-color: rgb(var(--davisonsOrange));
    grid-column: 1 / -1;
    display: flex;
    flex-direction: row;
    gap: 3em;
    padding: 6em;
    border-radius: 0px;
    margin-top: 2em;
  }
  .testimonials-container .testimonial:nth-of-type(5) .review {
    font-size: 28px;
    font-weight: bold;
  }
  .testimonials-container .testimonial:nth-of-type(5) .meta .name {
    font-weight: normal;
  }
  .testimonials-container .testimonial:nth-of-type(5) .logo {
    --logoSize: 160px;
  }
  @media (max-width: 1054px) {
    .testimonials-container .testimonial:nth-of-type(5) {
      display: flex;
      flex-direction: column;
    }
  }
  .testimonials-container .testimonial .logo {
    --logoSize: 100px;
    width: var(--logoSize);
    height: var(--logoSize);
    border-radius: 50%;
    background-color: #fff;
    display: grid;
    place-items: center;
    margin: 0 auto;
  }
  .testimonials-container .testimonial .logo img {
    width: 55%;
  }
  .testimonials-container .testimonial .content p:not(p.name) {
    font-weight: 600;
    font-family: 'Fedra Sans Std';
  }
  .testimonials-container .testimonial:nth-child(5) .content p {
    font-size: 22px;
  }
  .testimonials-container .testimonial .quote {
    position: relative;
    quotes: "“" "”" "“" "”";
  }
  .testimonials-container .testimonial .quote::before {
    content: open-quote;
    position: absolute;
    top: 0;
    font-size: 100px;
    line-height: 1;
    font-family: math;
    color: rgb(var(--primary));
  }
  .testimonials-container .testimonial .meta p.review {
    font-size: 20px;
  }
  .testimonials-container .testimonial .meta p.name {
    font-weight: bold;
  }
  .testimonials-container .testimonial .content p.name {
    font-weight: 300;
    font-size: 16px;
  }
  .testimonials-container .testimonial .content p.name span {
    display: block;
  }
  .testimonials-container .testimonial:nth-child(5) .content p.name span {
    display: inline-block;
  }
  @media only screen and (max-width: 500px) {
    .testimonials-container .testimonial {
      grid-template-columns: 1fr;
    }
  }
  .testimonials-container .testimonial-videos {
    /* grid-column: 1 / -1;
    margin: 2em 0; */
    grid-column: 1 / -1;
    --fullWidth: calc(calc(calc(100vw - min(1250px,80vw)) / 2) / -1);
    margin: 4em var(--fullWidth) 5em;
  }
  /* .testimonials-container .testimonial-videos .et_pb_row {
    width: 100%;
    max-width: 100%;
  } */
  .testimonials-container .testimonial-videos-hide {
    display: none;
  }
</style>

<div class="testimonials-container">
	
	<?php $count = 1; $num = $testimonialsQuery->post_count; while ( $testimonialsQuery->have_posts() ) : $testimonialsQuery->the_post();
	
		$imageID = get_post_thumbnail_id(get_the_id());
		$image = wp_get_attachment_image( get_post_thumbnail_id(get_the_id()), "large", true, array( "loading" => "lazy" ) );
		$review = get_the_content();
		$name = get_the_title();
	
	?>
	
  <div class="testimonial">
    
    <?php if ( $imageID !== 0 ) : ?>
    
      <div class="logo">
        <?= $image ?>
      </div>
    
    <?php else : ?>

      <?php if ($count == 5) : ?>

        <img src="/wp-content/uploads/2023/07/quote.png" alt="Quote Mark Icon" width="180px" height="180px" />

      <?php else: ?>

        <div class="quote"></div>

      <?php endif; ?>
    
    <?php endif; ?>

    <div class="meta">

      <p class="review"><?= $review ?></p>
      <p class="name"><?= $name ?></p>

    </div>
      
  </div>

  <?php if ( $count == 5 ) : ?>

    <div class="testimonial-videos">
        
      <?php //do_shortcode('[et_pb_section global_module="1297"][/et_pb_section]'); ?>
        
    </div>

  <?php elseif ( $count == $num && $num < 5 ) : ?>

    <div class="testimonial-videos-hide">
        
      <?php //do_shortcode('[et_pb_section global_module="1297"][/et_pb_section]'); ?>
        
    </div>

  <?php endif; ?>
	
	<?php $count++; endwhile; wp_reset_postdata(); ?>
	
</div>

<?php endif; ?>