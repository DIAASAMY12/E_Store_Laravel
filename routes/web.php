<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemControllerUser;
use App\Http\Controllers\LowQuantityEmailController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SeederController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorItemController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});





//Route::resource('users', UserController::class);

Route::resource('users', UserController::class)->names([
//    'index' => 'users.index',
    'create' => 'users.create',
    'store' => 'users.store',
    'show' => 'users.show',
    'edit' => 'users.edit',
    'update' => 'users.update',
    'destroy' => 'users.destroy',
]);

Route::get('/users', [UserController::class, 'index'])->name('users.index');


Route::get('/run-seeder', [SeederController::class, 'runSeeder'])->name('run.seeder');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::middleware('admin')->group(function () {
    Route::resource('users', UserController::class);

});


Route::resource('vendors', VendorController::class);

Route::resource('inventories', InventoryController::class);

Route::resource('brands', BrandController::class);

Route::resource('items', ItemController::class);

Route::resource('countries', CountryController::class);

Route::resource('cities', CityController::class);

Route::resource('inventory_items', InventoryItemController::class);

Route::resource('vendor_items', VendorItemController::class);

Route::middleware('not_admin')->group(function () {


//    Route::get('/cart/add/{item}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::post('/items/{id}/add-to-cart', [ItemController::class, 'addToCart'])->name('cart.add');

    Route::get('/purchase_orders', [PurchaseOrderController::class, 'index'])->name('purchase_orders.index');

    Route::post('purchase-order', [PurchaseOrderController::class, 'createPurchaseOrder'])->name('purchase-order.create');

});


