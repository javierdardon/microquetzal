<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\BankAccountsInfo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Response;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();

        return Inertia::render('Web/Auth/Profile', [
            'user' => $user,
        ]);
    }

    public function orders(): Response
    {
        $orders = Order::where('user_id', Auth::id())->get();

        $bankAccounts = BankAccountsInfo::all();

        return Inertia::render('Web/Auth/Orders', [
            'orders' => $orders,
            'bankAccounts' => $bankAccounts,
        ]);
    }

    public function updateMainInfo( Request $request )
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.Auth::id(),
            'phone' => 'integer|max_digits:8',
            'second_phone' => 'max_digits:8',
        ]);

        $user = User::find(Auth::id());
        $user->update($request->all());
        $user->save();

        return to_route('web.auth.user.index')->with(['success' => 'Su información se ha actualizado correctamente.']);
    }

    public function updateAddress( Request $request )
    {
        $request->validate([
            'address' =>'required|string|max:255',
            'department' =>'required|string|max:255',
            'municipality' =>'required|string|max:255',
            'reference' =>'max:255'
        ]);

        $user = User::find(Auth::id());
        $user->update($request->all());
        $user->save();

        return to_route('web.auth.user.index')->with(['success' => 'Su información se ha actualizado correctamente.']);
    }

    public function updatePassword( Request $request ) {
        $user = User::find(Auth::user());

        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->password = Hash::make($request->password);

        $user = User::find(Auth::id());
        $user->update($request->all());
        $user->save();

        return redirect(RouteServiceProvider::HOME)->with(['success' => 'Su información de seguridad se ha actualizado correctamente.']);
    }


}
