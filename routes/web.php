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
use App\Http\Controllers\DashboardController;
use App\Livewire\Dashboards\AdminDashboard;
use App\Livewire\Dashboards\SalesDashboard;
use App\Livewire\Dashboards\FinanceDashboard;
use App\Livewire\Dashboards\PurchasingDashboard;
use App\Livewire\Dashboards\TechnicianDashboard;
use App\Livewire\Dashboards\PlannerDashboard;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Afdelingsroutes (beschermd met auth en departmentRole) - Using Livewire components for real-time updates
Route::get('sales', SalesDashboard::class)->middleware(['auth', 'departmentRole:Sales'])->name('sales');
Route::get('purchasing', PurchasingDashboard::class)->middleware(['auth', 'departmentRole:Purchasing'])->name('purchasing');
Route::get('finance', FinanceDashboard::class)->middleware(['auth', 'departmentRole:Finance'])->name('finance');
Route::get('technician', TechnicianDashboard::class)->middleware(['auth', 'departmentRole:Technician'])->name('technician');
Route::get('planner', PlannerDashboard::class)->middleware(['auth', 'departmentRole:Planner'])->name('planner');
Route::get('admin', AdminDashboard::class)->middleware(['auth', 'departmentRole:Management'])->name('management');

// Sales Department
Route::middleware(['auth', 'departmentRole:Sales'])->group(function () {
    Route::get('sales', SalesDashboard::class)->name('sales.dashboard');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'goToEdit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'edit'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
});



Route::get('purchasing', PurchasingDashboard::class)->middleware(['auth', 'departmentRole:Purchasing'])->name('purchasing.dashboard');
Route::get('finance', FinanceDashboard::class)->middleware(['auth', 'departmentRole:Finance'])->name('finance.dashboard');
Route::get('technician', TechnicianDashboard::class)->middleware(['auth', 'departmentRole:Technician'])->name('technician.dashboard');
Route::get('planner', PlannerDashboard::class)->middleware(['auth', 'departmentRole:Planner'])->name('planner.dashboard');

// Technician - Onderhoud routes
Route::get('/technician/planning', [MaintenanceController::class, 'planning'])->middleware('auth')->name('technician.planning');
Route::get('/technician/onderhoud/{id}', [MaintenanceController::class, 'show'])->middleware('auth')->name('technician.onderhoud.show');
Route::get('/technician/onderhoud/{id}/rapport', [MaintenanceController::class, 'rapport'])->middleware('auth')->name('technician.onderhoud.rapport');
Route::post('/technician/onderhoud/{id}/rapport', [MaintenanceController::class, 'updateRapport'])->middleware('auth')->name('technician.onderhoud.rapport.update');

// Planner - Ticket systeem
Route::get('/planner/tickets', [TicketController::class, 'index'])->middleware('auth')->name('planner.tickets.index');
Route::get('/planner/tickets/create', [TicketController::class, 'create'])->middleware('auth')->name('planner.tickets.create');
Route::post('/planner/tickets', [TicketController::class, 'store'])->middleware('auth')->name('planner.tickets.store');
Route::get('/planner/tickets/{id}/edit', [TicketController::class, 'edit'])->middleware('auth')->name('planner.tickets.edit');
Route::put('/planner/tickets/{id}', [TicketController::class, 'update'])->middleware('auth')->name('planner.tickets.update');
Route::get('/planner/tickets/{id}', [TicketController::class, 'show'])->middleware('auth')->name('planner.tickets.show');
Route::delete('/planner/tickets/{id}', [TicketController::class, 'destroy'])->middleware('auth')->name('planner.tickets.destroy');

// Contract routes - alleen voor Finance en Admin
Route::get('/contracts', [ContractController::class, 'index'])->middleware('auth')->name('contracts.index');
Route::get('/contracts/create', [ContractController::class, 'create'])->middleware('auth')->name('contracts.create');
Route::post('/contracts', [ContractController::class, 'store'])->middleware('auth')->name('contracts.store');
Route::get('/contracts/{id}', [ContractController::class, 'show'])->middleware('auth')->name('contracts.show');
Route::get('/contracts/{id}/pdf', [ContractController::class, 'downloadPdf'])->middleware('auth')->name('contracts.pdf');

