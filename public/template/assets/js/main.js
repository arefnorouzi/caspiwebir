/////////////////////////////////////////////////////////add counter

// jQuery(
//   '<button class="quantity-nav quantity-button quantity-down inline-flex items-center justify-center p-1 me-3 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 " type="button"><span class="sr-only">Quantity button</span><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/></svg></button>'
// ).insertAfter(".quantity input");
// jQuery(
//   '<button class="quantity-nav quantity-button quantity-up inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200" type="button"><span class="sr-only">Quantity button</span><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg></button>'
// ).insertBefore(".quantity input");
// jQuery(".quantity").each(function () {
//   var spinner = jQuery(this),
//     btnUp = spinner.find(".quantity-up"),
//     input = spinner.find('input[type="number"]'),
//     btnDown = spinner.find(".quantity-down"),
//     min = input.attr("min"),
//     max = input.attr("max");
//
//   btnUp.click(function () {
//     var oldValue = parseFloat(input.val());
//     if (oldValue >= max) {
//       var newVal = oldValue;
//     } else {
//       var newVal = oldValue + 1;
//     }
//     spinner.find("input").val(newVal);
//     spinner.find("input").trigger("change");
//   });
//
//   btnDown.click(function () {
//     var oldValue = parseFloat(input.val());
//     if (oldValue <= min) {
//       var newVal = oldValue;
//     } else {
//       var newVal = oldValue - 1;
//     }
//     spinner.find("input").val(newVal);
//     spinner.find("input").trigger("change");
//   });
// });
// /////////////////////////////////////////////////////
// // show edit address alert
// function showEditAlert() {
//   document.getElementById("boxAddProduct").style.display = "block";
// }
// function closeBoxEditAddress() {
//   document.getElementById("boxAddProduct").style.display = "none";
// }
// /////////////////////////////////////////////////////////
// $(document).ready(function () {
//   var inputs = $("#advantage-input, #disadvantage-input");
//   var inputChangeCallback = function () {
//     var self = $(this);
//     if (self.val().trim().length > 0) {
//       self.siblings(".js-icon-form-add").show();
//     } else {
//       self.siblings(".js-icon-form-add").hide();
//     }
//   };
//   inputs.each(function () {
//     inputChangeCallback.bind(this)();
//     $(this).on("change keyup", inputChangeCallback.bind(this));
//   });
//   $("#advantages")
//     .delegate(".js-icon-form-add", "click", function (e) {
//       var parent = $(".js-advantages-list");
//       if (parent.find(".js-advantage-item").length >= 5) {
//         return;
//       }
//       var advantageInput = $("#advantage-input");
//       if (advantageInput.val().trim().length > 0) {
//         parent.append(
//           '<div class="ui-dynamic-label ui-dynamic-label--positive js-advantage-item">\n' +
//             advantageInput.val() +
//             '<button type="button" class="ui-dynamic-label-remove js-icon-form-remove"></button>\n' +
//             '<input type="hidden" name="comment[advantages][]" value="' +
//             advantageInput.val() +
//             '">\n' +
//             "</div>"
//         );
//         advantageInput.val("").change();
//         advantageInput.focus();
//       }
//     })
//     .delegate(".js-icon-form-remove", "click", function (e) {
//       $(this).parent(".js-advantage-item").remove();
//     });
//   $("#disadvantages")
//     .delegate(".js-icon-form-add", "click", function (e) {
//       var parent = $(".js-disadvantages-list");
//       if (parent.find(".js-disadvantage-item").length >= 5) {
//         return;
//       }
//       var disadvantageInput = $("#disadvantage-input");
//       if (disadvantageInput.val().trim().length > 0) {
//         parent.append(
//           '<div class="ui-dynamic-label ui-dynamic-label--negative js-disadvantage-item">\n' +
//             disadvantageInput.val() +
//             '<button type="button" class="ui-dynamic-label-remove js-icon-form-remove"></button>\n' +
//             '<input type="hidden" name="comment[disadvantages][]" value="' +
//             disadvantageInput.val() +
//             '">\n' +
//             "</div>"
//         );
//         disadvantageInput.val("").change();
//         disadvantageInput.focus();
//       }
//     })
//     .delegate(".js-icon-form-remove", "click", function (e) {
//       $(this).parent(".js-disadvantage-item").remove();
//     });
// });
// //////////////////////////////////////////////Timer
// document.addEventListener("readystatechange", (event) => {
//   if (event.target.readyState === "complete") {
//     var clockdiv = document.getElementsByClassName("clockdiv");
//     var countDownDate = new Array();
//     for (var i = 0; i < clockdiv.length; i++) {
//       countDownDate[i] = new Array();
//       countDownDate[i]["el"] = clockdiv[i];
//       countDownDate[i]["time"] = new Date(
//         clockdiv[i].getAttribute("data-date")
//       ).getTime();
//       countDownDate[i]["hours"] = 0;
//       countDownDate[i]["seconds"] = 0;
//       countDownDate[i]["minutes"] = 0;
//     }
//
//     var countdownfunction = setInterval(function () {
//       for (var i = 0; i < countDownDate.length; i++) {
//         var now = new Date().getTime();
//         var distance = countDownDate[i]["time"] - now;
//         countDownDate[i]["hours"] = Math.floor(
//           (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
//         );
//         countDownDate[i]["minutes"] = Math.floor(
//           (distance % (1000 * 60 * 60)) / (1000 * 60)
//         );
//         countDownDate[i]["seconds"] = Math.floor(
//           (distance % (1000 * 60)) / 1000
//         );
//
//         if (distance < 0) {
//           countDownDate[i]["el"].querySelector(".hours").innerHTML = 0;
//           countDownDate[i]["el"].querySelector(".minutes").innerHTML = 0;
//           countDownDate[i]["el"].querySelector(".seconds").innerHTML = 0;
//         } else {
//           countDownDate[i]["el"].querySelector(".hours").innerHTML =
//             countDownDate[i]["hours"];
//           countDownDate[i]["el"].querySelector(".minutes").innerHTML =
//             countDownDate[i]["minutes"];
//           countDownDate[i]["el"].querySelector(".seconds").innerHTML =
//             countDownDate[i]["seconds"];
//         }
//       }
//     }, 1000);
//   }
// });
/////////////////////////////////// btn go to up
let mybutton = document.getElementById("btn-back-to-top");

