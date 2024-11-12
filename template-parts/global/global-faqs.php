<?php

$faqs = get_field('faqs', 'options');
$is_service_page = is_singular( 'services' );

if ( $faqs ) : ?>

  <style>
      .faqs-container {
        display: grid;
        gap: 1em;
    }

    .faqs-container .faq {
        border: solid 1px rgb(var(--secondary) / 50%);
        padding: 2em;
        transition: 300ms;
    }

    .faqs-container .faq:hover {
      cursor: pointer;
      background-color: rgb(var(--secondary) / 20%);
    }

    .faqs-container .faq .question {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1em;
    }

    .faqs-container .faq .question::after {
        content: "+";
        font-size: 60px;
        line-height: 1;
        font-weight: 100;
    }

    .faqs-container .faq .answer {
        max-height: 0;
        overflow: hidden;
        transition: 300ms;
    }

    .faqs-container .faq.active .answer{
      max-height: var(--maxHeight);
    }

    .faqs-container .faq.active .question::after {
        content: "-";
    }
  </style>

  <div class="faqs-container">

    <?php foreach ( $faqs as $faq ) : 
      if($is_service_page) {
        $faq_service = $faq['service'][0];
        $current_service_id = get_queried_object_id();

        if($faq_service) {
          if($faq_service !== $current_service_id) continue;
        }


      }
      
      ?>

      <div class="faq">

        <div class="question">
          <?= $faq['question'] ?>
        </div>

        <div class="answer">
          <?= $faq['answer'] ?>
        </div>

      </div>

    <?php endforeach; ?>

  </div>

  <script>

      window.addEventListener('load', () => {

        const faqContainer = document.querySelector('.faqs-container');
        const questions = faqContainer.querySelectorAll('.faq');

        if(!questions.length){
          faqContainer.closest('.et_pb_section').remove();
          return;
        }

        const toggleQuestion = (e) => {

          const currentQuestion = e.currentTarget;
          const closestSection = currentQuestion.closest('.et_pb_section');
          closestSection.setAttribute('style', 'scroll-snap-align: none;');

          currentQuestion.classList.toggle('active');

          setTimeout(() => {
            closestSection.removeAttribute('style');
          }, 1000);

        }

        questions.forEach(question => {

          const answer = question.querySelector('.answer');
          question.setAttribute('style', `--maxHeight: ${answer.scrollHeight}px`)

          question.addEventListener('click', toggleQuestion)
        })

      });

      window.addEventListener('resize', () => {

        const faqContainer = document.querySelector('.faqs-container');
        const questions = faqContainer.querySelectorAll('.faq');

        questions.forEach(question => {

          const answer = question.querySelector('.answer');
          question.setAttribute('style', `--maxHeight: ${answer.scrollHeight}px`)

        })

      });

  </script>

<?php endif; ?>