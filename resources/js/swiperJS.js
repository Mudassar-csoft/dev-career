import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

document.addEventListener("DOMContentLoaded", () => {
    new Swiper(".mySwiper", {
        slidesPerView: 2,
        spaceBetween: 20,
        grid: {
            rows: 2,
            fill: 'row',
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
        }
    });
});
