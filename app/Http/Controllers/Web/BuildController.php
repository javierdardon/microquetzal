<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Build;
use App\Models\Gama;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class BuildController extends Controller
{
    public function index( Request $request ) {

        $paginateItems = 12;

        //* QUERY PARAMS
        $gamas = json_decode(urldecode($request->input('gamas')));
        $priceMin = $request->input('priceMin');
        $priceMax = $request->input('priceMax');
        $sortBy   = $request->input('sortBy');
        $sortByDesc = $request->input('sortByDesc');
        $search   = $request->input('search');
        $sale     = $request->input('sale');

        //* VALIDATIONS:
        if ( !empty($gamas) ) {
            //* GAMAS:
            $builds = Build::with(['cpu', 'cooler', 'ram', 'gpu', 'psu', 'mobo', 'case', 'rom', 'gama'])
            ->when($gamas, function (Builder $query, $gamas) use ($priceMin, $priceMax, $sortBy, $sortByDesc, $search, $sale, $paginateItems) {
                    $query->whereIn('gama_id', $gamas);
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
            $builds = Build::with(['cpu', 'cooler', 'ram', 'gpu', 'psu', 'mobo', 'case', 'rom', 'gama'])->when($priceMin, function (Builder $query) use ($priceMin, $priceMax) {
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
            $builds = Build::with(['cpu', 'cooler', 'ram', 'gpu', 'psu', 'mobo', 'case', 'rom', 'gama'])->when($search, function (Builder $query) use ( $search ) {
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
            $builds = Build::with(['cpu', 'cooler', 'ram', 'gpu', 'psu', 'mobo', 'case', 'rom', 'gama'])->when($sale, function (Builder $query) use ( $sale ) {
                $query->where('sale', '=', true);
            })->when($sortBy, function (Builder $query) {
                $query->orderBy('show_price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('show_price', 'desc');
            })->paginate($paginateItems);

        
        } else if ( isset($sortBy) || isset($sortByDesc) ) {
            //* SORT PRODUCTS:
            $builds = Build::with(['cpu', 'cooler', 'ram', 'gpu', 'psu', 'mobo', 'case', 'rom', 'gama'])->when($sortBy, function (Builder $query) {
                $query->orderBy('show_price');
            })->when($sortByDesc, function (Builder $query) {
                $query->orderBy('show_price', 'desc');
            })->paginate($paginateItems);

        } else {
            $builds = Build::with(['cpu', 'cooler', 'ram', 'gpu', 'psu', 'mobo', 'case', 'rom', 'gama'])->orderBy('show_price')->paginate($paginateItems);
        }

        $gamas = Gama::orderBy('percentage')->get();
        $builds->withPath('');

        return Inertia::render('Web/Builds/Index', [
            'builds' => $builds,
            'gamas' => $gamas,
        ]);
    }

    public function view( Build $build ) {
        $build = Build::with(['cpu', 'cooler', 'ram', 'gpu', 'psu', 'mobo', 'case', 'rom', 'gama'])->find($build->id);

        return Inertia::render('Web/Builds/View', [
            'build' => $build,
        ]);
    }
}
