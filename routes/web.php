<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\API\CartAPIController;
use App\Http\Controllers\API\OrderAPIController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\API\ReviewAPIController;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\API\ProductAPIController;
use App\Http\Controllers\Payment\PayPalController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\PageController as ControllersPageController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

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

Route::get('/', [ControllersPageController::class, 'index'])->name('home');

// Google and github login routes


Route::get('/auth/{provider}/redirect', [ProviderController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback'])->name('auth.callback');

// Login and post login
Route::get('/login', [UserController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [UserController::class, 'login'])->middleware('guest');

// Register and post register
Route::get('/register', [UserController::class, 'showRegister'])->middleware('guest')->name('register');
Route::post('/register', [UserController::class, 'register'])->middleware('guest');

// Logout route
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

// Forgot-password and post forgot-password
Route::get('/forgot-password', [UserController::class, 'showPasswordReset'])->middleware('guest')->name('forgot-password');
Route::post('/forgot-password', [UserController::class, 'passwordResetPost'])->middleware('guest');

// ResetPassword
Route::get("/reset-password/{token}", [UserController::class, 'resetPassword'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [UserController::class, 'resetPasswordPost'])->middleware('guest')->name('post-reset-password');

// Admin Route Group
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['RedirectIfNotAdmin']], function () {
    Route::get('/', [PageController::class, 'dashboard'])->name('dashboard');
    Route::resource('/users', AdminUserController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/products', ProductController::class);
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}', [AdminOrderController::class, 'markAsDelivered'])->name('orders.markAsDelivered');
});

// Profile page
Route::get('/profile', [ControllersPageController::class, 'profile'])->name('profile')->middleware('auth');
Route::post('/profile', [ControllersPageController::class, 'updateProfile'])->middleware('auth');

// Bookmarked products page
Route::get('/bookmarks', [ControllersPageController::class, 'bookmarks'])->name('bookmarks');

// Cart page
Route::get('/cart', [ControllersPageController::class, 'cart'])->name('cart');

// Shop Page
Route::get('/shop', [ControllersPageController::class, 'shop'])->name('shop');

// Individual Product Page
Route::get('/products/{id}', [ControllersPageController::class, 'product'])->name('product');

// Checkout page
Route::get('/checkout', [ControllersPageController::class, 'checkout'])->middleware('auth')->name('checkout');

// Orders route group
Route::group(['prefix' => '/orders', 'as' => 'orders.', 'middleware' => ['auth']], function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{id}', [OrderController::class, 'show'])->name('show');
});

// Api Routes Group
Route::group(['prefix' => 'api', 'as' => 'api.', 'middleware' => ['auth']], function () {
    Route::post('/bookmark-product', [ProductAPIController::class, 'bookmark_product']);
    Route::post('/unbookmark-product', [ProductAPIController::class, 'unbookmark_product']);
    Route::post('/add-to-cart', [CartAPIController::class, 'addToCart']);
    Route::post('/remove-from-cart', [CartAPIController::class, 'removeFromCart']);
    Route::post('/update-cart-items-count', [CartAPIController::class, 'changeItemCount']);
    Route::post('/create-review', [ReviewAPIController::class, 'store']);
    Route::post('/place-order', [OrderAPIController::class, 'createOrder']);
});

Route::get('/api/get-products', [ProductAPIController::class, 'get_products']);

// PayPal routes group
Route::group(['prefix' => 'payment/paypal', 'as' => 'paypal.', 'middleware' => ['auth']], function () {
    Route::post('/process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
    Route::get('/success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
    Route::get('/cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');
});
