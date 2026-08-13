var swiper = new Swiper(".slide-container1", {
  slidesPerView: 4,
  spaceBetween: 16,
  sliderPerGroup: 4,
  loop: true,
    autoplay: {
        delay: 2500,        // زمان تاخیر بین اسلایدها (میلی‌ثانیه)
        disableOnInteraction: false, // بعد از کلیک کاربر، اتوپلی متوقف نشود
    },
  centerSlide: false,
  fade: true,
  grabCursor: true,
  rtl: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
  navigation: {
    nextEl: ".swiper-custom-prev",
    prevEl: ".swiper-custom-next",
  },
  breakpoints: {
    0: {
      slidesPerView: 2.2,
      spaceBetween: 4,
    },
    400: {
      slidesPerView: 2.5,
      spaceBetween: 6,
    },
    600: {
      slidesPerView: 3.6,
      spaceBetween: 8,
    },
    900: {
      slidesPerView: 4.5,
      spaceBetween: 16,
    },
    1060: {
      slidesPerView: 6,
      spaceBetween: 16,
    },
  },
});


var swiperB = new Swiper(".slide-container-brand", {
  slidesPerView: 4,
  spaceBetween: 16,
  sliderPerGroup: 4,
  loop: false,
  centerSlide: "true",
  fade: "true",
  grabCursor: "true",
  rtl: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 2.5,
      spaceBetween: 4,
    },
    400: {
      slidesPerView: 3.8,
      spaceBetween: 6,
    },
    600: {
      slidesPerView: 5.8,
      spaceBetween: 8,
    },
    900: {
      slidesPerView: 6.8,
      spaceBetween: 16,
    },
    1060: {
      slidesPerView: 9.7,
      spaceBetween: 16,
    },
  },
});

var swiper = new Swiper(".timerProduct", {
  autoplay: true,
  autoplayTimeout: 5000,
    delay: 3500,
  slidesPerView: 1,
  spaceBetween: 0,
  loop: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});