mybutton.addEventListener("click", backToTop);

function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}



$(function(){

    // debounce helper
    function debounce(fn, delay){
        let t;
        return function(){
            const args = arguments;
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    const $input = $('#default-search');
    const $results = $('#searchResults');
    let items = []; // نتایج فعلی
    let activeIndex = -1;

    // نمایش نتایج
    function render(list){
        items = list;
        activeIndex = -1;
        $results.empty();
        if(!list || list.length === 0){
            $results.hide().attr('aria-hidden','true');
            return;
        }
        list.forEach((it, idx) => {
            // example: it = {id:1, title:'...', subtitle:'...', url:'/product/1'}
            const $li = $(`

        <li data-idx="${idx}" data-url="${it.url}" role="option">
        <div class="flex flex-wrap gap-2">
            <div>
                <img src="${it.image}" style="width: 50px; height: 50px;">
            </div>
            <div>
                 <div class="title">${it.title}</div>
                 ${it.subtitle ? `<div class="text-red-500 text-sm">${it.subtitle}</div>` : ''}
            </div>
        </div>

        </li>`);
            $results.append($li);
        });
        $results.show().attr('aria-hidden','false');
    }

    // بر روی کلیک روی نتیجه
    $results.on('click', 'li', function(){
        const url = $(this).data('url');
        if(url) window.location.href = url;
    });

    // ناوبری با کیبورد
    $input.on('keydown', function(e){
        if($results.is(':hidden')) return;
        if(e.key === 'ArrowDown'){
            e.preventDefault();
            if(activeIndex < items.length - 1) activeIndex++;
            updateActive();
        } else if(e.key === 'ArrowUp'){
            e.preventDefault();
            if(activeIndex > 0) activeIndex--;
            updateActive();
        } else if(e.key === 'Enter'){
            e.preventDefault();
            if(activeIndex >= 0 && items[activeIndex]){
                const url = items[activeIndex].url;
                if(url) window.location.href = url;
            } else {
                // اگر مایل بودی میتونی فرم submit کنی برای صفحه نتایج کامل
                // $('#searchForm').submit();
            }
        } else if(e.key === 'Escape'){
            $results.hide().attr('aria-hidden','true');
        }
    });

    function updateActive(){
        $results.find('li').removeClass('active');
        if(activeIndex >= 0){
            $results.find('li').eq(activeIndex).addClass('active');
        }
    }

    // click خارج برای بستن
    $(document).on('click', function(e){
        if(!$(e.target).closest('.search-wrapper').length){
            $results.hide().attr('aria-hidden','true');
        }
    });

    // AJAX call (debounced)
    const doSearch = debounce(function(){
        const q = $input.val().trim();
        if(q.length < 1){
            render([]);
            return;
        }
        $.ajax({
            url: '/shop/search', // مسیر لاراولی که پایین تعریف می‌کنیم
            method: 'POST',
            data: { q: q },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // مطمئن شو meta تو head هست
            },
            success: function(res){
                // انتظار: res = [{id, title, subtitle, url}, ...]
                render(res);
            },
            error: function(){
                render([]);
            }
        });
    }, 1000);

    $input.on('input', doSearch);

});
