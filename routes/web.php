<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FactuurController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\OfferteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Afdelingsroutes (beschermd met auth en departmentRole)
Route::view('sales', 'sales.dashboard')->middleware(['auth', 'departmentRole:Sales'])->name('sales');
Route::view('purchasing', 'purchasing.dashboard')->middleware(['auth', 'departmentRole:Purchasing'])->name('purchasing');
Route::view('finance', 'finance.dashboard')->middleware(['auth', 'departmentRole:Finance'])->name('finance');
Route::view('technician', 'technician.dashboard')->middleware(['auth', 'departmentRole:Technician'])->name('technician');
Route::view('planner', 'planner.dashboard')->middleware(['auth', 'departmentRole:Planner'])->name('planner');
Route::view('admin', 'admin.dashboard')->middleware(['auth', 'departmentRole:Management'])->name('management');

// Sales Department
Route::middleware(['auth', 'departmentRole:Sales'])->group(function () {
    Route::view('sales', 'sales.dashboard')->name('sales.dashboard');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'goToEdit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'edit'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
});


Route::view('purchasing', 'purchasing.dashboard')->middleware(['auth', 'departmentRole:Purchasing'])->name('purchasing.dashboard');
Route::view('finance', 'finance.dashboard')->middleware(['auth', 'departmentRole:Finance'])->name('finance.dashboard');
Route::view('technician', 'technician.dashboard')->middleware(['auth', 'departmentRole:Technician'])->name('technician.dashboard');
Route::view('planner', 'planner.dashboard')->middleware(['auth', 'departmentRole:Planner'])->name('planner.dashboard');

// Technician - Onderhoud routes
Route::middleware(['auth', 'departmentRole:Technician'])->group(function () {
    Route::get('/technician/planning', [MaintenanceController::class, 'planning'])->name('technician.planning');
    Route::get('/technician/onderhoud/{id}', [MaintenanceController::class, 'show'])->name('technician.onderhoud.show');
    Route::get('/technician/onderhoud/{id}/rapport', [MaintenanceController::class, 'rapport'])->name('technician.onderhoud.rapport');
    Route::post('/technician/onderhoud/{id}/rapport', [MaintenanceController::class, 'updateRapport'])->name('technician.onderhoud.rapport.update');
});

// Planner - Ticket systeem
Route::middleware(['auth', 'departmentRole:Planner'])->group(function () {
    Route::get('/planner/tickets', [TicketController::class, 'index'])->name('planner.tickets.index');
    Route::get('/planner/tickets/create', [TicketController::class, 'create'])->name('planner.tickets.create');
    Route::post('/planner/tickets', [TicketController::class, 'store'])->name('planner.tickets.store');
    Route::get('/planner/tickets/{id}', [TicketController::class, 'show'])->name('planner.tickets.show');
});

// Contract routes - alleen voor Finance en Admin
Route::middleware(['auth', 'departmentRole:Finance'])->group(function () {
    Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
    Route::get('/contracts/{id}', [ContractController::class, 'show'])->name('contracts.show');
    Route::get('/contracts/{id}/pdf', [ContractController::class, 'downloadPdf'])->name('contracts.pdf');
});

// Offerte routes - alleen voor Sales en Management
Route::middleware(['auth', 'departmentRole:Sales'])->group(function () {
    Route::get('/offertes', [OfferteController::class, 'index'])->name('offertes.index');
    Route::get('/offertes/create', [OfferteController::class, 'create'])->name('offertes.create');
    Route::post('/offertes', [OfferteController::class, 'store'])->name('offertes.store');
    Route::get('/offertes/{id}', [OfferteController::class, 'show'])->name('offertes.show');
    Route::get('/offertes/{id}/edit', [OfferteController::class, 'edit'])->name('offertes.edit');
    Route::put('/offertes/{id}', [OfferteController::class, 'update'])->name('offertes.update');
    Route::get('/offertes/{id}/pdf', [OfferteController::class, 'downloadPdf'])->name('offertes.pdf');
});


// Factuur routes - alleen voor Finance en Management
Route::middleware(['auth', 'departmentRole:Finance'])->group(function () {
    Route::get('/facturen', [FactuurController::class, 'index'])->name('facturen.index');
    Route::get('/facturen/create', [FactuurController::class, 'create'])->name('facturen.create');
    Route::post('/facturen', [FactuurController::class, 'store'])->name('facturen.store');
    Route::get('/facturen/{id}/edit', [FactuurController::class, 'edit'])->name('facturen.edit');
    Route::put('/facturen/{id}', [FactuurController::class, 'update'])->name('facturen.update');
    Route::get('/facturen/{id}/send', [FactuurController::class, 'send'])->name('facturen.send');
    Route::post('/facturen/{id}/send', [FactuurController::class, 'sendEmail'])->name('facturen.sendEmail');
    Route::get('/facturen/{id}/pdf', [FactuurController::class, 'downloadPdf'])->name('facturen.pdf');
});

// Management - Rollen beheer
Route::middleware(['auth', 'departmentRole:Management'])->group(function () {
    Route::get('/management/roles', [RoleController::class, 'index'])->name('management.roles.index');
    
    // Management - Gebruikersbeheer
    Route::get('/management/users', [UserManagementController::class, 'index'])->name('management.users.index');
    Route::get('/management/users/create', [UserManagementController::class, 'create'])->name('management.users.create');
    Route::post('/management/users', [UserManagementController::class, 'store'])->name('management.users.store');
    Route::get('/management/users/{id}/edit', [UserManagementController::class, 'edit'])->name('management.users.edit');
    Route::put('/management/users/{id}', [UserManagementController::class, 'update'])->name('management.users.update');
    Route::delete('/management/users/{id}', [UserManagementController::class, 'destroy'])->name('management.users.destroy');
});

//Purchasing Department
Route::get('/product-stock', [ProductController::class, 'showStock'])->middleware('auth')->name('product.stock');
Route::get('/products/create', [ProductController::class, 'create'])->middleware('auth')->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->middleware('auth')->name('products.store');
// Product ordering (bestellen)
Route::get('/products/order', [ProductController::class, 'orderForm'])->middleware('auth')->name('products.order');
Route::post('/products/order', [ProductController::class, 'order'])->middleware('auth')->name('products.order.store');
// Backlog / bestellingen overzicht
Route::get('/orders/logistics', [ProductController::class, 'orderLogistics'])->middleware('auth')->name('orders.logistics');


// Geen afdeling
Route::view('none', 'none')->middleware('auth')->name('none');



Route::view('dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('admin/dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

Route::view('admin/sales', 'sales.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('admin.sales.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__.'/auth.php';
