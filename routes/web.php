<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;



use App\Http\Controllers\AdminController;
use App\Livewire\ArticleSearch;
use App\Http\Controllers\DraftsController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ArticleController;



Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['verified'])->name('home');;
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');

    Route::get('search', ArticleSearch::class)->name('search');
    Route::get('/admin', [AdminController::class,'index'])->name('admin');
    Route::post('/upload-image', [\App\Http\Controllers\ImageUploadController::class, 'store'])->name('image.upload');
    Route::get('article/{article}/download-attachments', [ArticleController::class, 'downloadAttachments'])->name('articles.download-attachments');
    Route::get('/drafts', [DraftsController::class, 'index'])->name('drafts');
    Route::get('/stats', [\App\Http\Controllers\StatsController::class, 'index'])->name('stats');
    Route::get('/sections', [\App\Http\Controllers\SectionsController::class, 'index'])->name('sections.index')->middleware('can:canCreate');
    Route::post('/sections', [\App\Http\Controllers\SectionsController::class, 'store'])->name('sections.store')->middleware('can:canCreate');

    Route::resource('article', ArticleController::class);
});
//Route::get('articles/{id}/edit', [\App\Http\Controllers\EditArticleController::class, 'edit'])->name('articles.edit')->middleware(['can:isAdmin'] || 'can:CanEditOrDelete');

////////// ADMIN ROUTES /////////

Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    Route::view('/admin/users', 'admin.users')->name('admin.users');

    Route::get('/admin/invites', [\App\Http\Controllers\InviteController::class, 'index'])->name('admin.invites');
    Route::post('/admin/invites/send', [\App\Http\Controllers\InviteController::class, 'send'])->name('admin.invites.send');
    Route::get('/admin/invites', [\App\Http\Controllers\AdminController::class, 'invites'])->name('admin.invites');
    Route::get('/admin/approvals', [\App\Http\Controllers\AdminController::class, 'approvals'])->name('admin.approvals');
    Route::get('/admin/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('admin.settings');
    Route::get('/admin/approvals/{id}', [\App\Http\Controllers\ApprovalsController::class, 'index'])->name('approvals.show');
    Route::post('/admin/approvals/{id}/approve', [\App\Http\Controllers\ApprovalsController::class, 'approve'])->name('approvals.approve');
    Route::post('/admin/approvals/{id}/reject', [\App\Http\Controllers\ApprovalsController::class, 'reject'])->name('approvals.reject');
});

//////// EXTERNAL ROUTES /////////

Route::get('/articles/{article}/shared', [\App\Http\Controllers\ArticleController::class, 'shared'])
    ->name('articles.shared')
    ->middleware('signed');



Route::get('/api/articles/most-viewed', [\App\Http\Controllers\Api\ArticleStatsController::class, 'mostViewed']);


require __DIR__.'/auth.php';
