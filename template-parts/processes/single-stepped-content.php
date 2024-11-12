<?php

$stepped_content = get_field('stepped_content');

if ( $stepped_content ) : ?>

<style>

.stepped-content-container > .step {
    display: grid;
    grid-template-columns: 250px 1fr;
    align-items: center;
    gap: 2em;
    padding: 2em;
    border: solid 1px rgb(var(--secondary));
    border-bottom: none;
}

.stepped-content-container > .step:last-child {
    border-bottom: solid 1px;
}

.stepped-content-container > .step .title {
    font-size: var(--h1FontSize);
}

@media only screen and (max-width: 980px) {
    
    .stepped-content-container > .step {
        grid-template-columns: 1fr;
    }
    
}

</style>

<div class="stepped-content-container">

  <?php foreach ( $stepped_content as $step ) : ?>

    <div class="step">

      <div class="title">
        <?= $step['stepped_title']; ?>
      </div>

      <div class="content">
        <?= $step['stepped_content']; ?>
      </div>

    </div>

  <?php endforeach; ?>

</div>

<?php endif; ?>