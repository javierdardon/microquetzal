<?php
//*ADMIN CONTROLLERS:
use App\Http\Controllers\Admin\AdminConfigurationController;
use App\Http\Controllers\Admin\AdminBuildController;
use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminFroalaController;

//* WEB CONTROLLERS:
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\BuildController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\LoginUserController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\RegisterUserController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//! WEB ROUTES:

Route::as('web.')->group(function () {
    //* Home:
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    //* Products:
    Route::controller(ProductController::class)->as('products.')->group(function () {
        Route::get('/productos', 'index')->name('index');
        Route::get('/productos/{product}', 'view')->name('view');
    });

    //* Builds:
    Route::controller(BuildController::class)->as('builds.')->group(function () {
        Route::get('/equipos', [BuildController::class, 'index'])->name('index');
        Route::get('/equipos/{build}', 'view')->name('view');
    });

    //* About:
    Route::get('/nosotros',[AboutController::class, 'index'])->name('about.index');

    //* AUTH:
    Route::get('/registrarse', [RegisterUserController::class, 'create'])->name('auth.register');
    Route::post('/registrarse', [RegisterUserController::class, 'store'])->name('auth.register.store');

    Route::middleware('user.redirect')->group(function() {
        Route::get('/iniciar-sesion', [LoginUserController::class, 'create'])->name('auth.login');
        Route::post('/iniciar-sesion', [LoginUserController::class, 'store'])->name('auth.login.store');
    });


    Route::middleware('user.guard')->as('auth.')->group(function() {
        Route::get('/perfil', [UserController::class, 'index'])->name('user.index');
        Route::patch('/perfil/main', [UserController::class, 'updateMainInfo'])->name('user.main');
        Route::patch('/perfil/address', [UserController::class, 'updateAddress'])->name('user.address');
        Route::patch('/perfil/pass', [UserController::class, 'updatePassword'])->name('user.pass');
        Route::get('/perfil/pedidos', [UserController::class, 'orders'])->name('user.orders');
        Route::get('/carrito/envio', [CartController::class, 'info'])->name('cart.info');
        Route::get('/carrito/metodo-envio', [CartController::class, 'shipping'])->name('cart.shipping');
        Route::post('/carrito/completar', [OrderController::class, 'store'])->name('order.store');
    });

    //* Cart:
    Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
});



