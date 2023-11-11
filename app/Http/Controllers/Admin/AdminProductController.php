<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Build;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
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

        if ( !empty($brands) ) {
        //* VALIDATIONS:
            //* BRANDS:
            $products = new ProductCollection(Product::when($brands, function (Builder $query, $brands) use ($category, $priceMin, $priceMax, $sortBy, $sortByDesc, $search, $sale, $paginateItems) {
                return $query->whereHas('brand', function (Builder $query) use ($brands) {
                    $query->whereIn('id', $brands);
                })->when($category, function (Builder $query) use ($category) {
                    $query->where('category_id', $category);
                })->when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
                    $query->whereBetween('price', [$priceMin, $priceMax]);
                })->when($search, function (Builder $query) use ( $search ) {
                    $query->where('name', 'like', '%'. $search .'%')->orWhere('id', 'like', '%'. $search .'%');
                })->when($sale, function (Builder $query) use ( $sale ) {
                    $query->where('sale', '=', true);
                })->when($sortBy, function (Builder $query) {
                    $query->orderBy('price');
                })->when($sortByDesc, function (Builder $query) {
                    $query->orderBy('price', 'desc');
                })->paginate($paginateItems);
            }));

        } else if (isset($category)) {
            //* CATEGORY:
            $products = new ProductCollection(Product::when($category, function (Builder $query) use ($category) {
                $query->where('category_id', $category);
            })->when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
                $query->whereBetween('price', [$priceMin, $priceMax]);
            })->when($search, function (Builder $query) use ( $search ) {
                $query->where('name', 'like', '%'. $search .'%')->orWhere('id', 'like', '%'. $search .'%');
            })->when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->paginate($paginateItems));

        } else if ( isset($priceMin) && isset($priceMax) ) {

            //* PRICE MIN & PRICE MAX:
            $products = new ProductCollection(Product::when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
                $query->whereBetween('price', [$priceMin, $priceMax]);
            })->when($search, function (Builder $query) use ( $search ) {
                $query->where('name', 'like', '%'. $search .'%')->orWhere('id', 'like', '%'. $search .'%');
            })->when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->paginate($paginateItems));

        } else if ( isset($search) ) {
            //* SEARCHER:
            $products = new ProductCollection(Product::when($search, function (Builder $query) use ( $search ) {
                $query->where('name', 'like', '%'. $search .'%')->orWhere('id', 'like', '%'. $search .'%');
            })->when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', $sale);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->paginate($paginateItems));

        } else if ( isset($sale) ) {
            //* SALE:
            $products = new ProductCollection(Product::when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->paginate($paginateItems));

        } else if ( isset($sortBy) || isset($sortByDesc) ) {
            //* SORT PRODUCTS:
            $products = new ProductCollection(Product::when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->paginate($paginateItems));

        } else {
            $products = new ProductCollection(Product::paginate($paginateItems));
        }

        $products->withPath('');
        $brands = Brand::all();
        $categories = Category::all();

        return Inertia::render('Admin/Product/Index', [
            "products" => $products,
            "brands" => $brands,
            "categories" => $categories
        ]);
    }

    public function create() {
        $brands = Brand::all();
        $categories = Category::all();
        return Inertia::render('Admin/Product/Create', [
            "brands" => $brands,
            "categories" => $categories
        ]);
    }

    public function store( Request $request ) {

        $validated = $request->validate([
            'name' => 'required|string|max:65',
            'price' => 'required|numeric|min:0.01|max:999999',
            'brand_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'warranty' => 'required|string|max:40',
            'quantity' => 'required|numeric|min:0|max:999999',
            'condition' => 'required|string',
            'visacuotas' => 'boolean',
            'shipping' => 'boolean',
            'featured' => 'boolean',
            'sale' => 'boolean',
            'percentage' => 'nullable|numeric|max:99',
            'sale_price' => 'nullable|numeric|max:999999',
            'show_price' => 'nullable|numeric|max:999999',
            'normal_price' => 'nullable|numeric|max:999999',
            'sale_normal_price' => 'nullable|numeric|max:999999',
        ]);

        $path = public_path('products/');
        !is_dir($path) &&
            mkdir($path, 0777, true);

        $imageName = time() . '.' . $request->images[0]['file']->extension();
        $request->images[0]['file']->move($path, $imageName);

        Product::create([
            'name' => $request->name,
            'images' => "products/{$imageName}",
            'price' => $request->price,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'warranty' => $request->warranty,
            'details' => $request->details,
            'quantity' => $request->quantity,
            'condition' => $request->condition,
            'visacuotas' => $request->visacuotas,
            'shipping' => $request->shipping,
            'featured' => $request->featured,
            'sale' => $request->sale,
            'percentage' => $request->percentage,
            'sale_price' => $request->sale_price,
            'normal_price' => $request->normal_price,
            'sale_normal_price' => $request->sale_normal_price,
            'show_price' => $request->show_price,
        ]);

        return to_route('admin.product.index')->with(['success' => 'Creado correctamente']);
    }

    public function edit( Product $product ) {

        $brands = Brand::all();
        $categories = Category::all();

        return Inertia::render('Admin/Product/Edit', [
            'product' => $product,
            "brands" => $brands,
            "categories" => $categories
        ]);
    }

    public function featured( Request $request) {

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

        if ( !empty($brands) ) {
        //* VALIDATIONS:
            //* BRANDS:
            $products = new ProductCollection(Product::when($brands, function (Builder $query, $brands) use ($category, $priceMin, $priceMax, $sortBy, $sortByDesc, $search, $sale, $paginateItems) {
                return $query->whereHas('brand', function (Builder $query) use ($brands) {
                    $query->whereIn('id', $brands);
                })->when($category, function (Builder $query) use ($category) {
                    $query->where('category_id', $category);
                })->when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
                    $query->whereBetween('price', [$priceMin, $priceMax]);
                })->when($search, function (Builder $query) use ( $search ) {
                    $query->where('name', 'like', '%'. $search .'%')->orWhere('id', 'like', '%'. $search .'%');
                })->when($sale, function (Builder $query) use ( $sale ) {
                    $query->where('sale', '=', true);
                })->when($sortBy, function (Builder $query) {
                    $query->orderBy('price');
                })->when($sortByDesc, function (Builder $query) {
                    $query->orderBy('price', 'desc');
                })->where('featured', true)->paginate($paginateItems);
            }));

        } else if (isset($category)) {
            //* CATEGORY:
            $products = new ProductCollection(Product::when($category, function (Builder $query) use ($category) {
                $query->where('category_id', $category);
            })->when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
                $query->whereBetween('price', [$priceMin, $priceMax]);
            })->when($search, function (Builder $query) use ( $search ) {
                $query->where('name', 'like', '%'. $search .'%')->orWhere('id', 'like', '%'. $search .'%');
            })->when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->where('featured', true)->paginate($paginateItems));

        } else if ( isset($priceMin) && isset($priceMax) ) {

            //* PRICE MIN & PRICE MAX:
            $products = new ProductCollection(Product::when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
                $query->whereBetween('price', [$priceMin, $priceMax]);
            })->when($search, function (Builder $query) use ( $search ) {
                $query->where('name', 'like', '%'. $search .'%')->orWhere('id', 'like', '%'. $search .'%');
            })->when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->where('featured', true)->paginate($paginateItems));

        } else if ( isset($search) ) {
            //* SEARCHER:
            $products = new ProductCollection(Product::when($search, function (Builder $query) use ( $search ) {
                $query->where('name', 'like', '%'. $search .'%')->orWhere('id', 'like', '%'. $search .'%');
            })->when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', $sale);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->where('featured', true)->paginate($paginateItems));

        } else if ( isset($sale) ) {
            //* SALE:
            $products = new ProductCollection(Product::when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->where('featured', true)->paginate($paginateItems));

        } else if ( isset($sortBy) || isset($sortByDesc) ) {
            //* SORT PRODUCTS:
            $products = new ProductCollection(Product::when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->where('featured', true)->paginate($paginateItems));
        } else {
            $products = new ProductCollection(Product::where('featured', true)->paginate($paginateItems));
        }

        $products->withpath('');
        $brands = Brand::all();
        $categories = Category::all();

        return Inertia::render('Admin/FeaturedProducts/Index', [
            "featuredProducts" => $products,
            "brands" => $brands,
            "categories" => $categories
        ]);
    }

    public function toggle(Product $product) {

        $featuredProducts = Product::where('featured', true)->get();

        $product->update(["featured" => !$product->featured]);
        return back()->with(['success' => 'Actualizado correctamente']);
    }

    public function editSale(Product $product) {
        return Inertia::render('Admin/Product/UpdateSale', [
            'product' => $product,
        ]);
    }

    public function updateSale( Request $request ) {
        $product = Product::find($request->id);
        $product->update($request->all());

        return to_route('admin.product.index')->with(['success' => 'Actualizado correctamente']);
    }

    public function update( Request $request ) {

        $validated = $request->validate([
            'name' => 'required|string|max:65',
            'price' => 'required|numeric|min:0.01|max:999999',
            'brand_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'warranty' => 'required|string|max:40',
            'quantity' => 'required|numeric|min:0|max:999999',
            'condition' => 'required|string',
            'visacuotas' => 'boolean',
            'shipping' => 'boolean',
            'featured' => 'boolean',
            'sale' => 'boolean',
            'percentage' => 'nullable|numeric|max:99',
            'sale_price' => 'nullable|numeric|max:999999',
            'normal_price' => 'nullable|numeric|max:999999',
            'sale_normal_price' => 'nullable|numeric|max:999999',
            'show_price' => 'nullable|numeric|max:999999',
        ]);

        $product = Product::find($request->id);

        $path = '';

        if ( empty($request->images) ) {
            $path = $product->images;
        } else {
            $path = public_path('products/');
            !is_dir($path) &&
                mkdir($path, 0777, true);

            $imageName = time() . '.' . $request->images[0]['file']->extension();
            $request->images[0]['file']->move($path, $imageName);
            $path = "products/{$imageName}";
        }

        $product->update([
            'name' => $request->name,
            'images' => $path,
            'price' => $request->price,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'warranty' => $request->warranty,
            'details' => $request->details,
            'quantity' => $request->quantity,
            'condition' => $request->condition,
            'visacuotas' => $request->visacuotas,
            'shipping' => $request->shipping,
            'featured' => $request->featured,
            'sale' => $request->sale,
            'percentage' => $request->percentage,
            'sale_price' => $request->sale_price,
            'normal_price' => $request->normal_price,
            'sale_normal_price' => $request->sale_normal_price,
            'show_price' => $request->show_price,
        ]);

        return to_route('admin.product.index')->with(['success' => 'Actualizado correctamente']);
    }

    public function destroy(Product $product) {

        $columns = ['cpu_id', 'cooler_id', 'ram_id', 'gpu_id', 'psu_id', 'mobo_id', 'case_id', 'rom_id'];

        foreach( $columns as $column) {
            if(Build::where($column, $product->id)->exists()){

                return back()->with(['error' => 'No se puede eliminar una producto cuando está enlazado a un PC Combo']);

            }
        }

        $product->delete();

        return back()->with(['success' => 'Eliminado Correctamente']);
    }
}


