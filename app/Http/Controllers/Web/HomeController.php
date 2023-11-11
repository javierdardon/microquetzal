<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ConfigurationHero;
use App\Models\ConfigurationSocial;
use App\Models\ConfigurationFinalFrame;
use App\Models\Product;
use App\Models\Build;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index() {

        $products = Product::where('featured', true)->get();
        $featuredBuilds = Build::with(['cpu', 'cooler', 'ram', 'gpu', 'psu', 'mobo', 'case', 'rom'])->where('featured', true)->get();
        $hero = ConfigurationHero::find(1);
        $finalFrame = ConfigurationFinalFrame::find(1);
        $socialLink = ConfigurationSocial::find(1);

        return Inertia::render('Web/Home/Index', [
            'products' => $products,
            'featuredBuilds' => $featuredBuilds,
            'hero' => $hero,
            'finalFrame' => $finalFrame,
            'socialLink' => $socialLink,
        ]);
    }
}
