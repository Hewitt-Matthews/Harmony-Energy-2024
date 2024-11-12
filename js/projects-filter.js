const initProjects = () => {
	
	const postsContainer = document.querySelector('.projects-container');
	const postsTemplate = document.querySelector('.projects-container template');
	const locationDropdown = document.querySelector('.locations-list');
  const typeDropdown = document.querySelector('.types-list');
  const statusDropdown = document.querySelector('.statuses-list');
	const noResultsContainer = document.querySelector('.no-results');

	const createPost = (post) => {
		
		//Get All Post Info
		const postTitle = post.title;
		const postType = post.type;
    const postPower = post.power;
    const postLocation = post.location;
    const postInfo = post.info;
    const postStatuses = post.statuses;

		//Create Clone of template and get all template fields
		const clone = postsTemplate.content.cloneNode(true);
		
		const templateTitle = clone.querySelector('.title h3');
		const templateType = clone.querySelector('.type');
		const templatePower = clone.querySelector('.post-power');
    const templateLocation = clone.querySelector('.location');
    const templateInfo = clone.querySelector('.info');
    const templateStatus = clone.querySelector('.status');
		
		//Assign Posts fields to template fields
		templateTitle.innerHTML = postTitle;
		templateType.innerHTML = postType;
		templatePower.textContent = postPower;
    	templateLocation.textContent = postLocation;
    	templateInfo.textContent = postInfo;
    	templateStatus.innerHTML = '';
    for (let i = 0; i < postStatuses.length; i++) {
      // Create a new <p> element
      const paragraph = document.createElement("p");
  
      // Add a class attribute to the <p> element
      paragraph.classList.add("status");
  
      // Set the text content of the <p> element to the status name
      paragraph.textContent = postStatuses[i].name;
  
      // Append the <p> element to the templateStatus element
      templateStatus.appendChild(paragraph);
    }

		return clone;

	}
	
	let selectedLocation;
  let selectedType;
  let selectedStatus;

	if ( locationDropdown ) {

		locationDropdown.addEventListener('change', async (event) => {

			event.preventDefault();

			postsContainer.innerHTML = "";

			const selectedIndex = event.target.selectedIndex;
			selectedLocation = event.target[selectedIndex].dataset.slug;

			let response;

      if (selectedStatus && selectedLocation && selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?status=${selectedStatus}&location=${selectedLocation}&type=${selectedType}`);
			} else if (selectedStatus && selectedLocation && !selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?status=${selectedStatus}&location=${selectedLocation}`);
      } else if (selectedStatus && !selectedLocation && selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?status=${selectedStatus}&type=${selectedType}`);
      } else if (!selectedStatus && selectedLocation && selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?location=${selectedLocation}&type=${selectedType}`);
      } else if (!selectedStatus && !selectedLocation && selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?type=${selectedType}`);
      } else if (selectedStatus && !selectedLocation && !selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?status=${selectedStatus}`);
			} else {
        response = await fetch(`/wp-json/he/v1/projects/posts?location=${selectedLocation}`);
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

			}
		});

	}

  if ( typeDropdown ) {

		typeDropdown.addEventListener('change', async (event) => {

			event.preventDefault();

			postsContainer.innerHTML = "";

			const selectedIndex = event.target.selectedIndex;
			selectedType = event.target[selectedIndex].dataset.slug;

			let response;

      if (selectedStatus && selectedLocation && selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?status=${selectedStatus}&location=${selectedLocation}&type=${selectedType}`);
			} else if (selectedStatus && selectedLocation && !selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?status=${selectedStatus}&location=${selectedLocation}`);
      } else if (selectedStatus && !selectedLocation && selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?status=${selectedStatus}&type=${selectedType}`);
      } else if (!selectedStatus && selectedLocation && selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?location=${selectedLocation}&type=${selectedType}`);
      } else if (!selectedStatus && selectedLocation && !selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?location=${selectedLocation}`);
      } else if (selectedStatus && !selectedLocation && !selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?status=${selectedStatus}`);
			} else {
        response = await fetch(`/wp-json/he/v1/projects/posts?type=${selectedType}`);
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

			}
		});

	}

  if ( statusDropdown ) {

    statusDropdown.addEventListener('change', async (event) => {

			event.preventDefault();

			postsContainer.innerHTML = "";

			const selectedIndex = event.target.selectedIndex;
			selectedStatus = event.target[selectedIndex].dataset.slug;

			let response;

      if (selectedStatus && selectedLocation && selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?status=${selectedStatus}&location=${selectedLocation}&type=${selectedType}`);
			} else if (selectedStatus && selectedLocation && !selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?status=${selectedStatus}&location=${selectedLocation}`);
      } else if (selectedStatus && !selectedLocation && selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?status=${selectedStatus}&type=${selectedType}`);
      } else if (!selectedStatus && selectedLocation && selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?location=${selectedLocation}&type=${selectedType}`);
      } else if (!selectedStatus && selectedLocation && !selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?location=${selectedLocation}`);
      } else if (!selectedStatus && !selectedLocation && selectedType) {
				response = await fetch(`/wp-json/he/v1/projects/posts?type=${selectedType}`);
			} else {
        response = await fetch(`/wp-json/he/v1/projects/posts?status=${selectedStatus}`);
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

			}
		});

  }

}

window.addEventListener('load', initProjects);