<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CourseController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YoutubeVideoController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SettingsController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/







Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::get('/settings/name', [SettingsController::class, 'editName'])->name('settings.name.edit');
Route::put('/settings/name', [SettingsController::class, 'updateName'])->name('settings.name.update');

Route::get('/settings/profile-info', [SettingsController::class, 'profileInfo'])->name('settings.profile.info.edit');
Route::put('/settings/profile-info', [SettingsController::class, 'updateProfileInfo'])->name('settings.profile_info.update');
Route::put('/settings/profile-info/gender', [SettingsController::class, 'updateGender'])->name('settings.profile_info.update_gender');




Route::get('/settings/phone-number', [SettingsController::class, 'editPhoneNumber'])->name('settings.phone.number.edit');
Route::put('/settings/phone-number', [SettingsController::class, 'updatePhoneNumber'])->name('settings.phone.number.update');





Route::get('/settings/password-reset', [SettingsController::class, 'editPasswordReset'])->name('settings.password.reset');

// Route for handling the password update
Route::put('/settings/password-reset', [SettingsController::class, 'changePassword'])->name('settings.password.update');




Route::get('/settings/profile-picture', [SettingsController::class, 'editProfilePicture'])->name('settings.profile.picture');
Route::put('/settings/profile-picture', [SettingsController::class, 'updateProfilePicture'])->name('settings.profile.picture.update');



    
   
    Route::view('/about', 'about')->name('about');

Route::view('/location', 'location')->name('location');

Route::view('/contact', 'contact')->name('contact');

Route::get('/videos/search', [YoutubeVideoController::class, 'search'])->name('videos.search');
Route::resource('playlists', PlaylistController::class);
Route::resource('youtube_videos', YoutubeVideoController::class);


Route::post('/posts/{post}/increment-view', [PostController::class, 'incrementView']);




// Route::get('users/{user}/enroll', [UserController::class, 'enroll'])->name('users.enroll');
// Route::post('users/{user}/enroll', [UserController::class, 'enrollStore'])->name('users.enroll.store');








/*
Route::middleware('auth.redirect')->group(function () {*/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');





 
  


  
  
  Route::resource('enrollments', EnrollmentController::class);
  

  /*->except(['index']);*/
  /*
Route::middleware(AdminMiddleware::class)->group(function () {
  
  
  Route::get('/profiles', [ProfileController::class, 'index']);
  

  
});
*/




Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/student/login', [AuthController::class, 'studentLogin']);





