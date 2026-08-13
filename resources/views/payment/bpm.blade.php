<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>در حال اتصال به درگاه به پرداخت ملت...</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
<div class="text-center space-y-4">

    <form id="paymentForm" action="https://bpm.shaparak.ir/pgwchannel/startpay.mellat" method="post">
        <div>
            @if(isset($mobile) && strlen($mobile) == 12)
                <input type="hidden" hidden="hidden" name="MobileNo" value="{{$mobile}}" class="border border-gray-200 rounded-md p-2 mb-2 w-full shadow shadow-md" placeholder="terminal id" />
            @endif
            <input type="hidden" hidden="hidden" name="RefId" value="{{$RefId}}" class="border border-gray-200 rounded-md p-2 mb-2 w-full shadow shadow-md" placeholder="Ref id" />
            <input type="submit" value="پرداخت" class="bg-teal-600 rounded-md px-3 py-2 shadow shadow-md text-gray-100" />
        </div>
    </form>

    <noscript>
        <p class="text-red-500 text-sm mt-4">مرورگر شما از جاوااسکریپت پشتیبانی نمی‌کند. لطفاً برای ادامه پرداخت، روی دکمه زیر کلیک کنید.</p>
        <button type="submit" form="sepehrForm" class="bg-indigo-600 text-white px-4 py-2 rounded-lg mt-2">انتقال به درگاه ملت</button>
    </noscript>
</div>

<script>
    window.onload = function() {
        document.getElementById('paymentForm').submit();
    };
</script>
</body>
</html>
