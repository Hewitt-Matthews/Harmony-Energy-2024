<?php

$currentPersonID = get_the_ID();
$meta_query = NULL;

if ( is_singular('people') ) :

	$meta_query = array( 
    array(
      'key' => 'person',
      'value' => $currentPersonID,
      'compare' => 'LIKE'
    )
	);

endif;

$testimonialsQuery = new WP_Query( array(
	'post_type' => 'testimonials',
	'posts_per_page' => 8,
	'meta_query' => $meta_query
)); 

$item_count = $testimonialsQuery->found_posts; ?>

<style>
	
	.testimonials-slider-container {
		background-color: rgb(var(--secondary));
		padding: 3em;
	}

	.testimonials-slider-container::before {
    content: url(/wp-content/uploads/2023/07/Quote-mark.svg);
		margin-bottom: 1em;
		display: block;
	}

	.testimonials-slider-container .slider-wrapper {
		display: flex;
		/* overflow-x: scroll; */
		overflow-x: hidden;
		scroll-behavior: smooth;
  	scroll-snap-type: x mandatory;
	}

	.testimonials-slider-container .slider-wrapper .testimonial {
		flex: 0 0 100%;
		scroll-snap-align: start;
	}

	.testimonials-slider-container .slider-wrapper .testimonial * {
		color: #fff;
	}

	.testimonials-slider-container .arrows {
		display: flex;
		align-items: center;
		gap: 2em;
		max-width: 90px;
		height: 30px;
		margin-top: 1rem;
	}

	.testimonials-slider-container .arrows > div {
		display: block;
		background-color: #fff;
		height: 100%;
		width: 100%;
		cursor: pointer;
		position: relative;
		box-shadow: inset 0px 15px 0px 0px rgb(var(--secondary)), 
					inset 0px -13px 0px 0px rgb(var(--secondary));
	}

	.testimonials-slider-container .arrows > div.prev {
		transform: rotate(180deg) translateY(-2px);
	}

	.testimonials-slider-container .arrows > div::before,
	.testimonials-slider-container .arrows > div::after {
		content: "";
		height: 2px;
		width: 18px;
		background-color: #fff;
		position: absolute;
		right: -3px;
	}

	.testimonials-slider-container .arrows > div::before {
		transform: rotate(45deg);
    	top: 9px;
	}

	.testimonials-slider-container .arrows > div::after {
		transform: rotate(-45deg);
    	top: calc(100% + -9px);
	}

</style>

<div class="testimonials-slider-container">

	<?php if ( $testimonialsQuery->have_posts() ) : ?>

		<div class="slider-wrapper">
		
			<?php while ( $testimonialsQuery->have_posts() ) : $testimonialsQuery->the_post();
			
				$review = get_the_content();
				$name = get_the_title();
			
			?>
			
				<div class="testimonial">
					
					<div class="quote"></div>
							
					<div class="meta">

						<p><?= $review ?></p>
						<p><?= $name ?></p>

					</div>
						
				</div>
			
			<?php endwhile; wp_reset_postdata(); ?>
			
			
		</div>
		
    <?php if ( $item_count > 1) : ?>

      <div class="arrows">
        <div class="prev"></div>
        <div class="next"></div>
      </div>

      <script>

        window.addEventListener('load', () => {

          const arrows = document.querySelectorAll('.testimonials-slider-container .arrows > div');

          const changeSlide = (e) => {

            const sliderWrapper = document.querySelector('.testimonials-slider-container .slider-wrapper');
            const direction = e.target.classList[0];

            let scrollAmount;

            if(direction === "prev") {
              scrollAmount = -1;
            } else {
              scrollAmount = 1;
            }

            sliderWrapper.scrollBy({
              top: 0,
              left: scrollAmount,
              scrollBehaviour: 'smooth'
            })

          }
          
          arrows.forEach(arrow => {
            arrow.addEventListener('click', changeSlide);
            console.log('click');
          })

        })

      </script>

    <?php endif; ?>
		
	<?php else : ?>

		<script>document.querySelector('.testimonials-slider-container').closest('.et_pb_section').remove();</script>

	<?php endif; ?>
	
</div>