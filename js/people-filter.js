const initPeople = () => {
	
	const postsContainer = document.querySelector('.people-container');
	const postsTemplate = document.querySelector('.people-container template');
	const locationDropdown = document.querySelector('.locations-list');
  	const teamDropdown = document.querySelector('.teams-list');
	const noResultsContainer = document.querySelector('.no-results');

	const createPost = (post) => {
		
		//Get All Post Info
		const postLink = post.id;
		const postTitle = post.title;
		const postPosition = post.position;
		const postImage = post.image;
    	const postContent = post.content;

		//Create Clone of template and get all template fields
		const clone = postsTemplate.content.cloneNode(true);
		
    const personDiv = clone.querySelector('.person');
		const templateTitle = clone.querySelector('.post-name');
		const templatePosition = clone.querySelector('.post-position');
    const templateModal = clone.querySelector('.modal');
    const templateModalName = clone.querySelector('.modal-name');
    const templateModalPosition = clone.querySelector('.position');
    const templateModalContent = clone.querySelector('.content');
		
		//Assign Posts fields to template fields
    personDiv.dataset.postId = postLink;
    personDiv.style.backgroundImage = `url('${postImage}')`;
		templateTitle.textContent = postTitle;
		templatePosition.textContent = postPosition;
    templateModal.id = "person-" + postLink;
    templateModal.style.backgroundImage = `url('${postImage}')`;
    templateModalName.innerHTML = postTitle;
    templateModalPosition.innerHTML = postPosition;
    templateModalContent.innerHTML = postContent;

		return clone;

	}
	
	let selectedLocation;
  let selectedTeam;

	if ( locationDropdown ) {

		locationDropdown.addEventListener('click', async (event) => {
		//locationDropdown.addEventListener('change', async (event) => {

			event.preventDefault();

			postsContainer.innerHTML = "";

			// Check if the clicked element has the class 'btn-primary'
    		if (event.target.classList.contains('btn-primary')) {
				selectedLocation = event.target.dataset.slug;
			}
// 			const selectedIndex = event.target.selectedIndex;
// 			selectedLocation = event.target[selectedIndex].dataset.slug;

			let response;

      if (selectedLocation && selectedTeam) {
				response = await fetch(`/wp-json/he/v1/people/posts?location=${selectedLocation}&team=${selectedTeam}`);
			} else if (!selectedLocation && selectedTeam) {
				response = await fetch(`/wp-json/he/v1/people/posts?team=${selectedTeam}`);
			} else {
				response = await fetch(`/wp-json/he/v1/people/posts?location=${selectedLocation}`);
			}
			
			if (response.ok) {

				const data = await response.json();

				if (data.posts.length == 0) {
					const noResultsText = 'No Results';
					noResultsContainer.innerHTML = '';
					noResultsContainer.appendChild(document.createTextNode(noResultsText));
				} else {
					noResultsContainer.innerHTML = '';
				}

				postsContainer.append(postsTemplate);

				data.posts.forEach((post) => {
					const newPost = createPost(post);
					postsContainer.append(newPost);
				});

        // Call peopleModalInit(); in order for modals to work on the people after filtering
				peopleModalInit();

			}
		});

	}

  if ( teamDropdown ) {

		teamDropdown.addEventListener('change', async (event) => {

			event.preventDefault();

			postsContainer.innerHTML = "";

			const selectedIndex = event.target.selectedIndex;
			selectedTeam = event.target[selectedIndex].dataset.slug;

			let response;

			
      if (selectedLocation && selectedTeam) {
				response = await fetch(`/wp-json/he/v1/people/posts?location=${selectedLocation}&team=${selectedTeam}`);
			} else if (selectedLocation && !selectedTeam) {
				response = await fetch(`/wp-json/he/v1/people/posts?location=${selectedLocation}`);
			} else {
				response = await fetch(`/wp-json/he/v1/people/posts?team=${selectedTeam}`);
			}
			
			if (response.ok) {

				const data = await response.json();

				if (data.posts.length == 0) {
					const noResultsText = 'No Results';
					noResultsContainer.innerHTML = '';
					noResultsContainer.appendChild(document.createTextNode(noResultsText));
				} else {
					noResultsContainer.innerHTML = '';
				}

				postsContainer.append(postsTemplate);

				data.posts.forEach((post) => {
					
					const newPost = createPost(post);
					postsContainer.append(newPost);
				});

        // Call peopleModalInit(); in order for modals to work on the people after filtering
				peopleModalInit();

			}
		});

	}

}

const initPeopleFilter = () => {
	
	const locationDropdown = document.querySelector('.locations-list');
	const teamDropdown = document.querySelector('.teams-list');
	
	//locationDropdown.addEventListener('change', filterTeam);
	locationDropdown.addEventListener('click', filterTeam);
    teamDropdown.addEventListener('change', filterTeam);

    function filterTeam() {
		
		// Check if the clicked element has the class 'btn-primary'
    	if (event.target.classList.contains('btn-primary')) {
			var selectedLocation = event.target.dataset.title;
		}
		
//         var selectedLocation = locationDropdown.value;
        var selectedTeam = teamDropdown.value;
        var teamMembers = document.querySelectorAll('.people-container .person');
		var ceoBlock = document.querySelectorAll('.js-ceo-block');
		
		// hide CEO block if team filter selected
		if(selectedTeam) {
			ceoBlock[0].style.display = 'none';
		} else {
			ceoBlock[0].style.display = '';
		}

        teamMembers.forEach(function(member) {
            var memberLocation = member.getAttribute('data-location');
            var memberTeam = member.getAttribute('data-team');
			var memberIsCEO = member.getAttribute('data-isceo');

            if ((selectedLocation === "" || memberLocation === selectedLocation) &&
                (selectedTeam === "" || memberTeam === selectedTeam)) {
                member.style.display = '';
            } else {
                member.style.display = 'none';
            }
			
			// If a location is selected, hide the 'CEO' true people from the main list (displayed in own section)
			if(selectedLocation !== '' && memberIsCEO == 1) {
				member.style.display = 'none';
			}
        });
    }
	
}

window.addEventListener('load', () => {
	
	// Rest API Approach 	
	//initPeople();
	
	//JS only approach
	initPeopleFilter();
	
});