// Offerte routes - alleen voor Sales en Management
Route::middleware(['auth', 'departmentRole:Sales'])->group(function () {
    Route::get('/offertes', [OfferteController::class, 'index'])->name('offertes.index');
    Route::get('/offertes/create', [OfferteController::class, 'create'])->name('offertes.create');
    Route::post('/offertes', [OfferteController::class, 'store'])->name('offertes.store');
    Route::get('/offertes/{id}', [OfferteController::class, 'show'])->name('offertes.show');
    Route::get('/offertes/{id}/edit', [OfferteController::class, 'edit'])->name('offertes.edit');
    Route::put('/offertes/{id}', [OfferteController::class, 'update'])->name('offertes.update');
    Route::post('/offertes/{id}/send', [OfferteController::class, 'sendToCustomer'])->name('offertes.send');
    Route::get('/offertes/{id}/pdf', [OfferteController::class, 'downloadPdf'])->name('offertes.pdf');
    Route::get('/algemene-voorwaarden/pdf', [OfferteController::class, 'downloadTermsPdf'])->name('general-terms.pdf');
});


// Factuur routes - alleen voor Finance en Management
Route::get('/facturen', [FactuurController::class, 'index'])->middleware('auth')->name('facturen.index');
Route::get('/facturen/create', [FactuurController::class, 'create'])->middleware('auth')->name('facturen.create');
Route::post('/facturen', [FactuurController::class, 'store'])->middleware('auth')->name('facturen.store');
Route::get('/facturen/{id}/edit', [FactuurController::class, 'edit'])->middleware('auth')->name('facturen.edit');
Route::put('/facturen/{id}', [FactuurController::class, 'update'])->middleware('auth')->name('facturen.update');
Route::get('/facturen/{id}/send', [FactuurController::class, 'send'])->middleware('auth')->name('facturen.send');
Route::post('/facturen/{id}/send', [FactuurController::class, 'sendEmail'])->middleware('auth')->name('facturen.sendEmail');
Route::get('/facturen/{id}/pdf', [FactuurController::class, 'downloadPdf'])->middleware('auth')->name('facturen.pdf');
// Management - Rollen beheer
Route::middleware(['auth', 'departmentRole:Management'])->group(function () {
    Route::get('/management/roles', [RoleController::class, 'index'])->name('management.roles.index');

    // Management - Gebruikersbeheer
    Route::get('/management/users', [UserManagementController::class, 'index'])->name('management.users.index');
    Route::get('/management/users/create', [UserManagementController::class, 'create'])->name('management.users.create');
    Route::post('/management/users', [UserManagementController::class, 'store'])->name('management.users.store');
    Route::get('/management/users/{id}/edit', [UserManagementController::class, 'edit'])->name('management.users.edit');
    Route::put('/management/users/{id}', [UserManagementController::class, 'update'])->name('management.users.update');
    Route::get('/management/users/export', [UserManagementController::class, 'export'])->name('management.users.export');
    Route::post('/management/users/import', [UserManagementController::class, 'import'])->middleware('throttle:5,1')->name('management.users.import');
    Route::delete('/management/users/{id}', [UserManagementController::class, 'destroy'])->name('management.users.destroy');
});

//Purchasing Department
Route::get('/product-stock', [ProductController::class, 'showStock'])->middleware('auth')->name('product.stock');
Route::get('/products/create', [ProductController::class, 'create'])->middleware('auth')->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->middleware('auth')->name('products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->middleware('auth')->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('auth')->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('auth')->name('products.destroy');
// Product ordering (bestellen)
Route::get('/products/order', [ProductController::class, 'orderForm'])->middleware('auth')->name('products.order');
Route::post('/products/order', [ProductController::class, 'order'])->middleware('auth')->name('products.order.store');
// Backlog / bestellingen overzicht
Route::get('/orders/logistics', [ProductController::class, 'orderLogistics'])->middleware('auth')->name('orders.logistics');


// Geen afdeling
Route::view('none', 'none')->middleware('auth')->name('none');



Route::get('dashboard', AdminDashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('admin/dashboard', AdminDashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

Route::get('admin/sales', SalesDashboard::class)
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
