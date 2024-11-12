const initCEO = () => {
	
	const postsContainer = document.querySelector('.ceo-container');
	const postsTemplate = document.querySelector('.ceo-container template');
	const locationDropdown = document.querySelector('.locations-list');

	const createPost = (post) => {
		
		//Get All Post Info
		// const postLink = post.id;
		const postTitle = post.title;
		const postPosition = post.position;
		const postImage = post.image;
		const postBgImage = post.bgimage;
    const postContent = post.content;
    const postQuote = post.quote;

		//Create Clone of template and get all template fields
		const clone = postsTemplate.content.cloneNode(true);
    
		const templateTitle = clone.querySelector('.post-name');
		const templatePosition = clone.querySelector('.post-position');
		const templateImage = clone.querySelector('.post-image');
		const templateModal = clone.querySelector('.modal');
    const templateModalName = clone.querySelector('.modal-name');
    const templateModalPosition = clone.querySelector('.position');
    const templateModalContent = clone.querySelector('.content');
    const templateModalQuote = clone.querySelector('.quote');
		
		//Assign Posts fields to template fields
		templateTitle.textContent = postTitle;
		templatePosition.textContent = postPosition;
		templateImage.innerHTML = postImage;
		templateModal.style.backgroundImage = `url('${postBgImage}')`;
    templateModalName.innerHTML = postTitle;
    templateModalPosition.innerHTML = postPosition;
    templateModalContent.innerHTML = postContent;
    templateModalQuote.innerHTML = postQuote;

		return clone;

	}
	
	let selectedLocation;

	if ( locationDropdown ) {

		locationDropdown.addEventListener('click', async (event) => {
// 		locationDropdown.addEventListener('change', async (event) => {

			event.preventDefault();

			postsContainer.innerHTML = "";

			// Check if the clicked element has the class 'btn-primary'
    		if (event.target.classList.contains('btn-primary')) {
				selectedLocation = event.target.dataset.slug;
				if ( selectedLocation == 'uk' ) {
					selectedLocation = 525;
				}
			}
// 			const selectedIndex = event.target.selectedIndex;
// 			selectedLocation = event.target[selectedIndex].dataset.slug;

			let response;

			response = await fetch(`/wp-json/he/v1/people/ceo?location=${selectedLocation}`);
			
			if (response.ok) {

				const data = await response.json();

				postsContainer.append(postsTemplate);

				data.posts.forEach((post) => {
					const newPost = createPost(post);
					postsContainer.append(newPost);
				});

			}
		});

	}

}

window.addEventListener('load', initCEO);