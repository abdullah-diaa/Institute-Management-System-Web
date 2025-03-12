<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YoutubeVideoController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SettingsController;

// Public routes
Route::view('/about', 'about')->name('about');
Route::view('/location', 'location')->name('location');
Route::view('/contact', 'contact')->name('contact');

// YouTube Video and Playlist Routes
Route::resource('playlists', PlaylistController::class)->only(['index', 'show']);
Route::resource('youtube_videos', YoutubeVideoController::class)->only(['index', 'show']);

// Posts, Assignments, and Courses Routes
Route::resource('posts', PostController::class)->only(['index', 'show']);
Route::resource('assignments', AssignmentController::class)->only(['index', 'show']);
Route::resource('courses', CourseController::class)->only(['index', 'show']);

// Subscription Routes
Route::resource('subscriptions', SubscriptionController::class)->only(['index', 'show', 'store']);

// Profile Routes
Route::resource('profiles', ProfileController::class)->only(['index', 'show']);

// Settings Routes
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::put('/settings/profile-info', [SettingsController::class, 'updateProfileInfo'])->name('settings.profile_info.update');
Route::put('/settings/profile-info/gender', [SettingsController::class, 'updateGender'])->name('settings.profile_info.update_gender');
Route::put('/settings/profile-picture', [SettingsController::class, 'updateProfilePicture'])->name('settings.profile.picture.update');

// Authentication Routes (login, logout)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Routes (for enrolled courses, etc.)
Route::resource('users', UserController::class)->only(['index', 'show']);
Route::post('/users/{user}/enroll', [UserController::class, 'enrollStore'])->name('users.enroll.store');
Route::put('/users/{user}/update-enroll', [UserController::class, 'updateEnrollment'])->name('users.update-enroll');

// Answers for assignments
Route::post('/assignments/{assignment}/upload', [AnswerController::class, 'store'])->name('answers.store');

// Increment post views
Route::post('/posts/{post}/increment-view', [PostController::class, 'incrementView'])->name('posts.increment-view');

