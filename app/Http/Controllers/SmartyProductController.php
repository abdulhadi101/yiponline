<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\SmartyRenderer;
use Illuminate\Http\Request;

class SmartyProductController extends Controller
{
    public function __construct(private readonly SmartyRenderer $smarty)
    {
    }

    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $query = Product::query()->where('is_active', true);

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query
            ->orderBy('created_at', 'desc')
            ->limit(24)
            ->get(['id', 'name', 'description', 'price', 'stock', 'image']);

        $html = $this->smarty->render('products/index.tpl', [
            'pageTitle' => 'Smarty Product Listing',
            'products' => $products,
            'search' => $search,
            'totalProducts' => $products->count(),
        ]);

        return response($html);
    }
}
