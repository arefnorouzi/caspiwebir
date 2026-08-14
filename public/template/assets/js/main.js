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
                $('#search_resluts_url').attr('href', '/shop/search?s=' + q);
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
