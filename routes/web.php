<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassCategoryController;
use App\Http\Controllers\NavCategoryController;
use App\Http\Controllers\ProductAdminController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShowMoreProductController;
use Illuminate\Support\Facades\Crypt;

Route::get('/', function () {
    return Inertia::render('Dashboard', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/register', [RegisterController::class, 'index'])->name('register');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//     Route::resource('departments', DepartmentController::class);
//     Route::resource('employees', EmployeeController::class);
//     Route::get('graphic', [EmployeeController::class, 'EmployeeByDepartment'])->name('graphic');
//     Route::get('reports', [EmployeeController::class, 'reports'])->name('reports');
// });

    Route::get('/listcategories', [NavCategoryController::class, 'index']); // Asegúrate de ajustar la ruta y el controlador según tu configuración
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::resource('departments', DepartmentController::class);
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

        Route::resource('admin/class_categories', ClassCategoryController::class);

        Route::resource('admin/categories', CategoryController::class);

        Route::resource('admin/subcategories', SubcategoryController::class);

        Route::resource('admin/products', ProductAdminController::class);

    });
    // Route::get('{categoria2}/{id}', [ProductController::class, 'showDetailProduct'])->name('product.details3');

    Route::get('/{class_category}/show-category', [ClassCategoryController::class, 'showCategoryInClassCategory'])->name('class_category.index');

    Route::get('/{categoria}/{subcategoria}', [ProductController::class, 'index'])->name('subcategorias.index');

    // Route::get('{categoria2}/{id}', [ProductController::class, 'showDetail2'])->name('product.details2');

    Route::get('/{categoria}/showMoreProducts', [ProductController::class, 'showProductsByCategory'])->name('show_more_products.index');



    Route::get('{categoria2}/product/{id}', [ProductController::class, 'showDetailProduct'])->name('product.details');

    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('employees', EmployeeController::class);

    Route::get('{categoria}', [ProductController::class, 'listByClassCategory'])->name('classcategory.index');

    // Route::get('{categoria}', [ProductController::class, 'listByCategory'])->name('categoria.index');

    // Route::resource('/{categoria}/showMoreProducts', ShowMoreProductController::class);



    Route::get('graphic', [EmployeeController::class, 'EmployeeByDepartment'])->name('graphic');
    Route::get('reports', [EmployeeController::class, 'reports'])->name('reports');

require __DIR__.'/auth.php';
