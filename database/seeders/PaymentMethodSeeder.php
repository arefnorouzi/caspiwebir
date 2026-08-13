<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = PaymentMethod::first();
        if (! $model) {
            $bank_cart_text = "<h3 class='text-sm mb-2'>*جهت پرداخت فاکتور به حساب زیر واریز نمایید*</h3>
<p class='mb-2'>شماره شبا بانک ملت: <br /><span id='shaba'>IR890120010000005652332671</span></p>
<p class='mb-5'>شماره کارت بانک ملت: <span id='card-number'>6104337848924641</span></p>
<p class='mb-2'>شماره شبا بانک ملی: <br /><span id='shaba-2'>IR51070000000111529994007</span></p>
<p class='mb-5'>شماره کارت بانک ملی: <span id='card-number-2'>6037997392078466</span></p>
<p class='mb-3'>صاحب حساب: <span>*عارف نوروزی*</span></p>
<p class='mb-3'>*لطفا بعد از پرداخت حتما فیش واریزی ارسال شود*</p>
<p class='mb-1 text-center'>
<a href='https://wa.me/989192138510' target='_blank' rel='noopener' class='rounded-md p-2 bg-green-500 text-white font-bold'>ارسال فیش به واتساپ</a>
</p>";

            $torob = "<h3 class='text-sm mb-2'>*پرداخت 4 قسطه با ترب پی*</h3>
<p class='mb-2'>کاربران محترم مارلیک افزار میتوانند فاکتورهای خود را با استفاده از سرویس پرداخت قسطی ترب پی پرداخت نمایند. </p>
<p class='mb-2'>*پرداخت اقساطی ترب شامل کارمزد میباشد*</p>
<p class='mb-2'>*لطفا ابتدا حساب کاربری خود را در ترب پی فعال نمایید*</p>
<p class='mb-4 text-center'>
<a href='https://torobpay.com' target='_blank' rel='noopener' class='rounded-md p-2 bg-blue-500 text-white font-bold'>دریافت اعتبار ترب پی</a>
</p>";

            $items = [
                [
                    'id' => 1, 'name' => 'درگاه بانک ملی', 'code' => 'sadad',
                    'description' => 'درگاه پرداخت بانک ملی',
                    'is_gateway' => true, 'is_default' => true, 'status' => true,
                    'image' => '/images/payment/bmi.png', 'interest_rate' => 0,
                    'terminal_id' => '24117130', 'merchant' => '000000140350261', 'username' => null, 'password' => 'gszotkqCmA9xpGO3uMEoH709WL0wR9UG',
                ],
                [
                    'id' => 2, 'name' => 'درگاه بانک ملت', 'code' => 'bpm',
                    'description' => 'درگاه پرداخت بانک ملت',
                    'is_gateway' => true, 'is_default' => false, 'status' => true,
                    'image' => '/images/payment/mellat.png', 'interest_rate' => 0,
                    'terminal_id' => '8807251', 'merchant' => null, 'username' => '8807251', 'password' => '89022123',
                ],
                [
                    'id' => 3, 'name' => 'پرداخت اقساطی ترب پی', 'code' => 'torob',
                    'description' => $torob, 'is_gateway' => true, 'is_default' => false,
                    'status' => true, 'image' => '/images/payment/torobpay.webp', 'interest_rate' => 12,
                    'terminal_id' => '58722681', 'merchant' => 'jKbATyPWinrPffjHbIw2sPOz67hS2hgHwEgJRMG0I0tRXCGmFEbUgAGwH75WXuhO', 'username' => 'caspiweb.ir', 'password' => 'MdTF8ZkmASWWxDfr',
                ],
                [
                    'id' => 4, 'name' => 'درگاه زرینپال', 'code' => 'zarinpal',
                    'description' => 'درگاه پرداخت زرینپال',
                    'is_gateway' => true, 'is_default' => false, 'status' => false,
                    'image' => '/images/payment/zarinpal.png', 'interest_rate' => 0,
                    'terminal_id' => null, 'merchant' => 'e498e86d-8681-4652-89b1-1ba217f0c8c5', 'username' => null, 'password' => null,
                ],
                [
                    'id' => 5, 'name' => 'درگاه زیبال', 'code' => 'zibal',
                    'description' => 'درگاه پرداخت زیبال',
                    'is_gateway' => true, 'is_default' => false, 'status' => false,
                    'image' => '/images/payment/zibal.webp', 'interest_rate' => 0,
                    'terminal_id' => null, 'merchant' => '654f53d1a9a4980019ce30b8', 'username' => null, 'password' => null,
                ],
                [
                    'id' => 6, 'name' => 'کارت به کارت / حواله پایا', 'code' => 'ctc',
                    'description' => $bank_cart_text, 'is_gateway' => false, 'is_default' => false,
                    'status' => true, 'image' => '/images/payment/ctc.png', 'interest_rate' => 0,
                    'terminal_id' => null, 'merchant' => null, 'username' => null, 'password' => null,
                ],
                [
                    'id' => 7, 'name' => 'درگاه سامان', 'code' => 'sep',
                    'description' => 'درگاه پرداخت سامان',
                    'is_gateway' => true, 'is_default' => false, 'status' => false,
                    'image' => '/images/payment/sep.png', 'interest_rate' => 0,
                    'terminal_id' => '123456', 'merchant' => null, 'username' => null, 'password' => null,
                ],
                [
                    'id' => 8, 'name' => 'درگاه صادرات', 'code' => 'sepehr',
                    'description' => 'درگاه پرداخت سپهر صادرات',
                    'is_gateway' => true, 'is_default' => false, 'status' => false,
                    'image' => '/images/payment/bsi.png', 'interest_rate' => 0,
                    'terminal_id' => '123456', 'merchant' => null, 'username' => null, 'password' => null,
                ],
                [
                    'id' => 9, 'name' => 'درگاه دیجی پی', 'code' => 'digipay',
                    'description' => 'درگاه پرداخت دیجی پی',
                    'is_gateway' => true, 'is_default' => false, 'status' => true,
                    'image' => '/images/payment/digipay.png', 'interest_rate' => 0,
                    'terminal_id' => 'caspiweb98-client-id', 'merchant' => 'V446#h!yqAPkJ70', 'username' => 'caspiweb98', 'password' => 'Caspiweb@1996',
                ],
            ];

            DB::table('payment_methods')->insert($items);
        }
    }
}
