<?php

$stats_graphical = get_field('stats_graphical');

if ( $stats_graphical ) : ?>

  <style>
    .stats-graphical-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(min(100%, 150px), 1fr));
      gap: 2em;
    }

    .stats-graphical-container .bar-container {
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      height: min(400px, 80vh);
      margin-bottom: 1em;
      background-color: rgb(var(--secondary) / 10%);
      padding: 1em;
    }

    .stats-graphical-container .bar-container .bar {
      height: var(--barHeight);
      width: auto;
      margin: 0 -1em -1em -1em;
      transform: scaleY(0);
      transform-origin: bottom;
      transition: 2s;
      transition-delay: var(--transitionDelay);
    }

    .stats-graphical-container .stat:nth-child(3n + 1) .bar-container .bar {
      background-color: rgb(var(--harmonyBlue));
    }

    .stats-graphical-container .stat:nth-child(3n + 2) .bar-container .bar {
      background-color: rgb(var(--blueGrey));
    }

    .stats-graphical-container .stat:nth-child(3n + 3) .bar-container .bar {
      background-color: rgb(var(--lightBlue));
    }

    .stats-graphical-container.active .bar-container .bar {
      transform: scaleY(1);
    }

  </style>

  <div class="stats-graphical-container">

    <?php $i = 1; foreach( $stats_graphical as $stat ) :

      $stat_title = $stat['stat_title'];
      $stat_description = $stat['stat_description'];
      $stat_bar_height = $stat['stat_bar_height'];
      $bar_appended_description = $stat['bar_appended_description'];

    ?>

      <div class="stat">

        <div class="bar-container">
          <p><?= $bar_appended_description ?></p>
          <div class="bar" style="--barHeight: <?= $stat_bar_height ?>%; --transitionDelay: <?= 150 * $i ?>ms;"></div>
        </div>

        <h3><?= $stat_title ?></h3>
        <p><?= $stat_description ?></p>

      </div>
          
      
    <?php $i++; endforeach; ?>
  
  </div>

  <script>

      window.addEventListener('load', () => {

        const barGraphContainers = document.querySelectorAll('.stats-graphical-container');

        //Set the intersection options
        let options = {};

        //Create the callback function for the observer

        const callback = (entries, observer) => {

          entries.forEach(entry => {

            const target = entry.target;
            
            if(entry.isIntersecting && !target.classList.contains('active')) {
              target.classList.add('active');
              observer.unobserve(entry.target);
            }

          })

        }

        //Create the observer
        let observer = new IntersectionObserver(callback, options);

        barGraphContainers.forEach(container => {
          observer.observe(container);
        })

      })

  </script>

<?php endif; ?>