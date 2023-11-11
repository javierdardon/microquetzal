<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BuildCollection;
use Inertia\Inertia;
use App\Models\Build;
use App\Models\Gama;
use App\Models\BuildComponentCategories;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminBuildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        $paginateItems = 12;

        //* QUERY PARAMS
        $gama = json_decode(urldecode($request->input('gama')));
        $priceMin = $request->input('priceMin');
        $priceMax = $request->input('priceMax');
        $sortBy   = $request->input('sortBy');
        $sortByDesc = $request->input('sortByDesc');
        $search   = $request->input('search');
        $sale     = $request->input('sale');

        if (isset($gama)) {
        //* VALIDATIONS:
            //* GAMA:
            $builds = new BuildCollection(Build::when($gama, function (Builder $query) use ($gama) {
                $query->where('gama_id', $gama);
            })->when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
                $query->whereBetween('price', [$priceMin, $priceMax]);
            })->when($search, function (Builder $query) use ( $search ) {
                $query->where('name', 'like', '%'. $search .'%')->orWhere('id', 'like', '%'. $search .'%');;
            })->when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->paginate($paginateItems));

        } else if ( isset($priceMin) && isset($priceMax) ) {

            //* PRICE MIN & PRICE MAX:
            $builds = new BuildCollection(Build::when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
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
            $builds = new BuildCollection(Build::when($search, function (Builder $query) use ( $search ) {
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
            $builds = new BuildCollection(Build::when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->paginate($paginateItems));

        } else if ( isset($sortBy) || isset($sortByDesc) ) {
            //* SORT PRODUCTS:
            $builds = new BuildCollection(Build::when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->paginate($paginateItems));

        } else {
            $builds = new BuildCollection(Build::paginate($paginateItems));
        }

        $gamas = Gama::orderBy('percentage')->get();
        $builds->withPath('');

        return Inertia::render('Admin/Builds/Index', [
            "builds" => $builds,
            'gamas' => $gamas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {

        if(!Gama::find(1)) {
            return to_route('admin.configurations.gamas.index')->with(['info' => 'Asegúrese de configurar bien sus gamas antes de crear un PC Combo']);
        }

        if(!BuildComponentCategories::find(1)) {
            BuildComponentCategories::create([
                'cpu' => null,
                'cooler' => null,
                'ram' => null,
                'gpu' => null,
                'psu' => null,
                'mobo' => null,
                'case' => null,
                'rom' => null,
            ]);
        }

        $gamas = Gama::orderBy('percentage')->get();
        $buildComponentCategories = BuildComponentCategories::find(1);
        $cpuOptions = Product::where('category_id', $buildComponentCategories->cpu)->get();
        $coolerOptions = Product::where('category_id', $buildComponentCategories->cooler)->get();
        $ramOptions = Product::where('category_id', $buildComponentCategories->ram)->get();
        $gpuOptions = Product::where('category_id', $buildComponentCategories->gpu)->get();
        $psuOptions = Product::where('category_id', $buildComponentCategories->psu)->get();
        $caseOptions = Product::where('category_id', $buildComponentCategories->case)->get();
        $moboOptions = Product::where('category_id', $buildComponentCategories->mobo)->get();
        $romOptions = Product::where('category_id', $buildComponentCategories->rom)->get();

        if(!BuildComponentCategories::find(1)->cpu) {
            return Inertia::render('Admin/Builds/Create',
        [
            'buildComponentCategories' => $buildComponentCategories,
            'cpuOptions' => $cpuOptions,
            'coolerOptions' => $coolerOptions,
            'ramOptions' => $ramOptions,
            'gpuOptions' => $gpuOptions,
            'psuOptions' => $psuOptions,
            'caseOptions' => $caseOptions,
            'moboOptions' => $moboOptions,
            'romOptions' => $romOptions,
            'gamas' => $gamas,
        ])->with(['info' => 'Porfavor configure las categorías que se aplicarán a sus PC Combos en el menú Configuración']);;
        }


        $featuredBuildsCount = count(Build::where('featured', true)->get());

        return Inertia::render('Admin/Builds/Create',
        [
            'buildComponentCategories' => $buildComponentCategories,
            'cpuOptions' => $cpuOptions,
            'coolerOptions' => $coolerOptions,
            'ramOptions' => $ramOptions,
            'gpuOptions' => $gpuOptions,
            'psuOptions' => $psuOptions,
            'caseOptions' => $caseOptions,
            'moboOptions' => $moboOptions,
            'romOptions' => $romOptions,
            'featuredBuildsCount' =>  $featuredBuildsCount,
            'gamas' => $gamas,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:35',
            'price' => 'required|numeric|min:0.01|max:999999',
            'cpu_id'=> 'nullable|numeric',
            'cpu_name'=> 'nullable|string|max:65',
            'cpu_link'=> 'nullable|string|max:65534',
            'cooler_id'=>  'nullable|numeric',
            'cooler_name'=>  'nullable|string|max:65',
            'cooler_link'=>  'nullable|string|max:65534',
            'cooler_stock' => 'boolean',
            'ram_id'=> 'nullable|numeric',
            'ram_name'=> 'nullable|string|max:65',
            'ram_link'=> 'nullable|string|max:65534',
            'gpu_id'=> 'nullable|numeric',
            'gpu_name'=> 'nullable|string|max:65',
            'gpu_link'=> 'nullable|string|max:65534',
            'psu_id'=> 'nullable|numeric',
            'psu_name'=> 'nullable|string|max:65',
            'psu_link'=> 'nullable|string|max:65534',
            'case_id'=> 'nullable|numeric',
            'case_name'=> 'nullable|string|max:65',
            'case_link'=> 'nullable|string|max:65534',
            'mobo_id'=> 'nullable|numeric',
            'mobo_name'=> 'nullable|string|max:65',
            'mobo_link'=> 'nullable|string|max:65534',
            'rom_id'=> 'nullable|numeric',
            'rom_name'=> 'nullable|string|max:65',
            'rom_link'=> 'nullable|string|max:65534',
            'gama_id'=> 'required|numeric',
            'warranty' => 'required|string|max:40',
            'quantity' => 'required|numeric|min:0|max:999999',
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

        $path = public_path('builds/');
        !is_dir($path) &&
            mkdir($path, 0777, true);

        $imageName = time() . '.' . $request->images[0]['file']->extension();
        $request->images[0]['file']->move($path, $imageName);


        $build = Build::create([
            'name'=>  $request->name,
            'images' => "builds/{$imageName}",
            'cpu_id'=> $request->cpu_id,
            'cpu_name'=> $request->cpu_name,
            'cpu_link'=> $request->cpu_link,
            'cooler_id'=>  $request->cooler_id,
            'cooler_name'=>  $request->cooler_name,
            'cooler_link'=>  $request->cooler_link,
            'cooler_stock'=> $request->cooler_stock,
            'ram_id'=>  $request->ram_id,
            'ram_name'=>  $request->ram_name,
            'ram_link'=>  $request->ram_link,
            'ram_units'=>  $request->ram_units,
            'gpu_id'=>  $request->gpu_id,
            'gpu_name'=>  $request->gpu_name,
            'gpu_link'=>  $request->gpu_link,
            'psu_id'=>  $request->psu_id,
            'psu_name'=>  $request->psu_name,
            'psu_link'=>  $request->psu_link,
            'case_id'=>  $request->case_id,
            'case_name'=>  $request->case_name,
            'case_link'=>  $request->case_link,
            'mobo_id'=>  $request->mobo_id,
            'mobo_name'=>  $request->mobo_name,
            'mobo_link'=>  $request->mobo_link,
            'rom_id'=>  $request->rom_id,
            'rom_name'=>  $request->rom_name,
            'rom_link'=>  $request->rom_link,
            'rom_multiple_id' => $request->rom_multiple_id,
            'rom_multiple' => $request->rom_multiple,
            'price'=> $request->price,
            'description'=> $request->description,
            'gama_id'=> $request->gama_id,
            'warranty'=> $request->warranty,
            'quantity'=> $request->quantity,
            'details'=> $request->details,
            'visacuotas'=> $request->visacuotas,
            'shipping'=> $request->shipping,
            'featured'=> $request->featured,
            'sale'=> $request->sale,
            'percentage'=> $request->percentage,
            'sale_price'=> $request->sale_price,
            'normal_price'=> $request->normal_price,
            'sale_normal_price'=> $request->sale_normal_price,
            'show_price'=> $request->show_price,
        ]);

        $romId = collect([]);
        if($request->rom_multiple_id ){
            foreach($request->rom_multiple_id as $key){
                $romId->push($key['id']);
            }
            
            $romsId = collect($romId)
                ->map(function($romId){
                    return ['product_id' => $romId];
            });
    
            $build->multipleRom()->attach($romsId);
        }
        
        return to_route('admin.builds.index')->with(['success' => 'Creado correctamente']);
    }

    public function edit(Build $build) {
        $gamas = Gama::orderBy('percentage')->get();
        $buildComponentCategories = BuildComponentCategories::find(1);
        $cpuOptions = Product::where('category_id', $buildComponentCategories->cpu)->where('quantity', '>=', 1)->get();
        $coolerOptions = Product::where('category_id', $buildComponentCategories->cooler)->where('quantity', '>=', 1)->get();
        $ramOptions = Product::where('category_id', $buildComponentCategories->ram)->where('quantity', '>=', 1)->get();
        $gpuOptions = Product::where('category_id', $buildComponentCategories->gpu)->where('quantity', '>=', 1)->get();
        $psuOptions = Product::where('category_id', $buildComponentCategories->psu)->where('quantity', '>=', 1)->get();
        $caseOptions = Product::where('category_id', $buildComponentCategories->case)->where('quantity', '>=', 1)->get();
        $moboOptions = Product::where('category_id', $buildComponentCategories->mobo)->where('quantity', '>=', 1)->get();
        $romOptions = Product::where('category_id', $buildComponentCategories->rom)->where('quantity', '>=', 1)->get();

        $featuredBuildsCount = count(Build::where('featured', true)->get());

        return Inertia::render('Admin/Builds/Edit', [
            'build' => $build,
            'buildComponentCategories' => $buildComponentCategories,
            'cpuOptions' => $cpuOptions,
            'coolerOptions' => $coolerOptions,
            'ramOptions' => $ramOptions,
            'gpuOptions' => $gpuOptions,
            'psuOptions' => $psuOptions,
            'caseOptions' => $caseOptions,
            'moboOptions' => $moboOptions,
            'romOptions' => $romOptions,
            'featuredBuildsCount' =>  $featuredBuildsCount,
            'gamas' => $gamas
        ]);
    }

    public function toggle( Build $build ) {

        $featuredBuilds = Build::where('featured', true)->get();

        if ( $build->featured == false && $featuredBuilds->count() > 7 ) {
            return back()->with(['info' => 'Ya existen 8 Builds destacadas']);
        }

        $build->update(["featured" => !$build->featured]);
        return back()->with(['success' => 'Actualizado correctamente']);

    }

    public function featured( Request $request)
    {
        $paginateItems = 12;

        //* QUERY PARAMS
        $gama = json_decode(urldecode($request->input('gama')));
        $priceMin = $request->input('priceMin');
        $priceMax = $request->input('priceMax');
        $sortBy   = $request->input('sortBy');
        $sortByDesc = $request->input('sortByDesc');
        $search   = $request->input('search');
        $sale     = $request->input('sale');

        if (isset($gama)) {
        //* VALIDATIONS:
            //* GAMA:
            $featuredBuilds = new BuildCollection(Build::when($gama, function (Builder $query) use ($gama) {
                $query->where('gama_id', $gama);
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
            $featuredBuilds = new BuildCollection(Build::when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
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
            $featuredBuilds = new BuildCollection(Build::when($search, function (Builder $query) use ( $search ) {
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
            $featuredBuilds = new BuildCollection(Build::when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->where('featured', true)->paginate($paginateItems));

        } else if ( isset($sortBy) || isset($sortByDesc) ) {
            //* SORT PRODUCTS:
            $featuredBuilds = new BuildCollection(Build::when($sortBy, function (Builder $query) {
                $query->orderBy('price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })->where('featured', true)->paginate($paginateItems));

        } else {
            $featuredBuilds = new BuildCollection(Build::where('featured', true)->paginate($paginateItems));
        }

        $gamas = Gama::orderBy('percentage')->get();
        $featuredBuilds->withpath('');

        return Inertia::render('Admin/FeaturedBuild/Index', [
            "featuredBuilds" => $featuredBuilds,
            'gamas' => $gamas,
        ]);
    }

    public function update( Request $request ) {

        $build = Build::find($request->id);

        if($build->rom_multiple_id){

            $romIdDetach = collect([]);

            foreach($build->rom_multiple_id as $key){

                $romIdDetach->push($key['id']);

            }

            $romIdDetach = collect($romIdDetach)
                ->map(function($romIdDetach){
                    return ['product_id' => $romIdDetach];
            });
    
            $build->multipleRom()->detach($romIdDetach);
        }


        $validated = $request->validate([
            'name' => 'required|string|max:35',
            'price' => 'required|numeric|min:0.01|max:999999',
            'cpu_id'=> 'nullable|numeric',
            'cpu_name'=> 'nullable|string|max:65',
            'cpu_link'=> 'nullable|string|max:65534',
            'cooler_id'=>  'nullable|numeric',
            'cooler_name'=>  'nullable|string|max:65',
            'cooler_link'=>  'nullable|string|max:65534',
            'cooler_stock' => 'boolean',
            'ram_id'=> 'nullable|numeric',
            'ram_name'=> 'nullable|string|max:65',
            'ram_link'=> 'nullable|string|max:65534',
            'gpu_id'=> 'nullable|numeric',
            'gpu_name'=> 'nullable|string|max:65',
            'gpu_link'=> 'nullable|string|max:65534',
            'psu_id'=> 'nullable|numeric',
            'psu_name'=> 'nullable|string|max:65',
            'psu_link'=> 'nullable|string|max:65534',
            'case_id'=> 'nullable|numeric',
            'case_name'=> 'nullable|string|max:65',
            'case_link'=> 'nullable|string|max:65534',
            'mobo_id'=> 'nullable|numeric',
            'mobo_name'=> 'nullable|string|max:65',
            'mobo_link'=> 'nullable|string|max:65534',
            'rom_id'=> 'nullable|numeric',
            'rom_name'=> 'nullable|string|max:65',
            'rom_link'=> 'nullable|string|max:65534',
            'gama_id'=> 'required|numeric',
            'warranty' => 'required|string|max:40',
            'quantity' => 'required|numeric|min:0|max:999999',
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

        $build = Build::find($request->id);

        if ( empty($request->images) ) {
            $path = $build->images;
        } else {
            $path = public_path('builds/');
            !is_dir($path) &&
                mkdir($path, 0777, true);

            $imageName = time() . '.' . $request->images[0]['file']->extension();
            $request->images[0]['file']->move($path, $imageName);
            $path = "builds/{$imageName}";
        }

        $build->update([
            'name'=>  $request->name,
            'images' => $path,
            'cpu_id'=> $request->cpu_id,
            'cpu_name'=> $request->cpu_name,
            'cpu_link'=> $request->cpu_link,
            'cooler_id'=>  $request->cooler_id,
            'cooler_name'=>  $request->cooler_name,
            'cooler_link'=>  $request->cooler_link,
            'cooler_stock'=> $request->cooler_stock,
            'ram_id'=>  $request->ram_id,
            'ram_name'=>  $request->ram_name,
            'ram_link'=>  $request->ram_link,
            'ram_units'=>  $request->ram_units,
            'gpu_id'=>  $request->gpu_id,
            'gpu_name'=>  $request->gpu_name,
            'gpu_link'=>  $request->gpu_link,
            'psu_id'=>  $request->psu_id,
            'psu_name'=>  $request->psu_name,
            'psu_link'=>  $request->psu_link,
            'mobo_id'=>  $request->mobo_id,
            'mobo_name'=>  $request->mobo_name,
            'mobo_link'=>  $request->mobo_link,
            'case_id'=>  $request->case_id,
            'case_name'=>  $request->case_name,
            'case_link'=>  $request->case_link,
            'rom_id'=>  $request->rom_id,
            'rom_name'=>  $request->rom_name,
            'rom_link'=>  $request->rom_link,
            'rom_multiple_id' => $request->rom_multiple_id,
            'rom_multiple' => $request->rom_multiple,
            'price'=> $request->price,
            'description'=> $request->description,
            'gama_id'=> $request->gama_id,
            'warranty'=> $request->warranty,
            'quantity'=> $request->quantity,
            'details'=> $request->details,
            'visacuotas'=> $request->visacuotas,
            'shipping'=> $request->shipping,
            'featured'=> $request->featured,
            'sale'=> $request->sale,
            'percentage'=> $request->percentage,
            'sale_price'=> $request->sale_price,
            'normal_price'=> $request->normal_price,
            'sale_normal_price'=> $request->sale_normal_price,
            'show_price'=> $request->show_price,
        ]);

        $romId = collect([]);
        if($request->rom_multiple_id ){
            foreach($request->rom_multiple_id as $key){
                $romId->push($key['id']);
            }
            
            $romsId = collect($romId)
                ->map(function($romId){
                    return ['product_id' => $romId];
            });
    
            $build->multipleRom()->attach($romsId);
        }
        
        return to_route('admin.builds.index')->with(['success' => 'Actualizado correctamente']);
    }

    public function editSale(Build $build) {
        return Inertia::render('Admin/Builds/UpdateSale', [
            'build' => $build,
        ]);
    }

    public function updateSale(Request $request) {
        $build = Build::find($request->id);
        $build->update($request->all());

        return to_route('admin.builds.index')->with(['success' => 'Actualizado correctamente']);
    }

    public function destroy(Build $build)
    {
        $romId = collect([]);
        if($build->rom_multiple_id ){
            foreach($build->rom_multiple_id as $key){
                $romId->push($key['id']);
            }
            
            $romsId = collect($romId)
                ->map(function($romId){
                    return ['product_id' => $romId];
            });
    
            $build->multipleRom()->detach($romsId);
        }

        $build->delete();

        return back()->with(['success' => 'Eliminado correctamente']);;
    }
}
