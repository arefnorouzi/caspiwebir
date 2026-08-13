<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CommandController extends Controller
{

    public function db_backup()
    {
        try {
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $path = storage_path('app/backups/' . $filename);

            if (!File::exists(storage_path('app/backups'))) {
                File::makeDirectory(storage_path('app/backups'), 0755, true);
            }

            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s %s > %s',
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                env('DB_HOST'),
                env('DB_DATABASE'),
                $path
            );

            exec($command, $output, $result);
            if ($result !== 0) {
                return back()->with('error', 'خطا در بکاپ گیری');
            }
            return response()->download($path);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'خطا در بکاپ گیری');
        }

    }

    public function db_migrate(): \Illuminate\Http\RedirectResponse
    {
        try {
            Artisan::call('migrate', [
                '--force' => true,
            ]);
            return back()->with('message', 'فرمان با موفقیت اجرا شد.');
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'اجرای فرمان با خطا مواجه شد.');
        }

    }
    public function cache_clear(): \Illuminate\Http\RedirectResponse
    {
        try {
            Artisan::call('cache:clear');
            return back()->with('message', 'فرمان با موفقیت اجرا شد.');
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'اجرای فرمان با خطا مواجه شد.');
        }

    }

    public function route_clear(): \Illuminate\Http\RedirectResponse
    {
        try {
            Artisan::call('route:clear');
            return back()->with('message', 'فرمان با موفقیت اجرا شد.');
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'اجرای فرمان با خطا مواجه شد.');
        }
    }

    public function config_clear(): \Illuminate\Http\RedirectResponse
    {
        try {
            Artisan::call('config:clear');
            Artisan::call('config:cache');
            return back()->with('message', 'فرمان با موفقیت اجرا شد.');
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'اجرای فرمان با خطا مواجه شد.');
        }
    }

    public function dump_autoload(): \Illuminate\Http\RedirectResponse
    {
        try {
            exec('composer dump-autoload', $output, $return_var);
            if ($return_var === 0) {
                return back()->with('message', 'فرمان با موفقیت اجرا شد.');
            }
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return back()->with('error', 'اجرای فرمان با خطا مواجه شد.');
    }


}
