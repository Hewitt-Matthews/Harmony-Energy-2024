<?php

$timeline = get_field('timeline');

if ( $timeline ) : ?>

  <style>
    .timeline-container .main-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr));
        gap: 3em;
        align-items: center;
    }

    .timeline-container .main-wrapper :is(.timeline-content .year, .timeline-images > div) {
      position: absolute;
      opacity: 0;
    }

    .timeline-container .main-wrapper :is(.timeline-content .year, .timeline-images > div).active {
        position: relative;
        opacity: 1;
        transition: opacity 400ms;
    }

    .timeline-container .main-wrapper .image-container img {
        position: absolute;
    }


    .timeline-container .main-wrapper .image-container.active img {
        position: relative;
        height: min(80vw, 400px);
        object-fit: cover;
    }

    .arrows {
        margin-top: 2em;
    }

    .arrows > div {
        background-image: url(/wp-content/uploads/2023/10/arrow.svg);
        background-repeat: no-repeat;
        background-position: center;--arrowSize: 30px;
        width: var(--arrowSize);
        height: var(--arrowSize);
        display: inline-block;
        border: solid 2px rgb(var(--secondary));
        border-radius: 50%;
        padding: 1em;
        filter: invert(1);
        opacity: 0.6;
        cursor: pointer;
        transition: 300ms;
    }

    .inverted .arrows > div {
        filter: none;
    }

    .arrows > div:first-child {
        transform: rotate(180deg);
        margin-right: 1em;
    }

    .arrows > div:hover {
        /* opacity: 1; */
    }

    .timeline-bar {
      --paddingLeft: calc(calc(100vw - min(1250px, 80vw)) / 2);
      --horizontalMargin: calc(var(--paddingLeft) / -1);
      position: relative;
      margin: 3em var(--horizontalMargin) 0;
      display: grid;
      grid-auto-flow: column;
      gap: 2em;
      align-items: center;
      overflow-x: scroll;
      padding-bottom: 2em;
      padding-left: var(--paddingLeft);
      padding-right: calc(min(1250px, 80vw) + var(--paddingLeft) - 72px);
    }

    .timeline-bar::-webkit-scrollbar{
      display: none;
      width: 0 !important
    }

    .timeline-bar::before {
      content: "";
      background-color: rgb(var(--secondary));
      width: 100vw;
      position: absolute;
      bottom: 0.88em;
      left: calc(50% - var(--leftPosition, 0px));
      transform: translateX(-50%);
      height: 2px
    }

    .timeline-bar .year-marker {
        position: relative;
        font-size: 24px;
        white-space: nowrap;
        text-align: center;
    }

    .timeline-bar .year-marker::after {
        content: "";
        --circleSize: 15px;
        position: absolute;
        width: var(--circleSize);
        height: var(--circleSize);
        background-color: rgb(var(--primary));
        outline: solid 2px rgb(var(--secondary));
        border-radius: 50%;
        top: calc(calc(100% + 1rem) - 2px);
        left: 50%;
        transform: translateX(-50%);
    }

    .timeline-bar .year-marker > span {
        opacity: 0.5;
        display: block;
        transition: 300ms;
        cursor: pointer;
    }

    .timeline-bar .year-marker:hover > span {
        opacity: 0.8;
    }

    .timeline-bar .year-marker.active > span {
        opacity: 1;
        transform: scale(1.25);
    }

    @media only screen and (max-width: 980px) {
      
      .timeline-container .main-wrapper {
          display: flex;
          flex-direction: column-reverse;
          align-items: flex-start;
          gap: 1em;
      }

    }

  </style>

  <div class="timeline-container">

    <div class="main-wrapper">

      <div class="timeline-content">

        <?php $i = 1; foreach( $timeline as $item ) :

          $year = $item['year'];
          $content_text = $item['content_text'];
          $content_image = $item['content_image'];
          $image = wp_get_attachment_image( $content_image, "large", true, array( "loading" => "lazy" ) );

        ?>
                
          <div class="year <?= $i == 1 ? "active" : ""; ?>" data-year="<?= $year . '-' . $i ?>">
            
            <h2><?= $year ?></h2>
            <?= $content_text ?>
            
          </div>
        <?php $i++; endforeach; ?>

        <div class="arrows">
          <div></div>
          <div></div>
        </div>

      </div>
    
      <div class="timeline-images">

        <?php $i = 1; foreach( $timeline as $item ) :

          $year = $item['year'];
          $content_image = $item['content_image'];
          $image = wp_get_attachment_image( $content_image, "large", true, array( "loading" => "lazy" ) );

        ?>
                
          <div class="image-container <?= $i == 1 ? "active" : ""; ?>" data-year="<?= $year . '-' . $i ?>">
            
            <?= $image ?>
            
          </div>
        <?php $i++; endforeach; ?>


      </div>
    
    </div>

    <div class="timeline-bar">

          <?php $i = 1; foreach( $timeline as $item ) :

            $year = $item['year'];

          ?>
                
          <div class="year-marker <?= $i == 1 ? "active" : ""; ?>" data-year="<?= $year . '-' . $i ?>">
            
            <span><?= $year ?></span>
            
          </div>
        <?php $i++; endforeach; ?>

    </div>
  
  </div>

  <script>

    document.addEventListener("DOMContentLoaded", () => {

      const arrows = document.querySelectorAll('.timeline-content .arrows div');
      const years = document.querySelectorAll('.timeline-content .year');
      const images = document.querySelectorAll('.timeline-images .image-container');
      const yearMarkers = document.querySelectorAll('.timeline-bar .year-marker');

      let activeYear = document.querySelector('.timeline-content .year.active');
      let activeImage = document.querySelector('.timeline-images .image-container.active');
      let activeYearMarker = document.querySelector('.timeline-bar .year-marker.active');

      let isArrowOrYearClicked = false;

      const removeActiveClassFromSlide = (year, image, marker) => {

          year.classList.remove('active');
          image.classList.remove('active');
          marker.classList.remove('active');

      }

      const addActiveClassToSlide = (year, image, marker) => {

        year.classList.add('active');
        image.classList.add('active');
        marker.classList.add('active');

      }

      arrows.forEach((arrow, index) => {
        arrow.addEventListener('click', () => {
          isArrowOrYearClicked = true;

          let nextYear, nextImage, nextYearMarker;

          // Remove active class from current active elements
          removeActiveClassFromSlide(activeYear, activeImage, activeYearMarker);

          // Determine next active element depending on which arrow was clicked
          if (index === 0) { // Previous arrow
            nextYear = activeYear.previousElementSibling ? activeYear.previousElementSibling : years[years.length - 1];
            // Skip '.arrows' div
            if(nextYear.classList.contains('arrows')) {
              nextYear = nextYear.previousElementSibling || years[years.length - 1];
            }
          } else { // Next arrow
            nextYear = activeYear.nextElementSibling ? activeYear.nextElementSibling : years[0];
            // Skip '.arrows' div
            if(nextYear.classList.contains('arrows')) {
              nextYear = nextYear.nextElementSibling || years[0];
            }
          }

          const year = nextYear.getAttribute('data-year');

          // Fetch the appropriate '.timeline-images .image-container' using the new '.timeline-content .year' year dataset attribute
          nextImage = Array.from(images).find(image => image.getAttribute('data-year') === year);

          // Fetch the appropriate '.timeline-bar .year-marker' using the new '.timeline-content .year' year dataset attribute
          nextYearMarker = Array.from(yearMarkers).find(marker => marker.getAttribute('data-year') === year);

          const timelineBar = arrow.closest('.timeline-container').querySelector('.timeline-bar');

          timelineBar.scrollBy({
            top: 0,
            left: nextYearMarker.getBoundingClientRect().x + timelineBar.offsetLeft,
            behavior: "smooth",
          })

          // Set new active elements
          addActiveClassToSlide(nextYear, nextImage, nextYearMarker);

          // Update active variables
          activeYear = nextYear;
          activeImage = nextImage;
          activeYearMarker = nextYearMarker;
          
          setTimeout(() => {
            isArrowOrYearClicked = false;
          }, 300);

        });
      });

      // Make each year in the timeline-bar clickable
      yearMarkers.forEach(marker => {

        marker.addEventListener('click', () => {

          isArrowOrYearClicked = true;

          const timelineBar = marker.closest('.timeline-bar');

          timelineBar.scrollBy({
            top: 0,
            left: marker.getBoundingClientRect().x + timelineBar.offsetLeft,
            behavior: "smooth",
          })

          // Remove active class from current active elements
          removeActiveClassFromSlide(activeYear, activeImage, activeYearMarker);

          const year = marker.getAttribute('data-year');

          // Find the corresponding '.timeline-content .year' and '.timeline-images .image-container' elements
          const nextYear = Array.from(years).find(y => y.getAttribute('data-year') === year);
          const nextImage = Array.from(images).find(image => image.getAttribute('data-year') === year);

          // Set new active elements
          addActiveClassToSlide(nextYear, nextImage, marker);

          // Update active variables
          activeYear = nextYear;
          activeImage = nextImage;
          activeYearMarker = marker;

          setTimeout(() => {
            isArrowOrYearClicked = false;
          }, 300);

        });

      });

      const timelineBar = document.querySelector('.timeline-bar');
      let distanceObject = {};

      function debounce(method, delay) {
          clearTimeout(method._tId);
          method._tId= setTimeout(function(){
              method();
          }, delay);
      }

      timelineBar.addEventListener('scroll', (e) => {

        const x = e.target.querySelector('.year-marker').getBoundingClientRect().x + e.target.offsetLeft;

        timelineBar.setAttribute('style', `--leftPosition: ${x}px;`);

        if(isArrowOrYearClicked) return;

        const scrollThroughSlides = () => {

          const yearMarkers = e.target.querySelectorAll('.year-marker');

          yearMarkers.forEach((marker, i) => {

            distanceObject[i] = distanceObject[i] || {}; 

            distanceObject[i]["marker"] = marker.dataset.year;
            distanceObject[i]["x"] = marker.getBoundingClientRect().x + e.target.offsetLeft;

          })

          const arr = Object.keys(distanceObject).map(key => ({...distanceObject[key], id: key}));
          arr.sort((a, b) => Math.abs(a.x) - Math.abs(b.x));

          removeActiveClassFromSlide(activeYear, activeImage, activeYearMarker);

          const nextYear = e.target.closest('.timeline-container').querySelector(`.timeline-content .year[data-year="${arr[0].marker}"]`);
          const nextImage = e.target.closest('.timeline-container').querySelector(`.timeline-images .image-container[data-year="${arr[0].marker}"]`);
          const nextYearMarker = e.target.closest('.timeline-container').querySelector(`.timeline-bar .year-marker[data-year="${arr[0].marker}"]`);

          // Set new active elements
          addActiveClassToSlide(nextYear, nextImage, nextYearMarker);

          // Update active variables
          activeYear = nextYear;
          activeImage = nextImage;
          activeYearMarker = nextYearMarker;

        }
        
        
        debounce(scrollThroughSlides, 200)

      })

    });



  </script>

<?php endif; ?>