<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index( Request $request ) {

        $paginateItems = 12;

        //* QUERY PARAMS
        $brands = json_decode(urldecode($request->input('brands')));
        $category = $request->input('category');
        $priceMin = $request->input('priceMin');
        $priceMax = $request->input('priceMax');
        $sortBy   = $request->input('sortBy');
        $sortByDesc = $request->input('sortByDesc');
        $search   = $request->input('search');
        $sale     = $request->input('sale');

        //* VALIDATIONS:
        if ( !empty($brands) ) {
            //* BRANDS:
            $products = Product::when($brands, function (Builder $query, $brands) use ($category, $priceMin, $priceMax, $sortBy, $sortByDesc, $search, $sale, $paginateItems) {
                return $query->whereHas('brand', function (Builder $query) use ($brands) {
                    $query->whereIn('id', $brands);
                })->when($category, function (Builder $query) use ($category) {
                    $query->where('category_id', $category);
                })->when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
                    $query->whereBetween('show_price', [$priceMin, $priceMax]);
                })->when($search, function (Builder $query) use ( $search ) {
                    $query->where('name', 'like', '%'. $search .'%');
                })->when($sale, function (Builder $query) use ( $sale ) {
                    $query->where('sale', '=', true);
                })->when($sortBy, function (Builder $query) {
                    $query->orderBy('show_price');
                })->when($sortByDesc, function (Builder $query) {
                    $query->orderBy('show_price', 'desc');
                })->paginate($paginateItems);
            });

        } else if (isset($category)) {
            //* CATEGORY:
            $products = Product::when($category, function (Builder $query) use ($category) {
                $query->where('category_id', $category);
            })->when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
                $query->whereBetween('show_price', [$priceMin, $priceMax]);
            })->when($search, function (Builder $query) use ( $search ) {
                $query->where('name', 'like', '%'. $search .'%');
            })->when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('show_price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('show_price', 'desc');
            })->paginate($paginateItems);

        } else if ( isset($priceMin) && isset($priceMax) ) {

            //* PRICE MIN & PRICE MAX:
            $products = Product::when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
                $query->whereBetween('show_price', [$priceMin, $priceMax]);
            })->when($search, function (Builder $query) use ( $search ) {
                $query->where('name', 'like', '%'. $search .'%');
            })->when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('show_price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('show_price', 'desc');
            })->paginate($paginateItems);

        } else if ( isset($search) ) {
            //* SEARCHER:
            $products = Product::when($search, function (Builder $query) use ( $search ) {
                $query->where('name', 'like', '%'. $search .'%');
            })->when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', $sale);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('show_price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('show_price', 'desc');
            })->paginate($paginateItems);

        } else if ( isset($sale) ) {
            //* SALE:
            $products = Product::when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('show_price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('show_price', 'desc');
            })->paginate($paginateItems);

        } else if ( isset($sortBy) || isset($sortByDesc) ) {
            //* SORT PRODUCTS:
            $products = Product::when($sortBy, function (Builder $query) {
                $query->orderBy('show_price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('show_price', 'desc');
            })->paginate($paginateItems);

        } else {
            $products = Product::orderBy('show_price')->paginate($paginateItems);
        }

        $products->withPath('');

        $categories = Category::all();
        $brands = Brand::all();

        return Inertia::render('Web/Products/Index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    public function view( Product $product ) {
        $product = Product::with(['category', 'brand'])->find($product->id);

        return Inertia::render('Web/Products/View', [
            'product' => $product
        ]);
    }
}
