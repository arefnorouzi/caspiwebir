<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\DepositRequest;
use App\Http\Requests\Wallet\WithdrawRequest;
use App\Models\Invoice;
use App\Models\InvoiceType;
use App\Models\SmsNotification;
use App\Models\Wallet;
use App\Models\WalletSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UserWalletController extends Controller
{
    public function index()
    {
        try {
            $wallet = Wallet::user_wallet(uid: auth()->id());
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return redirect()->route('dashboard.index');
        }
        $invoices = Invoice::where('user_id', auth()->id())->orderBy('id', 'desc')
            ->with(['status', 'invoice_type'])
            ->get();
        $wallet_setting = WalletSetting::first();
        return Inertia::render('dashboard/Wallet', [
            'wallet' => $wallet, 'invoices' => $invoices, 'wallet_setting' => $wallet_setting
        ]);
    }


    public function deposit(DepositRequest $request)
    {
        $request = $request->validated();
        if (!auth()->user()->authenticated)
        {
            return response()->json(['message' => 'لطفا ابتدا حساب کاربری خود را تکمیل نمایید.'], 400);
        }
        try {
            $invoice = Invoice::create([
                'user_id' => auth()->id(),
                'amount' => $request['amount'],
                'transaction_type' => true,
                'uuid' => Str::uuid(),
                'sub_total' => $request['amount'],
                'customer_name' => auth()->user()->name,
                'customer_mobile' => auth()->user()->mobile,
                'expired_at' => now()->addDays(7),
            ]);
            $invoice->items()->create([
                'name' => 'شارژ کیف پول',
                'item_price' => $request['amount'],
                'unit_price' => $request['amount'],
            ]);
            SmsNotification::create([
                'title' => 'فاکتور جدید',
                'to' => env('ADMIN_MOBILE'),
                'pattern_id' => 388161,
                'tokens' => json_encode([
                    '0' => "$invoice->id", '1' => "$invoice->amount",
                    '2' => "$invoice->user_id"
                ])
            ]);
            return response()->json(['message' => 'فاکتور با موفقیت ایجاد شد', 'invoice_id' => $invoice->id]);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['message' => 'خطایی در ایجاد فاکتور رخ داد. لطفا دوباره تلاش نمایید.'], 400);
        }
    }

    public function withdraw(WithdrawRequest $request)
    {
        $request = $request->validated();
        try {
            $wallet = Wallet::user_wallet(auth()->id());
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['message' => 'موجودی کیف پل شما به حد نساب نرسیده است.'], 400);
        }
        if ($wallet->balance < $request['amount']) {
            return response()->json(['message' => 'مبلغ درخواستی بیشتر از موجودی کیف پول شماست.'], 400);
        }
        $user = auth()->user();
        DB::beginTransaction();
        try {
            $invoice = Invoice::create([
                'user_id' => $user->id,
                'amount' => $request['amount'],
                'transaction_type' => false,
                'uuid' => Str::uuid(),
                'sub_total' => $request['amount'],
                'invoice_type_id' => InvoiceType::get_type(code: 'withdraw'),
                'customer_name' => $user->name,
                'customer_mobile' => $user->mobile,
                'customer_shaba' => 'IR' . $request['shaba']
            ]);
            $invoice->items()->create([
                'name' => 'برداشت موجودی',
                'item_price' => $request['amount'],
                'unit_price' => $request['amount'],
            ]);
            $wallet->balance = max(0, $wallet->balance - $request['amount']);
            $wallet->withdraw = max(0, $wallet->withdraw + $request['amount']);
            $wallet->update();
            DB::commit();
            SmsNotification::create([
                'title' => 'فاکتور جدید',
                'to' => env('ADMIN_MOBILE'),
                'pattern_id' => 388161,
                'tokens' => json_encode([
                    '0' => "$invoice->id", '1' => "$invoice->amount",
                    '2' => "$invoice->user_id"
                ])
            ]);
            return response()->json([
                'message' => 'درخواست برداشت با موفقیت ثبت شد.',
                'invoice_id' => $invoice->id
            ]);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['message' => 'خطایی در ایجاد فاکتور رخ داد. لطفا دوباره تلاش نمایید.'], 400);

        }
    }
}
