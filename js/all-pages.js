const animateOnScroll = () => {
  //Animation 
	const allSections = document.querySelectorAll('.et_pb_row:not(footer .et_pb_row):not(.archive.category .et_pb_row_0_tb_body):not(.archive.category .et_pb_row_1_tb_body):not(.page-id-341 .et_pb_section_6 .et_pb_row):not(.single-post .et_pb_row_0_tb_body):not(.single-post .et_pb_row_1_tb_body)');
  
  allSections.forEach(section => {
    section.setAttribute('data-aos', 'fade-up');
  });
  
  AOS.init();
}


const setHTMLTagOpacityForCLSFix = () => {
  document.querySelector('html').setAttribute('style', 'opacity: 1;');
  console.log('loaded');
}

const peopleModalInit = () => {

  const people = document.querySelectorAll('.people-container > .person');
  const modalCloseBtns = document.querySelectorAll('.people-container > .person dialog .close');
  
  if (people.length === 0) return;

  const openModal = (e) => {

    const anchor = e.currentTarget;

    if(!anchor.classList.contains('open-modal')) return;

    const postID = anchor.getAttribute('data-post-id'); // Get the post ID from the data attribute
    const modal = document.getElementById('person-' + postID); // Find the corresponding modal by ID

    // Display the modal
    modal.showModal();

  }

  const closeModal = (e) => {
    e.stopPropagation();
    const modal = e.target.closest('dialog');
    modal.close();
  }

  people.forEach(person => {
    person.addEventListener('click', openModal)
  })

  modalCloseBtns.forEach(closeBtn => {
    closeBtn.addEventListener('click', closeModal)
  })

}

const ceoModalInit = () => {
  
  var ceoContainer = document.querySelector('.ceo-container');

  if(!ceoContainer) return;
  
  ceoContainer.addEventListener('click', function(e) {
    if(e.target.classList.contains('open-ceo')) {
      e.preventDefault(); // Prevent the anchor from navigating
  
      var modal = document.getElementById('ceo'); // Find the corresponding modal by ID
  
      // Display the modal
      modal.showModal()
  
      // When the close button is clicked
      modal.querySelector('.close').addEventListener('click', function() {
        modal.close()
      });
  
      // When the user clicks outside the modal, close it
      window.addEventListener('click', function(event) {
        if (event.target == modal) {
          modal.close();
        }
      });
    }
  });

}

const togglePageColourTransition = () => {

  // Get the bounding client rect of the background transition element
  const pageBody = document.querySelector('#main-content');
  console.log(initial_page_colour)
  if(initial_page_colour == "white") pageBody.closest('body').classList.add('inverted');
  const transition_point = 0.5;

	

	if(initial_page_colour == "white") {

		const footerLogo = document.querySelector('footer .et_pb_image_0_tb_footer img');

		// Check if the image element exists before changing its src attribute
		if (footerLogo) {
			footerLogo.src = '/wp-content/uploads/2023/11/white-logo.png';
		}

	}	
	
	
  window.addEventListener('scroll', () => {

    const rect = pageBody.getBoundingClientRect();

    // Calculate the percentage of the element that is in view
    const percentageInView = (rect.height - Math.abs(rect.top)) / rect.height;

    if(initial_page_colour == "white") {

      if (percentageInView > transition_point) {

        pageBody.closest('body').classList.add('inverted');
  
      } else {
        
        pageBody.closest('body').classList.remove('inverted');
  
      }

    } else {

      // Check if the element is more than the transition point defined on the page
      if (percentageInView < transition_point) {
        pageBody.closest('body').classList.add('inverted');
      } else {
        pageBody.closest('body').classList.remove('inverted');
      }

    }


  });

}

const spacebarSectionNavigation = () => {

  document.addEventListener("keydown", function(event) {
    // Check if the pressed key is the spacebar (key code 32)
    if (event.keyCode === 32) {
	  console.log('keydown 32');
      // Prevent the default spacebar action (page down)
      event.preventDefault();
  
      // Get all elements with the class '.et_pb_section' in a NodeList
      const sections = document.querySelectorAll(".et_pb_section");
  
      // Get the current scroll position
      const currentScrollY = window.scrollY;
  
      // Find the next section to scroll to
      for (let i = 0; i < sections.length; i++) {
        const section = sections[i];
        const sectionTop = section.offsetTop;
  
        // Check if this section is below the current scroll position
        if (sectionTop > currentScrollY) {
          // Scroll to this section
          window.scrollTo({
            top: sectionTop,
            behavior: "smooth",
          });
          break; // Exit the loop as we've found our section
        }
      }
    }
  });
  

}

