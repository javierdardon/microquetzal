<?php

namespace App\Http\Controllers\Web;

use App\Models\About;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index() {
        $about = About::find(1);

        return Inertia::render('Web/About/Index', [
            'about' => $about
        ]); 
    }
}
