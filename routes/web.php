<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProjectController;
use App\Http\Controllers\Public\ResumeController;
use App\Http\Controllers\Public\SkillController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Facing Routes
|--------------------------------------------------------------------------
*/
Route::get('/', HomeController::class)->name('home');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/about', AboutController::class)->name('about');
Route::get('/skills', SkillController::class)->name('skills');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/resume', ResumeController::class)->name('resume.download');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Protected Admin CMS Panel Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth'])->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        // Projects Management
        Route::resource('projects', AdminProjectController::class)->except(['show']);
        Route::patch('projects/{project}/toggle-publish', [AdminProjectController::class, 'togglePublish'])->name('projects.toggle-publish');

        // Skills Management
        Route::get('skills', [AdminSkillController::class, 'index'])->name('skills.index');
        Route::post('skills', [AdminSkillController::class, 'storeSkill'])->name('skills.store');
        Route::put('skills/{skill}', [AdminSkillController::class, 'updateSkill'])->name('skills.update');
        Route::delete('skills/{skill}', [AdminSkillController::class, 'destroySkill'])->name('skills.destroy');
        Route::post('skill-categories', [AdminSkillController::class, 'storeCategory'])->name('skills.category.store');
        Route::delete('skill-categories/{category}', [AdminSkillController::class, 'destroyCategory'])->name('skills.category.destroy');

        // Inbox & Messages
        Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
        Route::patch('messages/{message}/toggle-archive', [AdminMessageController::class, 'toggleArchive'])->name('messages.toggle-archive');
        Route::delete('messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

        // Site & Bio Settings
        Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});