const tabsSectionsInit = () => {

	const tabsSection = document.querySelectorAll('.tabs-wrapper');

	if(!tabsSection.length) return;

	tabsSection.forEach(tabSection => {
	
		//Find first tab and check the input
		const firstTabInput = tabSection.querySelector('.tab input');
		firstTabInput.checked = true;
    firstTabInput.setAttribute('checked', 'checked');
    console.log(firstTabInput.checked)
    
		//Find first content and make active
		const firstTabContent = tabSection.querySelector('.tab-content');
		firstTabContent.classList.add('active');

		//Create toggle Event
		const toggleTabContent = (e) => {

			const tabCategory = e.currentTarget.dataset.tab;

			const currentActiveContent = e.currentTarget.closest('.tabs-wrapper').querySelector('.tab-content.active');
			currentActiveContent.classList.remove('active');

			const tabContent = e.currentTarget.closest('.tabs-wrapper').querySelector(`.tab-content[data-tab="${tabCategory}"]`);
			tabContent.classList.add('active');
		}

		//Assign toggle event to inputs
		const tabInputs = tabSection.querySelectorAll('.tab input');
		tabInputs.forEach(input => {
			input.addEventListener('click', toggleTabContent);
		})

	})

}

const statAnimations = () => {

	const statsContainers = document.querySelectorAll( '.stats-container' );

	if(!statsContainers) return;

	// How long you want the animation to take, in ms
	const animationDuration = 2000;
	// Calculate how long each ‘frame’ should last if we want to update the animation 60 times per second
	const frameDuration = 1000 / 60;
	// Use that to calculate how many frames we need to complete the animation
	const totalFrames = Math.round( animationDuration / frameDuration );
	// An ease-out function that slows the count as it progresses
	const easeOutQuad = t => t * ( 2 - t );
	// The animation function, which takes an Element
	const animateCountUp = el => {
    let frame = 0;
    const elementDescription = el.nextElementSibling.textContent;
    let isYear = false;
    if(elementDescription.toLowerCase().includes("year")) {
      isYear = true;
    }
``
    const countTo = parseFloat( el.innerHTML ); // Use parseFloat here
    const decimalPlaces = countTo.toString().split('.')[1]?.length || 0; // Determine the number of decimal places
    // Start the animation running 60 times per second
    const counter = setInterval( () => {
        frame++;
        // Calculate our progress as a value between 0 and 1
        const progress = easeOutQuad( frame / totalFrames );
        // Use the progress value to calculate the current count
        const currentCount = (countTo * progress).toFixed(decimalPlaces); // Use toFixed here
        
        // If the current count has changed, update the element
        if ( parseFloat( el.innerHTML ) !== parseFloat(currentCount) ) { // Use parseFloat here
            
            el.innerHTML = isYear ? Number(currentCount) : Number(currentCount).toLocaleString('en-GB', { minimumFractionDigits: decimalPlaces, maximumFractionDigits: decimalPlaces });
        }

        // If we’ve reached our last frame, stop the animation
        if ( frame === totalFrames ) {
            clearInterval( counter );
        }
    }, frameDuration );
  };


	// Run the animation on all elements with a class of ‘countup’
	const runAnimations = (stats) => {
		stats.forEach( stat => {
			stat.closest('.stat').classList.remove('hidden');
			animateCountUp(stat);
		} );
	};

	//Set the intersection options
	let options = {};

	//Create the callback function for the observer

	const callback = (entries, observer) => {

		entries.forEach(entry => {

			const target = entry.target.querySelector('.stats-container');
			
			if(entry.isIntersecting && !target.classList.contains('active')) {
				target.classList.add('active');
				const stats = entry.target.querySelectorAll('.number');
				if(stats) {
					runAnimations(stats);
				}
				observer.unobserve(entry.target);
			}

		})

	}

	//Create the observer
	let observer = new IntersectionObserver(callback, options);

	statsContainers.forEach(statsContainer => {
		observer.observe(statsContainer.parentElement);
	})
}