//! ADMIN ROUTES:
Route::middleware('admin.guard')->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('dashboard');

    //* Profile Routes:
    Route::controller(AdminProfileController::class)->as('profile.')->group(function () {
        Route::get('/profile', 'edit')->name('edit');
        Route::patch('/profile', 'update')->name('update');
        Route::delete('/profile', 'destroy')->name('destroy');
    });

    //* Products routes:
    Route::controller(AdminProductController::class)->as('product.')->group(function () {
        Route::get('/products', 'index')->name('index');
        Route::get('/products-create', 'create')->name('create');
        Route::post('/products-store', 'store')->name('store');
        Route::delete('/products/{product}', 'destroy')->name('destroy');
        Route::post('/products-update', 'update')->name('update');
        Route::get('/products-edit/{product}', 'edit')->name('edit');
        Route::get('/products-edit-sale/{product}', 'editSale')->name('edit.sale');
        Route::post('/products-update-sale', 'updateSale')->name('update.sale');

        //? FEATUREDS
        Route::get('/products/featured', 'featured')->name('featured');
        Route::patch('/products/featured/{product}', 'toggle')->name('featured.toggleOn');
    });

    //* Build routes:
    Route::controller(AdminBuildController::class)->as('builds.')->group(function () {
        Route::get('/builds', 'index')->name('index');
        Route::get('/builds-create', 'create')->name('create');
        Route::post('/builds', 'store')->name('store');
        Route::delete('/builds/{build}', 'destroy')->name('destroy');
        Route::post('/builds-update', 'update')->name('update');
        Route::get('/builds-edit/{build}', 'edit')->name('edit');
        Route::get('/builds-edit-sale/{build}', 'editSale')->name('edit.sale');
        Route::post('/builds-update-sale', 'updateSale')->name('update.sale');

        //? FEATUREDS
        Route::get('/builds/featured', 'featured')->name('featured');
        Route::patch('/builds/featured/{build}', 'toggle')->name('featured.toggleOn');
    });

    //* Categories routes:
    Route::controller(AdminCategoryController::class)->as('categories.')->group(function () {
        Route::get('/categories', 'index')->name('index');
        Route::get('/categories-create', 'create')->name('create');
        Route::post('/categories-store', 'store')->name('store');
        Route::delete('/categories/{category}', 'destroy')->name('destroy');
        Route::get('/categories-edit/{category}', 'edit')->name('edit');
        Route::patch('/categories-update', 'update')->name('update');
    });

    //* Brands routes:
    Route::controller(AdminBrandController::class)->as('brands.')->group(function () {
        Route::get('/brands', 'index')->name('index');
        Route::get('/brands-create', 'create')->name('create');
        Route::post('/brands-store', 'store')->name('store');
        Route::delete('/brands/{brand}', 'destroy')->name('destroy');
        Route::get('/brands-edit/{brand}', 'edit')->name('edit');
        Route::patch('/brands-update', 'update')->name('update');
    });


    //* Configuration routes:
    Route::controller(AdminConfigurationController::class)->as('configurations.')->group(function () {
        Route::get('/configurations', 'index')->name('index');
        Route::get('/configurations/social-links', 'socialLinksIndex')->name('socialLinksIndex');
        Route::patch('/configurations/social-links', 'socialLinksUpdate')->name('socialLinksUpdate');

        //? HERO
        Route::get('/configurations/hero', 'heroIndex')->name('heroIndex');
        Route::post('/configurations/hero/update', 'heroUpdate')->name('heroUpdate');
        Route::patch('/configurations/hero/default', 'heroDefault')->name('heroDefault');

        //? FINAL FRAME
        Route::get('/configurations/final-frame', 'FinalFrameIndex')->name('finalFrameIndex');
        Route::post('/configurations/final-frame/update', 'FinalFrameUpdate')->name('finalFrameUpdate');
        Route::patch('/configurations/final-frame/default', 'FinalFrameDefault')->name('finalFrameDefault');

        //? ABOUT
        Route::get('/configurations/about', 'aboutIndex')->name('aboutIndex');
        Route::post('/configurations/about-update', 'aboutUpdate')->name('aboutUpdate');

        //? BUILD COMPONENT CATEGORIES
        Route::get('/configurations/build-component-categories', 'BuildComponentCategoriesIndex')->name('buildComponentCategories.index');
        Route::post('/configurations/build-component-categories-update', 'BuildComponentCategoriesUpdate')->name('buildComponentCategories.update');

        //? ACCOUNTS BANK
        Route::get('/configurations/bank-accounts', 'bankAccountsIndex')->name('bankAccounts.index');
        Route::get('/configurations/bank-accounts-create', 'bankAccountsCreate')->name('bankAccounts.create');
        Route::post('/configurations/bank-accounts-store', 'bankAccountsStore')->name('bankAccounts.store');
        Route::delete('/configurations/bank-accounts/{bankAccount}', 'bankAccountsDestroy')->name('bankAccounts.destroy');
        Route::get('/configurations/bank-accounts/{bankAccount}', 'bankAccountsEdit')->name('bankAccounts.edit');
        Route::patch('/configurations/bank-accounts-update', 'bankAccountsUpdate')->name('bankAccounts.update');


        //? GAMAS CONFIGURATION
        Route::get('/configurations/gamas', 'gamasIndex')->name('gamas.index');
        Route::get('/configurations/gamas-create', 'gamasCreate')->name('gamas.create');
        Route::get('/configurations/gamas-edit/{gama}', 'gamasEdit')->name('gamas.edit');
        Route::post('/configurations/gamas-store', 'gamasStore')->name('gamas.store');
        Route::patch('/configurations/gamas-update', 'gamasUpdate')->name('update');
        Route::delete('/configurations/gamas-destroy/{gama}', 'gamasDestroy')->name('gamas.destroy');
    });

    //* Orders:
    Route::controller(AdminOrderController::class)->as('orders.')->group(function () {
        Route::get('/orders', 'index')->name('index');
        Route::get('/orders-edit/{order}', 'edit')->name('edit');
        Route::post('/orders-update', 'update')->name('update');
        Route::get('/orders-view/{order}', 'view')->name('view');
    });

    //* Froala Routes:
    Route::post('/froala-upload', [AdminFroalaController::class, 'saveImage'])->name('froala.save');
    Route::post('/froala-remove', [AdminFroalaController::class, 'deleteImage'])->name('froala.remove');

    //* Route Controller Group Template:
    // Route::controller(::class)->as('')->group(function () {

    // });
});

require __DIR__.'/auth.php';
