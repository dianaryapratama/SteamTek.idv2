<?php

use Illuminate\Support\Facades\Route;

// --- IMPORT CONTROLLERS (Agar kode di bawah lebih bersih) ---

// Front (Public/Member)
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController as FrontProductController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\MembershipController;
use App\Http\Controllers\Front\ReviewController;
use App\Http\Controllers\Front\ComplaintController as FrontComplaintController;
use App\Http\Controllers\Front\LibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\FileController;
use App\Http\Controllers\Front\CatalogController;


// Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

/*
|--------------------------------------------------------------------------
| BAGIAN 1: HALAMAN PUBLIK (Bisa diakses siapa saja/Tamu)
|--------------------------------------------------------------------------
*/

// Home & Produk
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/product/{slug}', [FrontProductController::class, 'show'])->name('product.detail');
Route::get('/download/{token}', [FrontProductController::class, 'downloadFile'])->name('file.download');

// Keranjang (Cart)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'addToCart'])->name('add');
    Route::delete('/remove/{id}', [CartController::class, 'removeFromCart'])->name('remove');
    // Kupon
    Route::post('/coupon', [CartController::class, 'applyCoupon'])->name('applyCoupon');
    Route::post('/coupon/remove', [CartController::class, 'removeCoupon'])->name('removeCoupon');
});

// Checkout (Tanpa Login)
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'process'])->name('process');
    Route::get('/payment/{invoice}', [CheckoutController::class, 'payment'])->name('payment');
    Route::post('/confirm/{invoice}', [CheckoutController::class, 'uploadProof'])->name('upload-proof');
    Route::get('/success/{invoice}', [CheckoutController::class, 'success'])->name('success');
});

// Fitur Lainnya (Review & Kontak)
Route::post('/product/{id}/review', [ReviewController::class, 'store'])->name('review.store');
Route::get('/contact', [FrontComplaintController::class, 'index'])->name('contact.index');
Route::post('/contact', [FrontComplaintController::class, 'store'])->name('contact.store');
Route::get('/download/{token}', [App\Http\Controllers\Front\FileController::class, 'download'])->name('file.download');

/*
|--------------------------------------------------------------------------
| BAGIAN 2: MEMBER AREA (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Fitur Membership Upgrade
    Route::get('/membership', [MembershipController::class, 'index'])->name('membership.index');
    Route::get('/membership/pay', [MembershipController::class, 'payment'])->name('membership.payment');
    Route::post('/membership/buy', [MembershipController::class, 'store'])->name('membership.store');
    // Profile (Breeze default, tapi view-nya sudah kita edit)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Library
    Route::get('/library', [LibraryController::class, 'index'])->name('front.library');
});


/*
|--------------------------------------------------------------------------
| BAGIAN 3: ADMIN DASHBOARD (Wajib Login & Wajib Admin)
|--------------------------------------------------------------------------
| Note: Middleware 'admin' ditambahkan di sini agar user biasa ditolak.
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Produk & Pesanan
    Route::resource('products', AdminProductController::class);
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/confirm', [OrderController::class, 'confirmOrder'])->name('orders.confirm');
    
    // Manajemen Membership (Approval & Setting)
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::put('/members/{id}', [MemberController::class, 'update'])->name('members.update');
    Route::post('/transactions/{id}/approve', [MemberController::class, 'approveTransaction'])->name('transactions.approve');
    Route::post('/transactions/{id}/reject', [MemberController::class, 'rejectTransaction'])->name('transactions.reject');

    // Manajemen Fitur Lain (Kupon, Banner, Metode Bayar, Komplain)
    Route::resource('coupons', CouponController::class)->except(['show', 'edit', 'update']);
    Route::resource('complaints', AdminComplaintController::class)->only(['index', 'update', 'destroy']);
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::resource('banners', BannerController::class)->only(['index', 'create', 'store', 'destroy']);

    // Admin Profile (Opsional jika Anda pakai custom controller)
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
});

// Auth Routes (Login, Register, Logout dari Breeze)
require __DIR__.'/auth.php';