Route::group(['middleware' => 'admin'], function () {
    //  all the users routes
        Route::resource('users', UserController::class);
    
    // [These are routes for User for enrolling users with courses except]-------------------------------------------------------------------------------------------------------
        Route::get('/users/{user}/create-enroll', [UserController::class, 'createEnrollment'])->name('users.create-enroll');
        Route::get('users/{user}/edit-enroll', [UserController::class, 'editEnroll'])->name('users.edit-enroll');
        Route::post('/users/{user}/store-enroll', [UserController::class, 'storeEnrollment'])->name('users.store-enroll');
        Route::put('/users/{user}/update-enroll', [UserController::class, 'updateEnrollment'])->name('users.update-enroll');
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
 





    
    // Define resource routes all profiles methods  excluding 'create' and 'store' and 'show'
    Route::resource('profiles', ProfileController::class)->except(['create', 'store','show']);
    
    
    // [These are routes for Subscription except (index & create & store & edit & update & destroy )]-------------------------------------------------------------------------------------------------------
    Route::get('/subscriptions/successful', [SubscriptionController::class, 'successfulSubscriptions'])->name('subscriptions.successful');
    Route::get('/subscriptions/failed', [SubscriptionController::class, 'failedSubscriptions'])->name('subscriptions.failed');
    Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------------
    


    
    //[These are routes for Post except (index)]------------------------------------------------------------------------------------------------
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete(('/posts/{post}'), [PostController::class,'destroy'])->name('posts.destory');
    //---------------------------------------------------------------------------------------------------------------------------------------------------------







    //[These are routes for Assignment except (index)]--------------------------------------------------------------------------------------------------
    Route::get('assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    //------------------------------------------------------------------------------------------------------------------------------------------------------------




   // [These are routes for Youtube_videos except (index)]----------------------------------------------------------------------------------------
    Route::get('/videos/search', [YoutubeVideoController::class, 'search'])->name('videos.search');
    Route::get('youtube_videos/create', [YoutubeVideoController::class, 'create'])->name('youtube_videos.create');
    Route::post('youtube_videos', [YoutubeVideoController::class, 'store'])->name('youtube_videos.store');
    Route::get('youtube_videos/{video}/edit', [YoutubeVideoController::class, 'edit'])->name('youtube_videos.edit');
    Route::put('youtube_videos/{video}', [YoutubeVideoController::class, 'update'])->name('youtube_videos.update');
    Route::delete('/youtube_videos/{video}', [YoutubeVideoController::class, 'destroy'])->name('youtube_videos.destroy');
   //----------------------------------------------------------------------------------------------------------------------------------------------




     // [These are routes for Playlist except (index & show)]----------------------------------------------------------------------------------------

    Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
    Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
    Route::get('/playlists/{playlist}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
    Route::put('/playlists/{playlist}', [PlaylistController::class, 'update'])->name('playlists.update');
    Route::delete('/playlists/{playlist}', [PlaylistController::class, 'destroy'])->name('playlists.destroy');

    //----------------------------------------------------------------------------------------------------------------------------------------------
   
   
   
   
   
    // [These are routes for Answer except (create & store)]----------------------------------------------------------------------------------------
   
    Route::get('/assignments/{assignment}/answers', 'App\Http\Controllers\AnswerController@index')->name('answers.index');
    Route::delete('/assignments/{assignment}/answers/{answer}', 'App\Http\Controllers\AnswerController@destroy')->name('answers.destroy');

//----------------------------------------------------------------------------------------------------------------------------------------------




 // [These are routes for Course except (create & store)]----------------------------------------------------------------------------------------

Route::get('courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::post('courses', [CourseController::class, 'store'])->name('courses.store');
Route::get('courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
Route::put('courses/{course}', [CourseController::class, 'update'])->name('courses.update');
Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

//----------------------------------------------------------------------------------------------------------------------------------------------


    });
    
    

Route::group(['middleware' => 'auth'], function () {




   //[For Profiles / create & store methods] ------------------------------------------------------------------------------------------------------------
Route::get('profiles/create', [ProfileController::class, 'create'])->name('profiles.create');
Route::post('profiles', [ProfileController::class, 'store'])->name('profiles.store');
// --------------------------------------------------------------------------------------------------------------------------------



// [index & create & store & edit & update & destroy methods for Subscription]---------------------------------------------------------------------------------------------------
Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
Route::get('/courses/{course}/subscribe', [SubscriptionController::class, 'create'])->name('subscriptions.create');
Route::post('/courses/{course}/subscribe', [SubscriptionController::class, 'store'])->name('subscriptions.store');
Route::get('/subscriptions/{subscription}/edit', [SubscriptionController::class, 'edit'])->name('subscriptions.edit');
Route::put('/subscriptions/{subscription}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
   
//-----------------------------------------------------------------------------------------------------------------------------------------------

//[index method for Assignment]----------------------------------------------------------------------------------------------

Route::get('assignments', [AssignmentController::class,'index'])->name('assignments.index');
//--------------------------------------------------------------------------------------------------------------------------



//[(create and store ) methods for Answer]----------------------------------------------------------------------------------------------

Route::get('/assignments/{assignment}/upload', 'App\Http\Controllers\AnswerController@create')->name('answers.create');
Route::post('/assignments/{assignment}/upload', 'App\Http\Controllers\AnswerController@store')->name('answers.store');

//--------------------------------------------------------------------------------------------------------------------------

});




 //[For Profile /show method] ------------------------------------------------------------------------------------------------------------

 Route::get('/profiles/{profile}', [ProfileController::class, 'show'])->name('profiles.show');
 //-----------------------------------------------------------------------------------------------------------------------------
 

 //[For Posts (All methods exclude ['create','store','edit','update'] )] ------------------------------------------------------------------------------------------------------------

 Route::resource('posts', PostController::class)->except(['create','store','edit','update']);



 //[For YoutubeVideo /index method] ------------------------------------------------------------------------------------------------------------

Route::get('youtube_videos', [YoutubeVideoController::class,'index'])->name('youtube_videos.index');
//-------------------------------------------------------------------------------------------------------------------------------------





//[For Playlist /index & show  methods] ------------------------------------------------------------------------------------------------------------

Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
Route::get('/playlists/{id}', [PlaylistController::class, 'show'])->name('playlists.show');

//------------------------------------------------------------------------------------------------------------------------------------------------------




//[For Course /index & show  methods] ------------------------------------------------------------------------------------------------------------


Route::get('courses', [CourseController::class,'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

//------------------------------------------------------------------------------------------------------------------------------------------------------
Route::post('/logout', function (Request $request) {
    Auth::logout();
    session()->invalidate();   // Use session() helper
    session()->regenerateToken();   // Regenerate CSRF token

    return redirect()->route('login');
})->name('logout');
