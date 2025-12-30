<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminRequestController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Client\ProductRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Catálogo B&R Tecnología
|--------------------------------------------------------------------------
|
| Sistema público de catálogo con panel de administración.
| - Público: Catálogo, cotizaciones, solicitudes (sin login)
| - Administrador: Gestión completa del sistema
|
*/

// ============================================
// RUTAS PÚBLICAS
// ============================================

Route::get('/', function () {
    return view('home');
})->name('home');

// Catálogo de productos
Route::get('/catalog', [ProductCatalogController::class, 'index'])->name('catalog.index');
Route::get('/productos', [ProductCatalogController::class, 'index'])->name('catalog');
Route::get('/productos/{product}', [ProductCatalogController::class, 'show'])
    ->middleware('track.views')
    ->name('catalog.show');

// Páginas informativas
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->middleware('throttle:contact')->name('contact.send');

// Ruta para crear productos (API/tests)
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Solicitud de producto (disponible para todos, autenticados o no)
Route::post('/productos/{product}/solicitar', [ProductRequestController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('product.request');

// ============================================
// SISTEMA DE COTIZACIONES (Público)
// ============================================
Route::prefix('cotizacion')->name('quote.')->group(function () {
    Route::get('/', [QuoteController::class, 'index'])->name('index');
    Route::post('/agregar/{product}', [QuoteController::class, 'addItem'])->name('add');
    Route::patch('/item/{item}', [QuoteController::class, 'updateItem'])->name('update');
    Route::delete('/item/{item}', [QuoteController::class, 'removeItem'])->name('remove');
    Route::delete('/vaciar', [QuoteController::class, 'clear'])->name('clear');
    Route::get('/checkout', [QuoteController::class, 'checkout'])->name('checkout');
    Route::post('/enviar', [QuoteController::class, 'send'])->name('send');
    Route::get('/exito/{quote}', [QuoteController::class, 'success'])->name('success');
    Route::get('/ver/{quote}', [QuoteController::class, 'view'])->name('view');
    Route::get('/pdf/{quote}', [QuoteController::class, 'downloadPdf'])->name('pdf');
    Route::get('/count', [QuoteController::class, 'getCount'])->name('count');
});

// ============================================
// RUTAS AUTENTICADAS
// ============================================

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Email change routes - POST for action, GET redirects to profile
    Route::post('/profile/email-change', [ProfileController::class, 'requestEmailChange'])->name('profile.request-email-change');
    Route::get('/profile/email-change', fn() => redirect()->route('profile.edit'))->name('profile.email-change.redirect');
    Route::post('/profile/email-change/cancel', [ProfileController::class, 'cancelEmailChange'])->name('profile.cancel-email-change');
    Route::get('/profile/email-change/cancel', fn() => redirect()->route('profile.edit'));
});

Route::get('/profile/verify-email/{token}', [ProfileController::class, 'verifyEmailChange'])->name('profile.verify-email-change');

// ============================================
// RUTAS DE ADMINISTRACIÓN
// ============================================

Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Categorías
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    
    // CMS
    Route::get('/admin/content', [ContentController::class, 'index'])->name('admin.content.index');
    Route::get('/admin/content/{section}', [ContentController::class, 'editSection'])->name('admin.content.section');
    Route::put('/admin/content/{section}', [ContentController::class, 'updateSection'])->name('admin.content.section.update');
    Route::post('/admin/content/reset/{id}', [ContentController::class, 'resetContent'])->name('admin.content.reset');
    Route::delete('/admin/content/image/{id}', [ContentController::class, 'removeImage'])->name('admin.content.image.remove');
    Route::get('/admin/content/{section}/preview', [ContentController::class, 'preview'])->name('admin.content.preview');
    
    // Gestión de Solicitudes (Admin)
    Route::get('/admin/solicitudes', [AdminRequestController::class, 'index'])->name('admin.requests.index');
    Route::get('/admin/solicitudes/export', [AdminRequestController::class, 'export'])->name('admin.requests.export');
    Route::get('/admin/solicitudes/{productRequest}', [AdminRequestController::class, 'show'])->name('admin.requests.show');
    Route::patch('/admin/solicitudes/{productRequest}/status', [AdminRequestController::class, 'updateStatus'])->name('admin.requests.status');
    Route::post('/admin/solicitudes/{productRequest}/respond', [AdminRequestController::class, 'respond'])->name('admin.requests.respond');
    Route::delete('/admin/solicitudes/{productRequest}', [AdminRequestController::class, 'destroy'])->name('admin.requests.destroy');
    
    // Gestión de Cotizaciones (Admin)
    Route::get('/admin/cotizaciones', [App\Http\Controllers\Admin\AdminQuoteController::class, 'index'])->name('admin.quotes.index');
    Route::get('/admin/cotizaciones/{quote}', [App\Http\Controllers\Admin\AdminQuoteController::class, 'show'])->name('admin.quotes.show');
    Route::patch('/admin/cotizaciones/{quote}/status', [App\Http\Controllers\Admin\AdminQuoteController::class, 'updateStatus'])->name('admin.quotes.status');
    Route::get('/admin/cotizaciones/{quote}/pdf', [App\Http\Controllers\Admin\AdminQuoteController::class, 'downloadPdf'])->name('admin.quotes.pdf');
    Route::delete('/admin/cotizaciones/{quote}', [App\Http\Controllers\Admin\AdminQuoteController::class, 'destroy'])->name('admin.quotes.destroy');
    
    // Gestión de Usuarios Administradores
    Route::get('/admin/usuarios', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/usuarios/crear', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/usuarios', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/usuarios/{user}/editar', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/usuarios/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/usuarios/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Productos
    Route::get('/products/exports', function () { return redirect('/products/export'); });
    Route::match(['get', 'post'], '/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::resource('products', ProductController::class)->except(['store']);
});

require __DIR__.'/auth.php';
