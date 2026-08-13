<?php

namespace App\Http\Controllers\Excel;

use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import_products(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('file'));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return back()->withErrors(['file' => $e->getMessage()]);
        }

        return back()->with('success', 'محصولات با موفقیت بروزرسانی شدند');
    }
}
