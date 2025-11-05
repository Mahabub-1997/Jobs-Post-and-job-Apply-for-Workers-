<?php

use App\Http\Controllers\Web\Category\CategoryController;
use App\Http\Controllers\Web\CMS\PrivacyPolicy\PrivacyPolicyController;
use App\Http\Controllers\Web\CMS\TermsAndConditions\TermController;
use App\Http\Controllers\Web\JobApplication\AdminJobApplicationController;
use App\Http\Controllers\Web\JobApply\JobApplyController;
use App\Http\Controllers\Web\JobPost\JobPostController;
use App\Http\Controllers\Web\Question\QuestionController;
use App\Http\Controllers\Web\QuestionOptions\QuestionOptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\CMS\ContactUs\ContactUsController;
use App\Http\Controllers\Web\CMS\ContactUs\ContactImageController;
use App\Http\Controllers\Web\Permission\PermissionController;
use App\Http\Controllers\Web\Roles\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "web" middleware group.
|
*/

/** ----------------- Public Routes ----------------- */
// Welcome Page
    Route::get('/', function () {
      return view('welcome');
});
/** ----------------- Terms and Conditions ----------------- */
    Route::prefix('admin')->group(function () {
    Route::get('/terms', [TermController::class, 'index'])->name('terms.index');
    Route::get('/terms/create', [TermController::class, 'create'])->name('terms.create');
    Route::get('/terms/{id}/edit', [TermController::class, 'edit'])->name('terms.edit');
    Route::get('/terms/{id}', [TermController::class, 'show'])->name('terms.show');
    Route::post('/terms', [TermController::class, 'store'])->name('terms.store');
    Route::put('/terms/{id}', [TermController::class, 'update'])->name('terms.update');
    Route::delete('/terms/{id}', [TermController::class, 'destroy'])->name('terms.destroy');
});
/** ----------------- Privacy and Policy  ----------------- */
Route::prefix('admin')->group(function () {
    Route::get('/privacy-policies', [PrivacyPolicyController::class, 'index'])->name('privacy.index');
    Route::get('/privacy-policies/create', [PrivacyPolicyController::class, 'create'])->name('privacy.create');
    Route::post('/privacy-policies', [PrivacyPolicyController::class, 'store'])->name('privacy.store');
    Route::get('/privacy-policies/{id}/edit', [PrivacyPolicyController::class, 'edit'])->name('privacy.edit');
    Route::put('/privacy-policies/{id}', [PrivacyPolicyController::class, 'update'])->name('privacy.update');
    Route::delete('/privacy-policies/{id}', [PrivacyPolicyController::class, 'destroy'])->name('privacy.destroy');
});

// Contact Us Pages
     Route::get('contact-us', [ContactUsController::class, 'index'])->name('contact.index');
     Route::get('contact-us/{id}', [ContactUsController::class, 'show'])->name('contact.show');
     Route::delete('contact-us/{id}', [ContactUsController::class, 'destroy'])->name('contact.destroy');

// Contact Images
     Route::get('/contact-images', [ContactImageController::class, 'index'])->name('web-contact-images.index');
     Route::post('/contact-images', [ContactImageController::class, 'store'])->name('web-contact-images.store');
     Route::delete('/contact-images/{id}', [ContactImageController::class, 'destroy'])->name('web-contact-images.destroy');

/** ----------------- Dashboard Routes ----------------- */
      Route::get('/dashboard', function () {
         return view('backend.layouts.dashboard');
      })->middleware(['auth', 'verified'])->name('dashboard');

// User-Specific Dashboards
       Route::get('/homeowner/dashboard', [DashboardController::class, 'index'])->name('homeowner.dashboard');
       Route::get('/tradesperson/dashboard', [DashboardController::class, 'dashboard'])->name('tradesperson.dashboard');

       /** ----------------- Authenticated Routes ----------------- */
       Route::middleware('auth')->group(function () {

        /** ----- Profile Management ----- */
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        /** ----- Permissions & Roles (Admin Only) ----- */
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RoleController::class)->middleware('role:admin');
});

       /** ----- JobPost(Admin + Homeowner) ----- */
        Route::prefix('admin')->middleware(['auth', 'role:admin|homeowner'])->group(function () {
        /** ----- Categories CRUD  ----- */
        Route::resource('categories', CategoryController::class);
        /** ----- Questions CRUD ----- */
        Route::resource('questions', QuestionController::class);
        /** ----- Question Options CRUD ----- */
        Route::resource('question-options', QuestionOptionController::class);
        /** ----- job_posts  CRUD ----- */
        Route::resource('job_posts', JobPostController::class);
});

        /** ----------------- Job Apply list----------------- */
            Route::middleware(['role:admin|tradesperson'])->group(function() {
            Route::get('/job-registration', [JobApplyController::class, 'registration'])
                ->name('job-registration.index');



            Route::post('/job-registration/{id}/enroll', [JobApplyController::class, 'enroll'])
                ->name('job_posts.enroll');
});

           /** ----------------- Job Apply list----------------- */
            Route::patch('/job-apply/{id}/status', [JobApplyController::class, 'updateStatus'])->name('job-apply.status');
            Route::get('/job-apply', [JobApplyController::class, 'index'])->name('job-apply.index');



            Route::middleware(['auth','role:admin'])->group(function() {
            Route::get('/admin/job-applications', [AdminJobApplicationController::class, 'index'])
            ->name('admin.job_applications.index');
            Route::post('/admin/job-application/{id}/status', [AdminJobApplicationController::class, 'updateStatus'])
            ->name('admin.job_applications.update_status');
});

/** ----------------- Authentication Routes ----------------- */
         require __DIR__.'/auth.php';


