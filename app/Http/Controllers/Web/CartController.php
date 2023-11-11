<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Web/Cart/Index');
    }

    public function info(): Response
    {
        return Inertia::render('Web/Cart/Info', [
            'user' => Auth::user()
        ]);
    }

    public function shipping() {
        return Inertia::render('Web/Cart/Shipping');
    }
}
