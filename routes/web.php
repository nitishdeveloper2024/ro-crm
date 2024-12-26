<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RechargeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\PartSaleController;
use App\Http\Controllers\PartsController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('/permissions/update/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/permissions/delete', [PermissionController::class, 'destroy'])->name('permission.destroy');

    Route::get('/roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/roles/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/roles/delete', [RoleController::class, 'destroy'])->name('role.destroy');

    // article 

    Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('article.create');
    Route::post('/articles/store', [ArticleController::class, 'store'])->name('article.store');
    Route::get('/articles/edit/{id}', [ArticleController::class, 'edit'])->name('article.edit');
    Route::post('/articles/update/{id}', [ArticleController::class, 'update'])->name('article.update');
    Route::delete('/articles/delete', [ArticleController::class, 'destroy'])->name('article.destroy');

    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/delete', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/sales', [SaleController::class, 'index'])->name('sale.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sale.create');
    Route::post('/sales/store', [SaleController::class, 'store'])->name('sale.store');
    Route::get('/sales/edit/{id}', [SaleController::class, 'edit'])->name('sale.edit');
    Route::post('/sales/update/{id}', [SaleController::class, 'update'])->name('sale.update');
    Route::delete('/sales/delete', [SaleController::class, 'destroy'])->name('sale.destroy');
    Route::post('get-product-price', [SaleController::class, 'getProductPrice'])->name('getProductPrice');

    Route::get('/parts', [PartsController::class, 'index'])->name('part.index');
    Route::get('/parts/create', [PartsController::class, 'create'])->name('part.create');
    Route::post('/parts/store', [PartsController::class, 'store'])->name('part.store');
    Route::get('/parts/edit/{id}', [PartsController::class, 'edit'])->name('part.edit');
    Route::post('/parts/update/{id}', [PartsController::class, 'update'])->name('part.update');
    Route::delete('/parts/delete', [PartsController::class, 'destroy'])->name('part.destroy');

    Route::get('/partsale', [PartSaleController::class, 'index'])->name('partsale.index');
    Route::get('/partsale/create', [PartSaleController::class, 'create'])->name('partsale.create');
    Route::post('/partsale/store', [PartSaleController::class, 'store'])->name('partsale.store');
    Route::get('/partsale/edit/{id}', [PartSaleController::class, 'edit'])->name('partsale.edit');
    Route::post('/partsale/update/{id}', [PartSaleController::class, 'update'])->name('partsale.update');
    Route::delete('/partsale/delete', [PartSaleController::class, 'destroy'])->name('partsale.destroy');
    Route::post('get-part-price', [PartSaleController::class, 'getPartPrice'])->name('getPartPrice');

    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaint.index');
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaint.create');
    Route::post('/complaints/store', [ComplaintController::class, 'store'])->name('complaint.store');
    Route::get('/complaints/edit/{id}', [ComplaintController::class, 'edit'])->name('complaint.edit');
    Route::post('/complaints/update/{id}', [ComplaintController::class, 'update'])->name('complaint.update');
    Route::delete('/complaints/delete', [ComplaintController::class, 'destroy'])->name('complaint.destroy');

    Route::get('/services', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('/services/store', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/services/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
    Route::post('/services/update/{id}', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/services/delete', [ServiceController::class, 'destroy'])->name('service.destroy');

    
    Route::get('/rentals', [RentalController::class, 'index'])->name('rental.index');
    Route::get('/rentals/create', [RentalController::class, 'create'])->name('rental.create');
    Route::post('/rentals/store', [RentalController::class, 'store'])->name('rental.store');
    Route::get('/rentals/edit/{id}', [RentalController::class, 'edit'])->name('rental.edit');
    Route::post('/rentals/update/{id}', [RentalController::class, 'update'])->name('rental.update');
    Route::delete('/rentals/delete', [RentalController::class, 'destroy'])->name('rental.destroy');

    Route::get('/recharges', [RechargeController::class, 'index'])->name('recharge.index');
    Route::get('/recharges/create', [RechargeController::class, 'create'])->name('recharge.create');
    Route::post('/recharges/store', [RechargeController::class, 'store'])->name('recharge.store');
    Route::get('/recharges/edit/{id}', [RechargeController::class, 'edit'])->name('recharge.edit');
    Route::post('/recharges/update/{id}', [RechargeController::class, 'update'])->name('recharge.update');
    Route::delete('/recharges/delete', [RechargeController::class, 'destroy'])->name('recharge.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/delete', [UserController::class, 'destroy'])->name('user.destroy');

    // Route::get('/notifications', [NotificationController::class, 'index'])->name('notification.index');
    // Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Route::get('/notifications', [NotificationController::class, 'checkSalesForNotifications'])->name('notification.checkSalesForNotifications');

    // Route::get('/check-sales-notifications', [NotificationController::class, 'checkSalesForNotifications'])
    // ->name('notifications.check');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notification.index');


});

require __DIR__.'/auth.php';
