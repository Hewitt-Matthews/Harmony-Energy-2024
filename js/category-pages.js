const setSectionPosition = () => {

    const firstSection = document.querySelector('.et_pb_section_1_tb_body');

    const firstImage = firstSection.querySelector('.posts-container .post:is(:nth-child(-n+2)) img');
    const imagePosition = firstImage.getBoundingClientRect().bottom - firstSection.getBoundingClientRect().top;
    firstSection.setAttribute('style', `margin-top: -${imagePosition}px`)

}

window.addEventListener('load', setSectionPosition);