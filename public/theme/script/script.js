// OpenMenu
document.addEventListener('DOMContentLoaded', function() {
    const openMenuButton = document.getElementById('open_menu');
    const closeMenuButton = document.getElementById('close-menu');
    const mobileMenu = document.getElementById('mobile_menu');
    const backdrop = document.getElementById('backdrop');
    const body = document.body;

    function getScrollbarWidth() {
        return window.innerWidth - document.documentElement.clientWidth;
    }
    function openMenu() {
        mobileMenu.classList.add('open');
        backdrop.classList.remove('hidden');
        backdrop.classList.add('open');

        const scrollbarWidth = getScrollbarWidth();
        body.style.paddingRight = scrollbarWidth + 'px';
        body.style.overflow = 'hidden';
    }

    function closeMenu() {
        mobileMenu.classList.remove('open');
        backdrop.classList.remove('open');
        backdrop.classList.add('hidden');

        body.style.overflow = '';
        body.style.paddingRight = '';
    }

    if (openMenuButton && mobileMenu && backdrop) {
        openMenuButton.addEventListener('click', openMenu);
    }

    if (closeMenuButton && mobileMenu && backdrop) {
        closeMenuButton.addEventListener('click', closeMenu);
    }

    if (backdrop && mobileMenu) {
        backdrop.addEventListener('click', closeMenu);
    }
});


// FAQ
document.querySelectorAll('.faq-toggle').forEach(button => {
    button.addEventListener('click', () => {
        const content = button.nextElementSibling;
        const icon = button.querySelector("span:last-child");

        content.classList.toggle('open');
        icon.textContent = content.classList.contains('open') ? '−' : '+';
      });
});

// Tabs

  function showTab(tabId) {
    document.querySelectorAll('.tab').forEach(function(tab) {
      tab.classList.remove('active');
    });

    event.target.classList.add('active');

    document.querySelectorAll('.content').forEach(function(content) {
      content.classList.remove('active');
      content.style.display = 'none';
    });

    const selectedContent = document.getElementById(tabId);
    selectedContent.classList.add('active');
    selectedContent.style.display = 'block';
  }

  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.content').forEach(function(content, index) {
      if (index !== 0) content.style.display = 'none'; // فقط اولین تب نمایش داده شود
    });
  });


// MobileMenu_Click
document.querySelectorAll('ul > li > button').forEach(button => {
  button.addEventListener('click', () => {
    const submenu = document.getElementById(button.getAttribute('aria-controls'));
    const expanded = button.getAttribute('aria-expanded') === 'true';
    button.setAttribute('aria-expanded', String(!expanded));

    if (!expanded) {
      submenu.style.maxHeight = submenu.scrollHeight + "px";
      button.querySelector('svg').classList.add('rotate-180');
    } else {
      submenu.style.maxHeight = 0;
      button.querySelector('svg').classList.remove('rotate-180');
    }
  });
});




// Sliders
$('.review').owlCarousel({
    loop:true,
    margin:24,
    nav:false,
    dots:false,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    responsive:{
        0:{
            items:1
        },
        950:{
            items:2
        },
        1200:{
            items:3
        }
    }
})
$('.articles').owlCarousel({
    loop:true,
    margin:35,
    nav:false,
    dots:false,
    responsive:{
        0:{
            items:1
        },
        900:{
            items:2
        },
        1200:{
            items:3
        }
    }
})
$('.relPost').owlCarousel({
    loop:true,
    margin:20,
    nav:false,
    dots:false,
    responsive:{
        0:{
            items:1
        },
        900:{
            items:2
        },
        1000:{
            items:2
        }
    }
})
$('.blogCarousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    dots:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})

/* MagicMouse */
// "use strict";function magicMouse(e){if((e=e||{}).outerWidth=e.outerWidth||30,e.outerHeight=e.outerHeight||30,e.cursorOuter=e.cursorOuter||"circle-basic",e.hoverEffect=e.hoverEffect||"circle-move",e.hoverItemMove=e.hoverItemMove||!1,e.defaultCursor=e.defaultCursor||!1,"disable"!=e.cursorOuter){var t=document.createElement("div");t.setAttribute("id","magicMouseCursor"),document.body.appendChild(t);var r=document.getElementById("magicMouseCursor")}if(!e.defaultCursor){document.body.style.cursor="none";var s=document.createElement("div");s.setAttribute("id","magicPointer"),document.body.appendChild(s);var o=document.getElementById("magicPointer")}if(r){r.style.width=e.outerWidth+"px",r.style.height=e.outerHeight+"px";var i=e.outerWidth,a=e.outerHeight,n=e.outerWidth,c=e.outerHeight}var u=0,d=0,l=0,m=0,h=!1;document.addEventListener("mousemove",(function(e){l=e.clientX,m=e.clientY,setTimeout(()=>{h||(u=e.clientX-i/2,d=e.clientY-a/2)},50)})),document.querySelectorAll(".magic-hover").forEach((t,r)=>{t.addEventListener("mouseenter",r=>{switch(e.hoverEffect){case"circle-move":f(t),e.hoverItemMove&&b(r,t);break;case"pointer-blur":y(t,"pointer-blur");break;case"pointer-overlay":y(t,"pointer-overlay")}}),t.addEventListener("mouseleave",r=>{switch(t.style.transform="translate3d(0,0,0)",e.hoverEffect){case"circle-move":g();break;case"pointer-blur":p("pointer-blur");break;case"pointer-overlay":p("pointer-overlay")}})});var v=()=>{r&&(r.style.transform="matrix(1, 0, 0, 1, "+u+", "+d+")",r.style.width=i+"px",r.style.height=a+"px"),o&&(o.style.transform="matrix(1, 0, 0, 1, "+l+", "+m+") translate3d(-50%, -50%, 0)"),requestAnimationFrame(v)};requestAnimationFrame(v);const f=e=>{if(h=!0,r){r.style.transition="transform 0.2s, width 0.3s, height 0.3s, border-radius 0.2s",r.classList.add("is-hover");var t=event.currentTarget.getBoundingClientRect();e.classList.contains("magic-hover__square")?(r.classList.add("cursor-square"),u=t.left,d=t.top,i=t.width,a=t.height):(u=t.left,d=t.top,i=t.width,a=t.height)}o&&o.classList.add("is-hover")},g=()=>{h=!1,r&&(i=n,a=c,r.style.transition="transform 0.07s, width 0.3s, height 0.3s, border-radius 0.2s",r.classList.remove("cursor-square"),r.classList.remove("is-hover")),o&&o.classList.remove("is-hover")},y=(e,t)=>{o&&o.classList.add(t)},p=e=>{o&&o.classList.remove(e)},b=(e,t)=>{e.clientX,e.clientY,t.addEventListener("mousemove",e=>{t.style.transform="matrix(1,0,0,1,"+(e.offsetX-e.target.offsetWidth/2)/2+", "+(e.offsetY-e.target.offsetHeight/2)/2+")"})}}
//
//     options = {
// 	"cursorOuter": "circle-basic",
// 	"hoverEffect": "circle-move",
// 	"hoverItemMove": false,
// 	"defaultCursor": false,
// 	"outerWidth": 41,
// 	"outerHeight": 41
//       };
// magicMouse(options);




