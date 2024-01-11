<?php

use App\Http\Controllers\LeadController;
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
    return redirect('api/documentation');
});

/*Route::get('/leads', [LeadController::class, 'index'])->name('web.leads.index');
Route::get('/leads/create', [LeadController::class, 'create'])->name('web.leads.create');
Route::post('/leads', [LeadController::class, 'store'])->name('web.leads.store');
Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('web.leads.show');
Route::get('/leads/{lead}/edit', [LeadController::class, 'edit'])->name('web.leads.edit');
Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('web.leads.update');
Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('web.leads.destroy');*/