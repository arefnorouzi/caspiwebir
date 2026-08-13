var swiper = new Swiper(".mySwiper", {
  slidesPerView: 7,
  spaceBetween: 10,
  centeredSlides: false,
    loop: true,
    autoplay: {
        delay: 2500,        // زمان تاخیر بین اسلایدها (میلی‌ثانیه)
        disableOnInteraction: false, // بعد از کلیک کاربر، اتوپلی متوقف نشود
    },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 2.1,
      spaceBetween: 4,
    },
    400: {
      slidesPerView: 3.4,
      spaceBetween: 6,
    },
    600: {
      slidesPerView: 5.3,
      spaceBetween: 8,
    },
    900: {
      slidesPerView: 5.6,
      spaceBetween: 16,
    },
    1060: {
      slidesPerView: 6.8,
      spaceBetween: 16,
    },
  },
});