const setScrollBehaviour = () => {

  let timeout;

  // Function to run when scrolling has stopped
  function onScrollEnd() {
    // Get the section currently at the top of the viewport
    let sections = document.querySelectorAll('#page-container #et-main-area .et_pb_section');
    let topSection = Array.from(sections).find(section => {
      const threshold = 50; // Adjust this threshold (px) value to your preference
      let rect = section.getBoundingClientRect();
      return Math.abs(rect.top) < threshold;  
    });

    // If a top section is found, check its height and update scroll-snap-type accordingly
    if (topSection) {
      let isTallSection = topSection.offsetHeight > window.innerHeight;
      document.documentElement.style.scrollSnapType = !isTallSection ? 'y mandatory' : 'y proximity';
    }
  }
  
  // Attach scroll event listener to update scroll-snap-type when scrolling has stopped
  window.addEventListener('scroll', () => {
    clearTimeout(timeout);
    timeout = setTimeout(onScrollEnd, 100);  // Adjust timeout duration to your preference
  });
  

}

function countWords() {

  const wordCountToggle = document.createElement('div');
  wordCountToggle.classList.add('word-count-toggle');
  wordCountToggle.classList.add('btn-primary');
  wordCountToggle.setAttribute('style', 'position: fixed; bottom: 1em; right: 1em; z-index: 999999;');

  wordCountToggle.textContent = "Show Word Count";

  const toggleWordCountVisibility = () => {

    if(document.body.classList.contains('show-word-count')) {
      document.body.classList.remove('show-word-count');
      wordCountToggle.textContent = "Show Word Count";
    } else {
      document.body.classList.add('show-word-count');
      wordCountToggle.textContent = "Hide Word Count";
    }

  }

  wordCountToggle.addEventListener('click', toggleWordCountVisibility);

  document.body.appendChild(wordCountToggle);

  // Combine selectors
  const selectors = [
    'p',
    'h1',
    'h2',
    'h3',
    'h4'
  ];

  // Fetch all elements by the selectors
  const elements = document.querySelectorAll(selectors.join(','));

  // Create an empty object to hold the parent elements
  const parents = {};

  // Loop through elements to count words and append .word-count
  elements.forEach((element) => {
    // Check if the element has a parent
    const parentElement = element.parentElement;

    // If this parent exists in our object, we treat all children as one
    if (parents[parentElement]) {
      parents[parentElement].innerText += ' ' + element.innerText;
    } else {
      parents[parentElement] = document.createElement('div');
      parents[parentElement].innerText = element.innerText;
    }

    // Count the words in the current element
    const wordCount = element.innerText.split(/\s+/).filter(Boolean).length;

    if(wordCount <= 0) return;

    // Create and append the .word-count element
    const wordCountElement = document.createElement('div');
    wordCountElement.className = 'word-count';
    wordCountElement.innerText = `Word Count: ${wordCount}`;

    element.appendChild(wordCountElement);
  });

  // Now handle the edge case for parents
  for (const parent in parents) {
    // Get the combined text
    const combinedText = parents[parent].innerText;

    // Count the words in the combined text
    const combinedWordCount = combinedText.split(/\s+/).filter(Boolean).length;
    if(combinedWordCount <= 0) return;

    // Create and append the .word-count element
    const combinedWordCountElement = document.createElement('div');
    combinedWordCountElement.className = 'word-count';
    combinedWordCountElement.innerText = `Combined Word Count: ${combinedWordCount}`;
    parent.appendChild(combinedWordCountElement);
  }
}


const globalInit = () => {
  
  animateOnScroll();
  setHTMLTagOpacityForCLSFix();
  peopleModalInit();
  ceoModalInit();
  togglePageColourTransition();
  //spacebarSectionNavigation();
  statAnimations();
  tabsSectionsInit();
  setScrollBehaviour();
  //countWords();

  console.log('scripts activated');
}

window.addEventListener('load', globalInit);