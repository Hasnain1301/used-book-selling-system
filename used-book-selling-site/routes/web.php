<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\LogoutController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

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
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'save']);


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings/create', [ListingController::class, 'add'])->name('listings.add');
    Route::delete('/listings/{listing}/delete', [ListingController::class, 'delete'])->name('listings.delete');
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
    Route::get('/individual/listings/{listing}', [ListingController::class, 'showListing'])->name('listings.show');

    Route::get('manage/listings', [ListingController::class, 'manageListings'])->name('manage.listings');

    Route::get('/basket', [BasketController::class, 'show'])->name('basket');
    Route::post('/basket/add/{listingId}', [BasketController::class, 'addToBasket'])->name('basket.add');
    Route::delete('/basket/remove/{listingId}', [BasketController::class, 'removeFromBasket'])->name('basket.remove');

    Route::get('/success', [BasketController::class, 'success'])->name('checkout.success');
    Route::post('/checkout', [BasketController::class, 'checkout'])->name('basket.checkout');
    Route::get('/cancel', [BasketController::class, 'cancel'])->name('checkout.cancel');

    Route::get('/order-address', [AddressController::class, 'show'])->name('order.address');
    Route::post('/payment-option', [AddressController::class, 'saveAddress'])->name('address.save');
    Route::post('/temp-address', [AddressController::class, 'saveTempAddress'])->name('address.temp');
    Route::post('/set-primary-address', [AddressController::class, 'setPrimaryAddress'])->name('address.setPrimary');
    Route::delete('/address/{address}', [AddressController::class, 'delete'])->name('address.delete');
    Route::post('/use-primary-address', [AddressController::class, 'usePrimaryAddress'])->name('usePrimaryAddress');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('profile/order-history', [ProfileController::class, 'showOrderHistory'])->name('profile.orderHistory');
    Route::get('profile/sold-books', [ProfileController::class, 'showSoldBooks'])->name('profile.soldBooks');

    Route::delete('/profile/addresses/{address}', [ProfileController::class, 'deleteAddress'])->name('addresses.delete');
    Route::post('/profile/addresses/{address}/set-primary', [ProfileController::class, 'setPrimaryAddress'])->name('addresses.setPrimary');
    Route::get('/profile/orders/{orderId}', [ProfileController::class, 'showOrderDetails'])->name('profile.orderDetails');
    Route::put('/orders/{order}/cancel', [ProfileController::class, 'cancel'])->name('orders.cancel');
    Route::post('/relist/{soldBookId}', [ProfileController::class, 'relistItem'])->name('sold.relist');
    Route::get('/orders/{order}/return', [ProfileController::class, 'returnForm'])->name('orders.returnForm');
    Route::post('/orders/{order}/request-return', [ProfileController::class, 'requestReturn'])->name('orders.requestReturn');
    Route::post('/orders/{order}/submit-return', [ProfileController::class, 'submitReturnRequest'])->name('orders.submitReturn');
    Route::get('/orders/{orderId}/view-return', [ProfileController::class, 'viewReturnRequest'])->name('orders.viewReturn');
    Route::post('/orders/{orderId}/accept-return', [ProfileController::class, 'acceptReturnRequest'])->name('orders.acceptReturn');
    Route::post('/orders/{orderId}/reject-return', [ProfileController::class, 'rejectReturnRequest'])->name('orders.rejectReturn');
    Route::post('/complete-order/{soldBookId}', [ProfileController::class, 'completeOrder'])->name('completeOrder');
});
