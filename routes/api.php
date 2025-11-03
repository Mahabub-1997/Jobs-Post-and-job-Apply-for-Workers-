<?php

use App\Http\Controllers\API\JobApplyApi\TradeApplicationController;
use App\Http\Controllers\API\JobPostApi\JobPostApiController;
use App\Http\Controllers\API\JobReviewtApi\ReviewController;
use App\Http\Controllers\API\PrivacyApi\PrivacyPolicyApiController;
use App\Http\Controllers\API\Subscription\SubscriptionController;
use App\Http\Controllers\API\TermApi\TermApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Profile\UserProfileController;
use App\Http\Controllers\API\CMS\ContactUs\ContactUsController;
use App\Http\Controllers\API\CMS\ContactImage\ContactImageApiController;
use App\Http\Controllers\API\CMS\AboutUs\AboutUsBanner\AboutUsBannerController;
use App\Http\Controllers\API\CMS\AboutUs\AboutUsChooseUs\AboutUsChooseUsController;
use App\Http\Controllers\API\CMS\AboutUs\AboutUsGoal\AboutUsGoalController;
use App\Http\Controllers\API\CMS\AboutUs\AboutUsTestimonial\AboutUsTestimonialController;
use App\Http\Controllers\API\CMS\AboutUs\AboutUsValue\AboutUsValueController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group.
|
*/

/** ----------------- Auth Routes ----------------- */
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

// Password reset flow
    Route::post('password/forgot', [AuthController::class, 'sendOtp']);
    Route::post('password/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('password/reset', [AuthController::class, 'resetPassword']);

// Authenticated routes for logout
    Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

/** ----------------- Profile Routes ----------------- */
    Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show']);
    Route::post('/profile/update', [UserProfileController::class, 'update']);
});

/** ----------------- Contact Us Routes ----------------- */
   Route::get('/contact-us', [ContactUsController::class, 'index']);
   Route::post('/contact-us', [ContactUsController::class, 'store']);
   Route::get('/contact-images', [ContactImageApiController::class, 'index']);

/** ----------------- About Us CMS Routes ----------------- */

// Banner
   Route::get('about-us-banners', [AboutUsBannerController::class, 'index']);
   Route::post('about-us-banners', [AboutUsBannerController::class, 'store']);

// Goals
   Route::get('about-us-goals', [AboutUsGoalController::class, 'index']);
   Route::post('about-us-goals', [AboutUsGoalController::class, 'store']);

// Values
    Route::get('about-us-values', [AboutUsValueController::class, 'index']);
    Route::post('about-us-values', [AboutUsValueController::class, 'store']);

// "Choose Us" Section
    Route::get('about-us-choose-us', [AboutUsChooseUsController::class, 'index']);
    Route::post('about-us-choose-us', [AboutUsChooseUsController::class, 'store']);

// Testimonials
    Route::get('about-us-testimonials', [AboutUsTestimonialController::class, 'index']);
    Route::post('about-us-testimonials', [AboutUsTestimonialController::class, 'store']);


    Route::get('/job-posts', [JobPostApiController::class, 'apiIndex']);
    Route::get('/job-posts/{id}', [JobPostApiController::class, 'apiShow']);

/** ----------------- Test / User Info ----------------- */
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
     return $request->user();
});

/** ----------------- subscriptions ----------------- */
    Route::middleware('auth:api')->group(function () {
    Route::post('/subscriptions', [SubscriptionController::class, 'store']);
});

/** ----------------- JobApply ----------------- */

    Route::middleware('auth:api')->group(function() {
    Route::get('/trade-applications', [TradeApplicationController::class, 'index']);
    Route::post('/trade-applications', [TradeApplicationController::class, 'store']);

});
/** ----------------- JobPost, User post Review ----------------- */
    Route::middleware('auth:api')->group(function () {
    Route::post('job-posts/{id}/review', [ReviewController::class, 'addReview']);
    Route::get('job-posts/{id}/reviews', [ReviewController::class, 'listReviews']);
    });
/** ----------------- Terms and Conditions Api ----------------- */
    Route::get('/terms', [TermApiController::class, 'index']);
    Route::get('/terms/{id}', [TermApiController::class, 'show']);

/** ----------------- Privacy and Policy  Api ----------------- */
   Route::get('/privacy-policies', [PrivacyPolicyApiController::class, 'index']);
   Route::get('/privacy-policies/{policy}', [PrivacyPolicyApiController::class, 'show']);

