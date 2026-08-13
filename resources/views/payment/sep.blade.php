<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>در حال اتصال به درگاه بانک سامان...</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
<div class="text-center space-y-4">

    <form id="paymentForm" action="https://sep.shaparak.ir/OnlinePG/OnlinePG" method="post">
        <div>
            <input type="hidden"  name="Token" value="{{$token}}" class="border border-gray-200 rounded-md p-2 mb-2 w-full shadow shadow-md" placeholder="terminal id" />
            <input type="submit" hidden="hidden" value="پرداخت" class="bg-teal-600 rounded-md px-3 py-2 shadow shadow-md text-gray-100" />
        </div>
    </form>

    <noscript>
        <p class="text-red-500 text-sm mt-4">مرورگر شما از جاوااسکریپت پشتیبانی نمی‌کند. لطفاً برای ادامه پرداخت، روی دکمه زیر کلیک کنید.</p>
        <button type="submit" form="sepehrForm" class="bg-indigo-600 text-white px-4 py-2 rounded-lg mt-2">انتقال به درگاه پرداخت</button>
    </noscript>
</div>

<script>
    window.onload = function() {
        document.getElementById('paymentForm').submit();
    };
</script>
</body>
</html>
