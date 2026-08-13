<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جزئیات فاکتور {{$invoice->id}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/themes/mk/css/font.css">

    <style>
        body{
            font-family: 'yekanBakhRegular', sans-serif !important;
            font-size: 12px;
            background: #f5f6fa;
            margin: 0;
            padding: 0;
            text-align: right;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            border-radius: 8px;
            padding: 32px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }
        .logo {
            font-size: 1.6em;
            font-weight: bold;
            color: #2d7cf2;
        }
        .invoice-status {
            padding: 6px 18px;
            border-radius: 16px;
            font-size: 1em;
            color: #fff;
            background: #27ae60;
            font-weight: 500;
        }
        .invoice-status.unpaid {
            background: #e74c3c;
        }
        .details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .client-info, .invoice-info {
            width: 48%;
        }
        .client-info h3, .invoice-info h3 {
            margin: 0 0 8px 0;
            font-size: 1.1em;
            color: #555;
        }
        .client-info p, .invoice-info p {
            margin: 2px 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th, td {
            padding: 12px 8px;
            border-bottom: 1px solid #eee;
            text-align: right;
        }
        th {
            background: #f0f4fb;
            color: #2d7cf2;
        }
        .totals {
            float: right;
            width: 300px;
            margin-bottom: 32px;
        }
        .totals table {
            margin-bottom: 0;
        }
        .totals td {
            border: none;
            padding: 8px 0;
        }
        .totals .label {
            color: #555;
        }
        .totals .value {
            text-align: right;
            color: #222;
        }
        .pay-btn {
            display: block;
            width: 100%;
            padding: 14px;
            background: #2d7cf2;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            margin-top: 16px;
            transition: background 0.2s;
        }
        .pay-btn:hover {
            background: #1b5dbf;
        }
        .text-primary{
            color: #1b5dbf;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo"><a href="/">{{$shop_setting->name}}</a></div>

        @if($invoice->payment_status == 'paid')
            <div class="invoice-status paid">پرداخت شده</div>

        @else
            <div class="invoice-status unpaid">پرداخت نشده</div>
        @endif

    </div>
    <div class="details">
        <div class="client-info">
            <h3>مشخصات مشتری</h3>
            <p><strong>نام:</strong> {{$invoice->customer_name}}</p>
            <p><strong>موبایل:</strong> {{$invoice->customer_mobile}}</p>
            <p><strong>آدرس:</strong> {{$invoice->customer_address}}</p>
            <p><strong>کد پستی:</strong> {{$invoice->customer_zip_code}}</p>
        </div>
        <div class="invoice-info">
            <h3>جزئیات فاکتور</h3>
            <p><strong>شماره فاکتور:</strong> {{$invoice->id}}</p>
            <p><strong>صدور:</strong> {{verta($invoice->created_at)->format('Y/m/d')}}</p>
            <p><strong>پرداخت:</strong> {{$invoice->purchased_at ? verta($invoice->created_at)->format('Y/m/d') : ''}}</p>
            <p><strong>انقضا:</strong> {{verta($invoice->expired_at)->format('Y/m/d')}}</p>
            <p><strong>کد مرسوله:</strong> {{$invoice->post_tracking_code}}</p>
        </div>
    </div>
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>محصول</th>
            <th>تعداد</th>
            <th>قیمت واحد</th>
            <th>جمع</th>
        </tr>
        </thead>
        <tbody>
        @php
            $row_number = 1;
        @endphp
        @foreach($invoice->items as $item)
            <tr>
                <td>{{$row_number++}}</td>
                <td>
                    {{$item->name}}
                </td>

                <td>{{$item->qty}}</td>
                <td>{{number_format($item->unit_price)}}</td>
                <td>{{number_format($item->unit_price * $item->qty)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="totals w-full">
        <table>
            <tr>
                <td class="label">جمع سفارش:</td>
                <td class="value">{{number_format($invoice->sub_total)}} ریال</td>
            </tr>
            <tr>
                <td class="label">مالیات: </td>
                <td class="value">{{number_format($invoice->tax)}} ریال</td>
            </tr>
            <tr>
                <td class="label">ارسال ({{$invoice?->shipping_method?->name}}):</td>
                <td class="value">{{number_format($invoice->shipping_cost)}} ریال</td>
            </tr>
            <tr>
                <td class="label">تخفیف:</td>
                <td class="value">{{number_format($invoice->discount)}} ریال</td>
            </tr>
            <tr>
                <td class="label">کارمزد:</td>
                <td class="value">{{number_format($invoice->interest_amount)}} ریال</td>
            </tr>
            <tr>
                <td class="label"><strong>قابل پرداخت:</strong></td>
                <td class="value"><strong>{{number_format($invoice->amount)}} ریال</strong></td>
            </tr>
        </table>
    </div>
    @if($invoice->payment_status)

        <a href="/" class="bg-gray-200 p-2 rounded-md">بازگشت به فروشگاه</a>

    @endif

</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const select = document.getElementById('gateway');

        let payout_url = "/payment/{{$payment_methods->where('is_default', true)->first()->code}}/pay/{{$invoice->uuid}}";

        select.addEventListener('change', e => {
            payout_url = "/payment/" + e.target.value + "/pay/{{$invoice->uuid}}";
        });

        const payBtn = document.getElementById("pay_btn");
        payBtn.addEventListener("click", pay);
        function pay()
        {
            window.location.replace(payout_url)
        }
    });

</script>
</body>
</html>
