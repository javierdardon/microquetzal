<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandCollection;
use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AdminBrandController extends Controller
{
    public function index( Request $request ) {

        $paginateItems = 12;

        //* QUERY PARAMS
        $search = $request->input('search');

        if ( isset($search) ) {
        //* VALIDATIONS:
            //* SEARCHER:
            $brands = new BrandCollection(Brand::when($search, function (Builder $query) use ( $search ) {
                $query->where('name', 'like', '%'. $search .'%');
            })->paginate($paginateItems));
        } else {
            $brands = new BrandCollection(Brand::paginate($paginateItems));
        }

        $brands->withPath('');

        return Inertia::render('Admin/Brand/Index', [
            "brands" => $brands
        ]);
    }

    public function create() {
        return Inertia::render('Admin/Brand/Create');
    }

    public function store( Request $request ) {

        $validated = $request->validate([
            'name' => 'required|string|max:25|unique:App\Models\Brand,name',
        ]);

        Brand::create([
            'name' => $request->name
        ]);

        return to_route('admin.brands.index')->with(['success' => 'Creado Correctamente']);
    }

    public function edit( Brand $brand ) {
        return Inertia::render('Admin/Brand/Edit', [
            'brand' => $brand
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:25|unique:App\Models\Brand,name',
        ]);

        $brand = Brand::find($request->id);
        $brand->update($request->all());

        return to_route('admin.brands.index')->with(['success' => 'Actualizado Correctamente']);
    }

    public function destroy( Brand $brand ) {
        if(Product::where('brand_id',$brand->id)->exists()){

            return back()->with(['error' => 'No se puede eliminar una marca cuando está en uso']);

        }

        $brand->delete();

        return back()->with(['success' => 'Eliminado Correctamente']);
    }
}
