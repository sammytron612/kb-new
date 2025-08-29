<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\AdminController;
use App\Livewire\ArticleSearch;
use App\Http\Controllers\DraftsController;
use App\Http\Controllers\ArticleController;
use App\Models\Article;



Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/', [ArticleController::class, 'index'])->middleware(['verified'])->name('home');;
    Route::get('dashboard', [ArticleController::class, 'index'])->middleware(['verified'])->name('dashboard');

    Route::get('search', ArticleSearch::class)->name('search');

    Route::post('/upload-image', [\App\Http\Controllers\ImageUploadController::class, 'store'])->name('image.upload');
    Route::get('article/{article}/attachment/', [ArticleController::class, 'downloadAttachments'])
        ->name('attachment.download');

    Route::get('/drafts', [DraftsController::class, 'index'])->name('drafts');
    Route::get('/stats', [\App\Http\Controllers\StatsController::class, 'index'])->name('stats');
    Route::get('/sections', [\App\Http\Controllers\SectionsController::class, 'index'])->name('sections.index')->middleware('can:canCreate');
    Route::post('/sections', [\App\Http\Controllers\SectionsController::class, 'store'])->name('sections.store')->middleware('can:canCreate');

    Route::resource('article', ArticleController::class);
});


////////// ADMIN ROUTES /////////

Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    Route::view('/admin/users', 'admin.users')->name('admin.users');
    Route::view('/admin', 'admin.index')->name('admin');
    Route::view('/admin/invites', 'admin.invites')->name('admin.invites');
    Route::post('/admin/invites/send', [\App\Http\Controllers\InviteController::class, 'send'])->name('admin.invites.send');

    Route::get('/admin/approvals', function() {
        $articles = Article::where('approved', 0)->get();
        return view('admin.approvals', compact('articles'));
    })->name('admin.approvals');

    Route::view('/admin/settings', 'admin.settings')->name('admin.settings');
    Route::get('/admin/approvals/{id}', [\App\Http\Controllers\ApprovalsController::class, 'index'])->name('approvals.show');
    Route::post('/admin/approvals/{id}/approve', [\App\Http\Controllers\ApprovalsController::class, 'approve'])->name('approvals.approve');
    Route::post('/admin/approvals/{id}/reject', [\App\Http\Controllers\ApprovalsController::class, 'reject'])->name('approvals.reject');
});

//////// EXTERNAL ROUTES /////////

Route::get('/external/{article}/shared', [\App\Http\Controllers\ArticleController::class, 'shared'])
    ->name('articles.shared')
    ->middleware('signed');

Route::get('/api/articles/most-viewed', [\App\Http\Controllers\Api\ArticleStatsController::class, 'mostViewed']);


require __DIR__.'/auth.php';
