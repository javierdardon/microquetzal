<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index( Request $request) {

        $paginateItems = 12;

         //* QUERY PARAMS
         $search = $request->input('search');

         if ( isset($search) ) {
        //* VALIDATIONS:
             //* SEARCHER:
             $categories = new CategoryCollection(Category::when($search, function (Builder $query) use ( $search ) {
                 $query->where('name', 'like', '%'. $search .'%');
             })->paginate($paginateItems));
         } else {
            $categories = new CategoryCollection(Category::paginate($paginateItems));
         }

        $categories->withPath('');

        return Inertia::render('Admin/Category/Index', [
            "categories" => $categories
        ]);
    }

    public function create() {
        return Inertia::render('Admin/Category/Create');
    }

    public function store( Request $request ) {
        $validated = $request->validate([
            'name' => 'required|string|max:30|unique:App\Models\Category,name',
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return to_route('admin.categories.index')->with(['success' => 'Creado Correctamente']);
    }

    public function edit( Category $category ) {
        return Inertia::render('Admin/Category/Edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30|unique:App\Models\Category,name',
        ]);

        $category = Category::find($request->id);
        $category->update($request->all());

        return to_route('admin.categories.index')->with(['success' => 'Actualizado Correctamente']);
    }

    public function destroy( Category $category ) {
        if(Product::where('category_id',$category->id)->exists()){

            return back()->with(['error' => 'No se puede eliminar una categoría cuando está enlazada a un producto.']);

        }

        $category->delete();

        return back()->with(['success' => 'Eliminado Correctamente']);
    }
}
