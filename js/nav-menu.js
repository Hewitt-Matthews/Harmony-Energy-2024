const navMenuInit = () => {
	
	//Menu toggle functionality for both mobile and desktop
	
	const navToggles = document.querySelectorAll('.header-nav .toggle');
	const toggleLines = document.querySelectorAll('.header-nav .toggle .line');
	const fixedHeader = document.querySelector('header');
	const fixedHeaderBG = fixedHeader.style.backgroundColor;
	const contentArea = document.querySelector('#et-main-area');
	
	const toggleMenu = (e) => {
		
		let toggle; 
		let menuContainer;
		
		//Determine which element was clicked and which menu to toggle
		if (e.target.classList.contains('line')) {
			toggle = e.target.parentElement;
			menuContainer = toggle.closest('.header-nav').querySelector('.menu-primary-menu-container');
		} else if (e.target.classList.contains('toggle')) {
			toggle = e.target;
			menuContainer = toggle.closest('.header-nav').querySelector('.menu-primary-menu-container');
		} else {
			toggle = e.target;
		}
		
		fixedHeader.classList.toggle('active');
		
		//Toggle background color
		if (fixedHeader.classList.contains('active')) {
			fixedHeader.setAttribute('style', 'background-color: #fff!important;');
		} else {
			fixedHeader.setAttribute('style', `background-color: ${fixedHeaderBG}!important;`);
		}
		
		menuContainer.classList.toggle('active');
		contentArea.classList.toggle('pop-up');
		
		//Toggle hamburger menu lines
		toggleLines.forEach((line) => {
			line.classList.toggle('active');
		})
		
	}
	
	navToggles.forEach((toggle) => {
		toggle.addEventListener('click', toggleMenu);
	})
	
}

window.addEventListener('load', navMenuInit);