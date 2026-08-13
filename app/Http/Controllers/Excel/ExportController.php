<?php

namespace App\Http\Controllers\Excel;

use App\Exports\ProductsExport;
use App\Exports\ProductsRolePriceExport;
use App\Exports\UsersExport;
use App\Exports\InvoicesExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export_products(Request $request)
    {
        $filters = [];
        if (isset($request->category))
        {
            $category_ids = [];
            $category = Category::where('id', intval($request->category))
                ->with(['children'])->first();
            if ($category)
            {
                $category_ids[] = $category->id;
                foreach ($category->children as $child) {
                    $category_ids[] = $child->id;
                    $child->load('children:id,parent_id');
                    foreach ($child->children as $child2) {
                        $category_ids[] = $child2->id;
                    }
                }
                $filters['categories'] = $category_ids;

            }
        }
        if (isset($request->status))
        {
            $filters['status'] = intval($request->status);
        }
        if (isset($request->pinned))
        {
            $filters['pinned'] = intval($request->pinned);
        }
        if (isset($request->brand_id))
        {
            $filters['brand_id'] = intval($request->brand_id);
        }
        return Excel::download(new ProductsExport($filters), 'products-' . time() . '.xlsx');
    }

    public function export_users()
    {
        return Excel::download(new UsersExport, 'users' . time() . '.xlsx');
    }

    public function export_invoices()
    {
        return Excel::download(new InvoicesExport, 'invoices' . time() . '.xlsx');
    }
}
