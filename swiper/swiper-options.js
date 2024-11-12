
const testimonialsSwiper = new Swiper('.testimonial-swiper', {
  	// Optional parameters
	slidesPerView: "auto",
	spaceBetween: 30,
	centeredSlides: true,
	observer: true,
	observeParents: true,
	navigation: {
	  	nextEl: ".swiper-button-next",
		prevEl: ".swiper-button-prev",
	},
	// scrollbar: {
	// 	el: ".swiper-scrollbar",
	// },
});
