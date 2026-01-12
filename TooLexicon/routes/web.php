<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

// 初期画面を検索一覧に
Route::get('/', function () {
    return redirect()->route('tools.index');
});

// ゲスト一覧閲覧
Route::get('/tools', [ToolController::class, 'index'])->name('tools.index');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('tools.index');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 工具データ操作
    Route::get('/tools/create', [ToolController::class, 'create'])->name('tools.create');
    Route::post('/tools', [ToolController::class, 'store'])->name('tools.store');
    Route::get('/tools/{tool}/edit', [ToolController::class, 'edit'])->name('tools.edit');
    Route::patch('/tools/{tool}', [ToolController::class, 'update'])->name('tools.update');
    Route::delete('/tools/{tool}', [ToolController::class, 'destroy'])->name('tools.destroy');
});

// ゲスト詳細閲覧
Route::get('/tools/{tool}', [ToolController::class, 'show'])->name('tools.show');

require __DIR__.'/auth.php';
