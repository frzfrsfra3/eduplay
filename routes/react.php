<?php

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
//root
Route::get('/', function () {
    return view('welcome');
});
//welcome
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');
//Sign Up
Route::get('/signup', function () {
    return view('auth.signup_date');
})->name('signup');
//Sign Up2
Route::post('/signup_2', function () {
    return view('auth.signup_2');
})->name('signup_2');
//Sign Up3
Route::get('/signup_3', function () {
    return view('auth.signup_3');
})->name('signup_3');
//Sign Up3
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');
Route::get('/editor', function () {
    return view('bulkeditor');
})->name('editor');

Route::get('/api_question/{id}', 'Exercises\QuestionsController@api_question')
    ->name('questions.question.api_question')
    ->where('id', '[0-9]+');

Route::get('/api_answer/{id}', 'Exercises\QuestionsController@api_answer')
    ->name('questions.question.api_answer');


Route::get('/signup_date', 'Auth\RegisterController@signup_date')
    ->name('signup_date');

Route::post('/signup_topics', 'Auth\RegisterController@signup_topics')
    ->name('signup_topics.signup');

Route::post('/signup_1', 'Auth\RegisterController@signup_1')
    ->name('signup_1');


Route::post('/', 'Auth\RegisterController@signup_2')->name('signup_2');





//home
Route::get('/home', 'HomeController@index')->name('home');

Route::post('/language/{lang}',array(
    'Middleware'=>'LanguageSwitcher',
    'uses'=>'LanguagesController@switch' ))
    ->name('language.switch');

// Route::post('/login', [
  //  'uses'          => 'Auth\AuthController@login',
    ///'middleware'    => 'CheckApprovalStatus',]);

Route::group(
    [
        'prefix' => 'explore',
    ], function () {

    Route::get('/', 'ExploreController@explorediscipline')
        ->name('explore.discipline');

    Route::get('/exerciseset', 'ExploreController@exploreexerciseset')
        ->name('explore.exerciseset');

    Route::get('/classes', 'ExploreController@exploreclasses')
        ->name('explore.classes');

});


//Auth::routes();

// Authentication Routes...
// C:\xampp\htdocs\laravel-8.x\app\Http\Controllers\Auth\LoginController.php
// Route::post('logins', 'Auth\LoginController@logins');
// $this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...



Route::post('forgetpassword', 'Auth\LoginController@forgetpassword')->name('password.fogot');

// Password Reset Routes...
Route::get('admin/password/reset', 'User\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('admin/password/email', 'AUseruth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('admin/password/reset/{token}', 'User\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('admin/password/reset', 'User\ResetPasswordController@reset');

//unauthorized
Route::get('/unauthorized', function () {
    return redirect('/public');
})->name('unauthorized');
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');


//unauthorized
Route::get('/unauthorized', function () {
    return redirect('/public');
})->name('unauthorized');
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
//role
Route::group(
    [
        'prefix' => 'roles',
    ], function () {

    Route::get('/', 'RolesController@listroles')
        ->name('roles.list');

});

//schools
Route::group(
    [
        'prefix' => 'schools',
    ], function () {

    Route::get('/', 'SchoolsController@index')
        ->name('schools.school.index');

    Route::get('/create','SchoolsController@create')
        ->name('schools.school.create');

    Route::get('/show/{school}','SchoolsController@show')
        ->name('schools.school.show')
        ->where('id', '[0-9]+');

    Route::get('/{school}/edit','SchoolsController@edit')
        ->name('schools.school.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'SchoolsController@store')
        ->name('schools.school.store');

    Route::put('school/{school}', 'SchoolsController@update')
        ->name('schools.school.update')
        ->where('id', '[0-9]+');

    Route::delete('/school/{school}','SchoolsController@destroy')
        ->name('schools.school.destroy')
        ->where('id', '[0-9]+');

});
//countries
Route::group(
    [
        'prefix' => 'countries',
    ], function () {

    Route::get('/', 'CountriesController@index')
        ->name('countries.country.index');

    Route::get('/create','CountriesController@create')
        ->name('countries.country.create');

    Route::get('/show/{country}','CountriesController@show')
        ->name('countries.country.show')
        ->where('id', '[0-9]+');

    Route::get('/{country}/edit','CountriesController@edit')
        ->name('countries.country.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'CountriesController@store')
        ->name('countries.country.store');

    Route::put('country/{country}', 'CountriesController@update')
        ->name('countries.country.update')
        ->where('id', '[0-9]+');

    Route::delete('/country/{country}','CountriesController@destroy')
        ->name('countries.country.destroy')
        ->where('id', '[0-9]+');

});
//curricula
Route::group(
    [
        'prefix' => 'curriculum_gradelists',
    ], function () {

    Route::get('/', 'Disciplines\Curriculum_gradelistsController@index')
        ->name('curriculum_gradelists.curriculum.index');

    Route::get('/create','Disciplines\Curriculum_gradelistsController@create')
        ->name('curriculum_gradelists.curriculum.create');

    Route::get('/show/{curriculum}','Disciplines\Curriculum_gradelistsController@show')
        ->name('curriculum_gradelists.curriculum.show')
        ->where('id', '[0-9]+');

    Route::get('/{curriculum}/edit','Disciplines\Curriculum_gradelistsController@edit')
        ->name('curriculum_gradelists.curriculum.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Disciplines\Curriculum_gradelistsController@store')
        ->name('curriculum_gradelists.curriculum.store');

    Route::put('curriculum/{curriculum}', 'Disciplines\Curriculum_gradelistsController@update')
        ->name('curriculum_gradelists.curriculum.update')
        ->where('id', '[0-9]+');

    Route::delete('/curriculum/{curriculum}','Disciplines\Curriculum_gradelistsController@destroy')
        ->name('curriculum_gradelists.curriculum.destroy')
        ->where('id', '[0-9]+');

});

// grades
Route::group(
    [
        'prefix' => 'grades',
    ], function () {

    Route::get('/', 'Disciplines\GradesController@index')
        ->name('grades.grade.index');

    Route::post('/create/{id}','Disciplines\GradesController@create')
        ->name('grades.grade.create');

    Route::get('/create/{id}','Disciplines\GradesController@create')
        ->name('grades.grade.create');

    Route::get('/show/{grade}','Disciplines\GradesController@show')
        ->name('grades.grade.show')
        ->where('id', '[0-9]+');

    Route::get('/{grade}/edit','Disciplines\GradesController@edit')
        ->name('grades.grade.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Disciplines\GradesController@store')
        ->name('grades.grade.store');

    Route::put('grade/{grade}', 'Disciplines\GradesController@update')
        ->name('grades.grade.update')
        ->where('id', '[0-9]+');

    Route::delete('/grade/{grade}','Disciplines\GradesController@destroy')
        ->name('grades.grade.destroy')
        ->where('id', '[0-9]+');

});

//activities
Route::group(
    [
        'prefix' => 'activities',
    ], function () {

    Route::get('/', 'ActivitiesController@index')
        ->name('activities.activity.index');

    Route::get('/create','ActivitiesController@create')
        ->name('activities.activity.create');

    Route::get('/show/{activity}','ActivitiesController@show')
        ->name('activities.activity.show')
        ->where('id', '[0-9]+');

    Route::get('/{activity}/edit','ActivitiesController@edit')
        ->name('activities.activity.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'ActivitiesController@store')
        ->name('activities.activity.store');

    Route::put('activity/{activity}', 'ActivitiesController@update')
        ->name('activities.activity.update')
        ->where('id', '[0-9]+');

    Route::delete('/activity/{activity}','ActivitiesController@destroy')
        ->name('activities.activity.destroy')
        ->where('id', '[0-9]+');

});
//badges
Route::group(
    [
        'prefix' => 'badges',
    ], function () {

    Route::get('/', 'BadgesController@index')
        ->name('badges.badge.index');

    Route::get('/create','BadgesController@create')
        ->name('badges.badge.create');

    Route::get('/show/{badge}','BadgesController@show')
        ->name('badges.badge.show')
        ->where('id', '[0-9]+');

    Route::get('/{badge}/edit','BadgesController@edit')
        ->name('badges.badge.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'BadgesController@store')
        ->name('badges.badge.store');

    Route::put('badge/{badge}', 'BadgesController@update')
        ->name('badges.badge.update')
        ->where('id', '[0-9]+');

    Route::delete('/badge/{badge}','BadgesController@destroy')
        ->name('badges.badge.destroy')
        ->where('id', '[0-9]+');

});
//businessrules
Route::group(
    [
        'prefix' => 'businessrules',
    ], function () {

    Route::get('/', 'BusinessrulesController@index')
        ->name('businessrules.businessrule.index');

    Route::get('/create','BusinessrulesController@create')
        ->name('businessrules.businessrule.create');

    Route::get('/show/{businessrule}','BusinessrulesController@show')
        ->name('businessrules.businessrule.show')
        ->where('id', '[0-9]+');

    Route::get('/{businessrule}/edit','BusinessrulesController@edit')
        ->name('businessrules.businessrule.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'BusinessrulesController@store')
        ->name('businessrules.businessrule.store');

    Route::put('businessrule/{businessrule}', 'BusinessrulesController@update')
        ->name('businessrules.businessrule.update')
        ->where('id', '[0-9]+');

    Route::delete('/businessrule/{businessrule}','BusinessrulesController@destroy')
        ->name('businessrules.businessrule.destroy')
        ->where('id', '[0-9]+');

});
//invitedusers
Route::group(
    [
        'prefix' => 'invitedusers',
    ], function () {

    Route::get('/', 'User\InvitedusersController@index')
        ->name('invitedusers.inviteduser.index');

    Route::get('/create','User\InvitedusersController@create')
        ->name('invitedusers.inviteduser.create');

    Route::get('/show/{inviteduser}','User\InvitedusersController@show')
        ->name('invitedusers.inviteduser.show')
        ->where('id', '[0-9]+');


    Route::get('/{inviteduser}/edit','User\InvitedusersController@edit')
        ->name('invitedusers.inviteduser.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'User\InvitedusersController@store')
        ->name('invitedusers.inviteduser.store');

    Route::post('/profile', 'User\InvitedusersController@store_profile')
        ->name('invitedusers.inviteduser.store_profile');



    Route::put('inviteduser/{inviteduser}', 'User\InvitedusersController@update')
        ->name('invitedusers.inviteduser.update')
        ->where('id', '[0-9]+');

    Route::delete('/inviteduser/{inviteduser}','User\InvitedusersController@destroy')
        ->name('invitedusers.inviteduser.destroy')
        ->where('id', '[0-9]+');

});
//languages
Route::group(
    [
        'prefix' => 'languages',
    ], function () {

    Route::get('/', 'LanguagesController@index')
        ->name('languages.language.index');

    Route::get('/create','LanguagesController@create')
        ->name('languages.language.create');

    Route::get('/show/{language}','LanguagesController@show')
        ->name('languages.language.show')
        ->where('id', '[0-9]+');

    Route::get('/{language}/edit','LanguagesController@edit')
        ->name('languages.language.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'LanguagesController@store')
        ->name('languages.language.store');

    Route::put('language/{language}', 'LanguagesController@update')
        ->name('languages.language.update')
        ->where('id', '[0-9]+');

    Route::delete('/language/{language}','LanguagesController@destroy')
        ->name('languages.language.destroy')
        ->where('id', '[0-9]+');

});
//newslettersubscriptions
Route::group(
    [
        'prefix' => 'newslettersubscriptions',
    ], function () {

    Route::get('/', 'NewslettersubscriptionsController@index')
        ->name('newslettersubscriptions.newslettersubscription.index');

    Route::get('/create','NewslettersubscriptionsController@create')
        ->name('newslettersubscriptions.newslettersubscription.create');

    Route::get('/show/{newslettersubscription}','NewslettersubscriptionsController@show')
        ->name('newslettersubscriptions.newslettersubscription.show')
        ->where('id', '[0-9]+');

    Route::get('/{newslettersubscription}/edit','NewslettersubscriptionsController@edit')
        ->name('newslettersubscriptions.newslettersubscription.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'NewslettersubscriptionsController@store')
        ->name('newslettersubscriptions.newslettersubscription.store');

    Route::put('newslettersubscription/{newslettersubscription}', 'NewslettersubscriptionsController@update')
        ->name('newslettersubscriptions.newslettersubscription.update')
        ->where('id', '[0-9]+');

    Route::delete('/newslettersubscription/{newslettersubscription}','NewslettersubscriptionsController@destroy')
        ->name('newslettersubscriptions.newslettersubscription.destroy')
        ->where('id', '[0-9]+');

});
//notificationactions
Route::group(
    [
        'prefix' => 'notificationsactions',
    ], function () {

    Route::get('/', 'NotificationsactionsController@index')
        ->name('notificationsactions.notificationsaction.index');

    Route::get('/create','NotificationsactionsController@create')
        ->name('notificationsactions.notificationsaction.create');

    Route::get('/show/{notificationsaction}','NotificationsactionsController@show')
        ->name('notificationsactions.notificationsaction.show')
        ->where('id', '[0-9]+');

    Route::get('/{notificationsaction}/edit','NotificationsactionsController@edit')
        ->name('notificationsactions.notificationsaction.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'NotificationsactionsController@store')
        ->name('notificationsactions.notificationsaction.store');

    Route::put('notificationsaction/{notificationsaction}', 'NotificationsactionsController@update')
        ->name('notificationsactions.notificationsaction.update')
        ->where('id', '[0-9]+');

    Route::delete('/notificationsaction/{notificationsaction}','NotificationsactionsController@destroy')
        ->name('notificationsactions.notificationsaction.destroy')
        ->where('id', '[0-9]+');

});
//pendingtasks
Route::group(
    [
        'prefix' => 'pendingtasks',
    ], function () {

    Route::get('/', 'User\PendingtasksController@index')
        ->name('pendingtasks.pendingtask.index');

    Route::get('/mypendingtasks', 'User\PendingtasksController@mylist')
        ->name('pendingtasks.mypendingtasks');

    Route::get('/create','User\PendingtasksController@create')
        ->name('pendingtasks.pendingtask.create');

    Route::get('/show/{pendingtask}','User\PendingtasksController@show')
        ->name('pendingtasks.pendingtask.show')
        ->where('id', '[0-9]+');

    Route::get('/{pendingtask}/edit','User\PendingtasksController@edit')
        ->name('pendingtasks.pendingtask.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'User\PendingtasksController@store')
        ->name('pendingtasks.pendingtask.store');

    Route::put('pendingtask/{pendingtask}', 'User\PendingtasksController@update')
        ->name('pendingtasks.pendingtask.update')
        ->where('id', '[0-9]+');

    Route::delete('/pendingtask/{pendingtask}','User\PendingtasksController@destroy')
        ->name('pendingtasks.pendingtask.destroy')
        ->where('id', '[0-9]+');

});

//classexercises
Route::group(
    [
        'prefix' => 'classexercises',
    ], function () {

    Route::get('/', 'Course\ClassexercisesController@index')
        ->name('classexercises.classexercise.index');

    Route::get('/create','Course\ClassexercisesController@create')
        ->name('classexercises.classexercise.create');

    Route::get('/show/{classexercise}','Course\ClassexercisesController@show')
        ->name('classexercises.classexercise.show')
        ->where('id', '[0-9]+');


    Route::get('/{classexercise}/edit','Course\ClassexercisesController@edit')
        ->name('classexercises.classexercise.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Course\ClassexercisesController@store')
        ->name('classexercises.classexercise.store');

    Route::put('classexercise/{classexercise}', 'Course\ClassexercisesController@update')
        ->name('classexercises.classexercise.update')
        ->where('id', '[0-9]+');

    Route::delete('/classexercise/{classexercise}','Course\ClassexercisesController@destroy')
        ->name('classexercises.classexercise.destroy')
        ->where('id', '[0-9]+');





});
//exercisesetbuyers
Route::group(
    [
        'prefix' => 'exercisesetbuyers',
    ], function () {

    Route::get('/', 'Exercises\ExercisesetbuyersController@index')
        ->name('exercisesetbuyers.exercisesetbuyer.index');

    Route::get('/create','Exercises\ExercisesetbuyersController@create')
        ->name('exercisesetbuyers.exercisesetbuyer.create');

    Route::get('/show/{exercisesetbuyer}','Exercises\ExercisesetbuyersController@show')
        ->name('exercisesetbuyers.exercisesetbuyer.show')
        ->where('id', '[0-9]+');

    Route::get('/{exercisesetbuyer}/edit','Exercises\ExercisesetbuyersController@edit')
        ->name('exercisesetbuyers.exercisesetbuyer.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Exercises\ExercisesetbuyersController@store')
        ->name('exercisesetbuyers.exercisesetbuyer.store');

    Route::put('exercisesetbuyer/{exercisesetbuyer}', 'Exercises\ExercisesetbuyersController@update')
        ->name('exercisesetbuyers.exercisesetbuyer.update')
        ->where('id', '[0-9]+');

    Route::delete('/exercisesetbuyer/{exercisesetbuyer}','Exercises\ExercisesetbuyersController@destroy')
        ->name('exercisesetbuyers.exercisesetbuyer.destroy')
        ->where('id', '[0-9]+');

});
//exercisesets
Route::group(
    [
        'prefix' => 'exercisesets',
    ], function () {

    Route::get('/', 'Exercises\ExercisesetsController@index')
        ->name('exercisesets.exerciseset.index');

    Route::get('/create','Exercises\ExercisesetsController@create')
        ->name('exercisesets.exerciseset.create');

    Route::get('/show/{exerciseset}','Exercises\ExercisesetsController@show')
        ->name('exercisesets.exerciseset.show')
        ->where('id', '[0-9]+');

    Route::post('/', 'Exercises\ExercisesetsController@store')
        ->name('exercisesets.exerciseset.store');

    Route::get('/summary/{exerciseset}/{ispublic}','Exercises\ExercisesetsController@summary')
        ->name('exercisesets.exerciseset.summary')
        ->where('id', '[0-9]+');

    Route::get('/{exerciseset}/edit','Exercises\ExercisesetsController@edit')
        ->name('exercisesets.exerciseset.edit')
        ->where('id', '[0-9]+');


    Route::put('exerciseset/{exerciseset}', 'Exercises\ExercisesetsController@update')
        ->name('exercisesets.exerciseset.update')
        ->where('id', '[0-9]+');

    Route::get('/listofquestion/{exerciseset}','Exercises\ExercisesetsController@listofquestion')
        ->name('exercisesets.exerciseset.listofquestion')
        ->where('exercise_id', '[0-9]+');


    Route::delete('/exerciseset/{exerciseset}','Exercises\ExercisesetsController@destroy')
        ->name('exercisesets.exerciseset.destroy')
        ->where('id', '[0-9]+');

    Route::get('/private', 'Exercises\ExercisesetsController@listprivatelib')
        ->name('exercisesets.exerciseset.private');

    Route::get('/importform/{exerciseset}', 'Exercises\ExercisesetsController@importform')
        ->name('exercisesets.exerciseset.importform');

    Route::post('/import/{exerciseset}', 'Exercises\ExercisesetsController@import')
        ->name('exercisesets.exerciseset.import')
        ->where('id', '[0-9]+');

    Route::post('/addrate', 'Exercises\ExercisesetsController@addrate')
        ->name('exercisesets.exerciseset.addrate');

    Route::post('/addtomylibrary/{exerciseset}', 'Exercises\ExercisesetsController@addtomylibrary' )
        ->name('exercisesets.exerciseset.addtomylibrary')
        ->where('id', '[0-9]+');



    Route::get('/buyexercise/{exerciseset}', 'Exercises\PracticeController@buyexercise' )
        ->name('exercisesets.buyexercise')
        ->where('id', '[0-9]+');

    Route::post('/buy/{exerciseset}', 'Exercises\PracticeController@buy' )
        ->name('exercisesets.buy')
        ->where('id', '[0-9]+');

    Route::post('/addreview', 'Exercises\ExercisesetsController@addreview')
        ->name('exercisesets.exerciseset.addreview');


    Route::get('/getgrades/{discipline}','Exercises\ExercisesetsController@getgrades')
        ->name('classexercises.classexercise.getgrades')
        ->where('id', '[0-9]+');



});

//classlearners
Route::group(
    [
        'prefix' => 'classlearners',
    ], function () {

    Route::get('/', 'Course\ClasslearnersController@index')
        ->name('classlearners.classlearner.index');

    Route::get('/create','Course\ClasslearnersController@create')
        ->name('classlearners.classlearner.create');

    Route::get('/show/{classlearner}','Course\ClasslearnersController@show')
        ->name('classlearners.classlearner.show')
        ->where('id', '[0-9]+');

    Route::get('/{classlearner}/edit','Course\ClasslearnersController@edit')
        ->name('classlearners.classlearner.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Course\ClasslearnersController@store')
        ->name('classlearners.classlearner.store');

    Route::put('classlearner/{classlearner}', 'Course\ClasslearnersController@update')
        ->name('classlearners.classlearner.update')
        ->where('id', '[0-9]+');

    Route::delete('/classlearner/{classlearner}','Course\ClasslearnersController@destroy')
        ->name('classlearners.classlearner.destroy')
        ->where('id', '[0-9]+');

    Route::post('savelist/{classid}', 'Course\ClasslearnersController@savelist')
        ->name('classlearners.classlearner.savelist');

    Route::get('/requestClass/','Disciplines\CourseclassesController@requestDiscipline')
        ->name('disciplinecollaborators.disciplinecollaborator.requestdiscipline');

});
//courseclasses
Route::group(
    [
        'prefix' => 'courseclasses',
    ], function () {

    Route::get('/', 'Course\CourseclassesController@index')
        ->name('courseclasses.courseclass.index');

    Route::get('/create','Course\CourseclassesController@create')
        ->name('courseclasses.courseclass.create');

    Route::get('/myclasses','Course\CourseclassesController@listmyclasses')
        ->name('courseclasses.courseclass.myclasses');

    Route::get('/show/{courseclass}','Course\CourseclassesController@show')
        ->name('courseclasses.courseclass.show')
        ->where('id', '[0-9]+');

    Route::get('/{courseclass}/edit','Course\CourseclassesController@edit')
        ->name('courseclasses.courseclass.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Course\CourseclassesController@store')
        ->name('courseclasses.courseclass.store');

    Route::put('courseclass/{courseclass}', 'Course\CourseclassesController@update')
        ->name('courseclasses.courseclass.update')
        ->where('id', '[0-9]+');

    Route::delete('/courseclass/{courseclass}','Course\CourseclassesController@destroy')
        ->name('courseclasses.courseclass.destroy')
        ->where('id', '[0-9]+');

    Route::get('/requestClass/{courseclass}/{guest?}','Course\CourseclassesController@requestjpoin')
        ->name('courseclasses.courseclass.requestjpoin')
        ->where('id', '[0-9]+');

    Route::get('/reject/{courseclasslearnerid}','Course\CourseclassesController@reject')
        ->name('courseclasses.courseclass.reject')
        ->where('id', '[0-9]+');

    Route::get('/accept/{courseclasslearnerid}','Course\CourseclassesController@accept')
        ->name('courseclasses.courseclass.accept')
        ->where('id', '[0-9]+');

    Route::get('/addlearner/{classid}','Course\CourseclassesController@addlearner')
        ->name('CourseclassesController.classlearner.addlearner')
        ->where('id', '[0-9]+');

    Route::post('/invitelearner/{classid}','Course\CourseclassesController@invitelearner')
        ->name('CourseclassesController.classlearner.invitelearner')
        ->where('id', '[0-9]+');

    Route::get('/myexercises/{classid}','Course\CourseclassesController@myexercises')
        ->name('courseclasses.classlearner.myexercises')
        ->where('id', '[0-9]+');

    Route::get('/myexams/{classid}','Course\CourseclassesController@myexams')
        ->name('courseclasses.classlearner.myexams')
        ->where('id', '[0-9]+');

    Route::get('/classexams/{classid}','Course\CourseclassesController@classexams')
        ->name('courseclasses.classlearner.classexams')
        ->where('id', '[0-9]+');

    Route::post('/addexercise/{courseclassid}/{exerciseid}','Course\CourseclassesController@addexercise')
        ->name('courseclasses.courseclass.addexercise')
        ->where('id', '[0-9]+');

    Route::post('/addexam/{courseclassid}/{examid}','Course\CourseclassesController@addexam')
        ->name('courseclasses.courseclass.addexam')
        ->where('id', '[0-9]+');

    Route::get('/removeexam/{classexamid}/','Course\CourseclassesController@removeexam')
        ->name('courseclasses.courseclass.removeexam')
        ->where('id', '[0-9]+');


    Route::post('/removeexercise/{courseclassid}/{exerciseid}','Course\CourseclassesController@removeexercise')
        ->name('courseclasses.courseclass.removeexercise')
        ->where('id', '[0-9]+');

    Route::post('/isavailableclass/{courseclassid}','Course\CourseclassesController@isavailableclass')
        ->name('courseclasses.courseclass.isavailableclass')
        ->where('id', '[0-9]+');



});

//classexams
Route::group(
    [
        'prefix' => 'classexams',
    ], function () {

    Route::get('/', 'Course\ClassexamsController@index')
        ->name('classexams.classexam.index');

    Route::get('/show/{classexam}','Course\ClassexamsController@show')
        ->name('classexams.classexam.show')
        ->where('id', '[0-9]+');

    Route::get('/create','Course\ClassexamsController@create')
        ->name('classexams.classexam.create');

    Route::get('/{classexam}/edit','Course\ClassexamsController@edit')
        ->name('classexams.classexam.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Course\ClassexamsController@store')
        ->name('classexams.classexam.store');

    Route::put('classexam/{classexam}', 'Course\ClassexamsController@update')
        ->name('classexams.classexam.update')
        ->where('id', '[0-9]+');

    Route::delete('/classexam/{classexam}','Course\ClassexamsController@destroy')
        ->name('classexams.classexam.destroy')
        ->where('id', '[0-9]+');

});
//exams
Route::group(
    [
        'prefix' => 'exams',
    ], function () {

    Route::get('/', 'Exams\ExamsController@index')
        ->name('exams.exam.index');

    Route::get('/create','Exams\ExamsController@create')
        ->name('exams.exam.create');

    Route::get('/create-first/{edit?}','Exams\ExamsController@create_firstpage')
        ->name('Exams.exam.create.first');


    Route::get('/selectdiscipline','Exams\ExamsController@selectdiscipline')
        ->name('Exams.exam.selectdiscipline');

    Route::post('/storequestionselection','Exams\ExamsController@storequestionselection')
        ->name('Exams.exam.storequestionselection');



    Route::post('/selectquestions','Exams\ExamsController@selectquestions')
        ->name('exams.exam.selectquestions');

    Route::get('/selectquestions','Exams\ExamsController@selectquestions')
        ->name('exams.exam.selectquestions');

    Route::get('/show/{exam}','Exams\ExamsController@show')
        ->name('exams.exam.show')
        ->where('id', '[0-9]+');

    Route::get('/{exam}/edit','Exams\ExamsController@edit')
        ->name('exams.exam.edit')
        ->where('id', '[0-9]+');

    Route::put('/', 'Exams\ExamsController@store')
        ->name('exams.exam.store');

    Route::put('exam/{exam}', 'Exams\ExamsController@update')
        ->name('exams.exam.update')
        ->where('id', '[0-9]+');

    Route::get('/exam/{exam}','Exams\ExamsController@destroy')
        ->name('exams.exam.destroy')
        ->where('id', '[0-9]+');


});
//examquestions
Route::group(
    [
        'prefix' => 'examquestions',
    ], function () {

    Route::get('/', 'Exams\ExamquestionsController@index')
        ->name('examquestions.examquestion.index');

    Route::get('/create','Exams\ExamquestionsController@create')
        ->name('examquestions.examquestion.create');

    Route::get('/show/{examquestion}','Exams\ExamquestionsController@show')
        ->name('examquestions.examquestion.show')
        ->where('id', '[0-9]+');

    Route::get('/{examquestion}/edit','Exams\ExamquestionsController@edit')
        ->name('examquestions.examquestion.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Exams\ExamquestionsController@store')
        ->name('examquestions.examquestion.store');

    Route::put('examquestion/{examquestion}', 'Exams\ExamquestionsController@update')
        ->name('examquestions.examquestion.update')
        ->where('id', '[0-9]+');

    Route::delete('/examquestion/{examquestion}','Exams\ExamquestionsController@destroy')
        ->name('examquestions.examquestion.destroy')
        ->where('id', '[0-9]+');

});
//questions
Route::group(
    [
        'prefix' => 'questions',
    ], function () {

    Route::get('/', 'Exercises\QuestionsController@index')
        ->name('questions.question.index');

    Route::get('/show/{question}','Exercises\QuestionsController@show')
        ->name('questions.question.show')
        ->where('id', '[0-9]+');

    Route::post('/', 'Exercises\QuestionsController@store')
        ->name('questions.question.store');

    Route::put('question/{question}', 'Exercises\QuestionsController@update')
        ->name('questions.question.update')
        ->where('id', '[0-9]+');

    Route::get('/create','Exercises\QuestionsController@create')
        ->name('questions.question.create');

    Route::get('/show/{question}','Exercises\QuestionsController@show')
        ->name('questions.question.show')
        ->where('id', '[0-9]+');

    Route::get('/{question}/edit','Exercises\QuestionsController@edit')
        ->name('questions.question.edit')
        ->where('id', '[0-9]+');

    Route::delete('/question/{question}','Exercises\QuestionsController@destroy')
        ->name('questions.question.destroy')
        ->where('id', '[0-9]+');

    Route::post('/{question}/edit_question', 'Exercises\QuestionsController@edit_question')
        ->name('questions.question.edit_question')
        ->where('id', '[0-9]+');

    Route::post('/add_question', 'Exercises\QuestionsController@add_question')
        ->name('questions.question.add_question');

    Route::post('/store_question', 'Exercises\QuestionsController@store_question')
        ->name('questions.question.store_question');

    Route::post('question/{question}', 'Exercises\QuestionsController@update_question')
        ->name('questions.question.update_question')
        ->where('id', '[0-9]+');

    Route::get('/single_question/{question}', 'Exercises\QuestionsController@single_question')
        ->name('questions.question.single_question')
        ->where('id', '[0-9]+');


    Route::post('/questionasimage', 'Exercises\QuestionsController@savequestionasimage')
        ->name('questions.question.savequestionasimage');

    Route::get('/getskills/{skills}','Exercises\QuestionsController@getskills')
        ->name('skills.skill.getskills')
        ->where('id', '[0-9]+');

});
//answeroptions
Route::group(
    [
        'prefix' => 'answeroptions',
    ], function () {

    Route::get('/', 'Exercises\AnsweroptionsController@index')
        ->name('answeroptions.answeroption.index');

    Route::get('/create','Exercises\AnsweroptionsController@create')
        ->name('answeroptions.answeroption.create');


    Route::get('/show/{answeroption}','Exercises\AnsweroptionsController@show')
        ->name('answeroptions.answeroption.show')
        ->where('id', '[0-9]+');

    Route::get('/{answeroption}/edit','Exercises\AnsweroptionsController@edit')
        ->name('answeroptions.answeroption.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Exercises\AnsweroptionsController@store')
        ->name('answeroptions.answeroption.store');

    Route::put('answeroption/{answeroption}', 'Exercises\AnsweroptionsController@update')
        ->name('answeroptions.answeroption.update')
        ->where('id', '[0-9]+');

    Route::delete('/answeroption/{answeroption}','Exercises\AnsweroptionsController@destroy')
        ->name('answeroptions.answeroption.destroy')
        ->where('id', '[0-9]+');
    //route for edit answer in the exerciseset show page
    Route::post('{answeroption}/edit_answer', 'Exercises\AnsweroptionsController@edit_answer')
        ->name('answeroptions.answeroption.edit_answer')
        ->where('id', '[0-9]+');

    Route::post('update_answer/{answeroption}', 'Exercises\AnsweroptionsController@update_answer')
        ->name('answeroptions.answeroption.update_answer')
        ->where('id', '[0-9]+');

    Route::post('/store_answer', 'Exercises\AnsweroptionsController@store_answer')
        ->name('answeroptions.answeroption.store_answer');

    Route::get('/single_answer/{answeroption}','Exercises\AnsweroptionsController@single_answer')
        ->name('answeroptions.answeroption.single_answer')
        ->where('id', '[0-9]+');

    Route::post('/create_answer','Exercises\AnsweroptionsController@create_answer')
        ->name('answeroptions.answeroption.create_answer');

});

//disciplinecollaborators
Route::group(
    [
        'prefix' => 'disciplinecollaborators',
    ], function () {

    Route::get('/', 'Disciplines\DisciplinecollaboratorsController@index')
        ->name('disciplinecollaborators.disciplinecollaborator.index');

    Route::get('/create','Disciplines\DisciplinecollaboratorsController@create')
        ->name('disciplinecollaborators.disciplinecollaborator.create');

    Route::get('/show/{disciplinecollaborator}','Disciplines\DisciplinecollaboratorsController@show')
        ->name('disciplinecollaborators.disciplinecollaborator.show')
        ->where('id', '[0-9]+');

    Route::get('/{disciplinecollaborator}/edit','Disciplines\DisciplinecollaboratorsController@edit')
        ->name('disciplinecollaborators.disciplinecollaborator.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Disciplines\DisciplinecollaboratorsController@store')
        ->name('disciplinecollaborators.disciplinecollaborator.store');

    Route::put('disciplinecollaborator/{disciplinecollaborator}', 'Disciplines\DisciplinecollaboratorsController@update')
        ->name('disciplinecollaborators.disciplinecollaborator.update')
        ->where('id', '[0-9]+');

    Route::delete('/disciplinecollaborator/{disciplinecollaborator}','Disciplines\DisciplinecollaboratorsController@destroy')
        ->name('disciplinecollaborators.disciplinecollaborator.destroy')
        ->where('id', '[0-9]+');

    Route::get('/requestDiscipline/','Disciplines\DisciplinecollaboratorsController@requestDiscipline')
        ->name('disciplinecollaborators.disciplinecollaborator.requestdiscipline');
});

//disciplines
Route::group(
    [
        'prefix' => 'disciplines',
    ], function () {

    Route::get('/', 'Disciplines\DisciplinesController@index')
        ->name('disciplines.discipline.index');

    Route::get('/show/{discipline}','Disciplines\DisciplinesController@show')
        ->name('disciplines.discipline.show')
        ->where('id', '[0-9]+');

    Route::get('/create','Disciplines\DisciplinesController@create')
        ->name('disciplines.discipline.create');

    Route::get('/listall', 'Disciplines\DisciplinesController@listall')
        ->name('disciplines.discipline.listall');

    Route::get('/{discipline}/edit','Disciplines\DisciplinesController@edit')
        ->name('disciplines.discipline.edit')
        ->where('id', '[0-9]+');

    Route::post('/listall', 'Disciplines\DisciplinesController@listall')
        ->name('disciplines.discipline.listall');

    Route::post('/', 'Disciplines\DisciplinesController@store')
        ->name('disciplines.discipline.store');

    Route::put('discipline/{discipline}', 'Disciplines\DisciplinesController@update')
        ->name('disciplines.discipline.update')
        ->where('id', '[0-9]+');

    Route::delete('/discipline/{discipline}','Disciplines\DisciplinesController@destroy')
        ->name('disciplines.discipline.destroy')
        ->where('id', '[0-9]+');

    Route::post('discipline/','Disciplines\DisciplinesController@filter_country_id')
        ->name('disciplines.filter_country_id');


    Route::get('/{discipline}/Knowledgemap','Disciplines\DisciplinesController@getknowledgemap')
        ->name('disciplines.getknowledgemap')
        ->where('id', '[0-9]+');


    Route::post('/{discipline}/Knowledgemap','Disciplines\DisciplinesController@getknowledgemap')
        ->name('disciplines.getknowledgemap')
        ->where('id', '[0-9]+');

});

//collaboration
Route::group(
    [
        'prefix' => 'collaboration',
    ], function (){

    Route::get('/{discipline}', 'Disciplines\CollaborationController@index')
        ->name('collaboration.index');

    Route::post ('/sortskill', 'Disciplines\CollaborationController@sortskill')
        ->name ('collaborationController.sortskill');

    Route::get ('/sortskill', 'Disciplines\CollaborationController@sortskill')
        ->name ('collaborationController.sortskill');


    Route::get('/{skill}/edit_modal','Disciplines\CollaborationController@edit_modal')
        ->name('collaborationController.skill.edit_modal')
        ->where('id', '[0-9]+');

    Route::get('/{skillcategory}/edit_skillcategory_modal','Disciplines\CollaborationController@edit_skillcategory_modal')
        ->name('collaborationController.skillcategory.edit_skillcategory_modal')
        ->where('id', '[0-9]+');


    Route::get('/sortskill','Disciplines\CollaborationController@skillmodal')->name('CollaborationController.skillmodal');

    Route::get('/{publish}/publish','Disciplines\CollaborationController@publish')
        ->name('collaborationController.discipline.publish')
        ->where('id', '[0-9]+');

    Route::delete('/skill/{skill}','Disciplines\CollaborationController@destroyskill')
        ->name('collaborationController.skill.destroy')
        ->where('id', '[0-9]+');

    Route::delete('/skillcategory/{skillcategory}','Disciplines\CollaborationController@destroyskillcategory')
        ->name('collaborationController.skillcategory.destroy')
        ->where('id', '[0-9]+');

});


//practice as guest , user answer 5 question and then return back to login / registration
Route::group (
    ['prefix'=>'guestpractice'],function (){

    Route::get('/guest/guestpractice', 'Exercises\GuestPracticeController@guestpractice')
        ->name('guest.guestpractice')
        ->where('id', '[0-9]+');

    Route::get('/nextquestion_interset/{nextquestion}/{questionindex}/', 'Exercises\GuestPracticeController@nextquestion')
        ->name('guestpractice.question.nextquestion')
        ->where('id', '[0-9]+');

    Route::get('/answer/{answerid}' ,'Exercises\GuestPracticeController@clickedanswer')
        ->name('guestpractice.answer.clickedanswer')
        ->where('id', '[0-9]+');

    Route::get('/question/{questionid}' ,'Exercises\GuestPracticeController@correctanswer')
        ->name('guestpractice.question.correctanswer')
        ->where('id', '[0-9]+');

    Route::get('/result/{exerciseset}/{userinterest_id?}' ,'Exercises\GuestPracticeController@result')
        ->name('guestpractice.question.result')
        ->where('id', '[0-9]+');





});

//practice to exsrcie set
Route::group (
    ['prefix'=>'practice'],function (){

    Route::get('/{exerciseset}', 'Exercises\PracticeController@index')
        ->name('practice.index')
        ->where('id', '[0-9]+');

    Route::get('/disciplinepractice/{userinterest_id}', 'Exercises\PracticeController@disciplinepractice')
        ->name('practice.disciplinepractice')
        ->where('id', '[0-9]+');



    Route::get('/next/{nextquestion}', 'Exercises\PracticeController@nextquestion')
        ->name('practice.question.nextquestion')
        ->where('id', '[0-9]+');

    Route::get('/nextquestion_interset/{nextquestion}/{userinterest_id}', 'Exercises\PracticeController@nextquestion_interset')
        ->name('practice.question.nextquestion_interset')
        ->where('id', '[0-9]+');

    Route::get('/answer/{answerid}' ,'Exercises\PracticeController@clickedanswer')
        ->name('practice.answer.clickedanswer')
        ->where('id', '[0-9]+');

    Route::get('/question/{questionid}' ,'Exercises\PracticeController@correctanswer')
        ->name('practice.question.correctanswer')
        ->where('id', '[0-9]+');

    Route::get('/result/{exerciseset}/{userinterest_id?}' ,'Exercises\PracticeController@result')
        ->name('practice.question.result')
        ->where('id', '[0-9]+');



});



//Take an Exam

Route::group (
    ['prefix'=>'takeexam'],function (){

    Route::get('/{examid}/{classid}/{isexam?}', 'Exams\TakeexamController@index')
        ->name('takeexam.index')
        ->where('id', '[0-9]+');

    Route::get('/q/q/listofquestion/{classexamid}', 'Exams\TakeexamController@listofquestion')
        ->name('takeexam.question.listofquestion')
        ->where('id', '[0-9]+');

    Route::get('/n/n/answer/{answerid}/{classexamid}' ,'Exams\TakeexamController@clickedanswer')
        ->name('takeexam.answer.clickedanswer')
        ->where('id', '[0-9]+');

    Route::get('/s/s/score/{classexamid}/{isexam?}' ,'Exams\TakeexamController@finishexam')
        ->name('takeexam.score')
        ->where('id', '[0-9]+');

    Route::get('/p/p/passage/{passageid?}' ,'Exams\TakeexamController@getpassage')
        ->name('takeexam.passage')
        ->where('id', '[0-9]+');

    /*  Route::get('/question/{questionid}' ,'Exams\TakeexamController@correctanswer')
          ->name('practice.question.correctanswer')
          ->where('id', '[0-9]+');

      Route::get('/result/{exerciseset}' ,'Exams\TakeexamController@result')
          ->name('practice.question.result')
          ->where('id', '[0-9]+');*/



});

/*    knowledgemap           */
Route::group(
    [
        'prefix' => 'knowledgemap',
    ], function (){

    Route::get('/{discipline}', 'Disciplines\KnowledgemapController@index')
        ->name('knowledgemap.index');

    Route::get('/skillcategories/{discipline}', 'Disciplines\KnowledgemapController@index_byskillcat')
        ->name('knowledgemap.skillcategories.index');

});

Route::group(
    [
        'prefix' => 'publishing',
    ], function (){

    Route::get('/{discipline}', 'Disciplines\PublishingController@index')
        ->name('publishing.index');

    Route::get('/{publish}/publish','Disciplines\PublishingController@publish')
        ->name('publishing.discipline.publish')
        ->where('id', '[0-9]+');

    Route::get('/{skill}/{discipline}/rejectskill','Disciplines\PublishingController@reject')
        ->name('publishing.skill.reject')
        ->where('id', '[0-9]+');

    Route::get('/{skill}/{discipline}/acceptskill','Disciplines\PublishingController@accept')
        ->name('publishing.skill.accept')->where('id', '[0-9]+');

    Route::get('/{skillcategory}/{discipline}/{isfirst}/reject','Disciplines\PublishingController@rejectskillcategory')
        ->name('publishing.skillcategory.rejectskillcategory')
        ->where('id', '[0-9]+');

    Route::get('/{skillcategory}/{discipline}/{isfirst}/accept','Disciplines\PublishingController@acceptskillcategory')
        ->name('publishing.skillcategory.acceptskillcategory')->where('id', '[0-9]+');


});


//disciplineversions
Route::group(
    [
        'prefix' => 'disciplineversions',
    ], function () {

    Route::get('/', 'Disciplines\DisciplineversionsController@index')
        ->name('disciplineversions.disciplineversion.index');

    Route::get('/create','Disciplines\DisciplineversionsController@create')
        ->name('disciplineversions.disciplineversion.create');

    Route::get('/show/{disciplineversion}','Disciplines\DisciplineversionsController@show')
        ->name('disciplineversions.disciplineversion.show')
        ->where('id', '[0-9]+');

    Route::get('/{disciplineversion}/edit','Disciplines\DisciplineversionsController@edit')
        ->name('disciplineversions.disciplineversion.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Disciplines\DisciplineversionsController@store')
        ->name('disciplineversions.disciplineversion.store');

    Route::put('disciplineversion/{disciplineversion}', 'Disciplines\DisciplineversionsController@update')
        ->name('disciplineversions.disciplineversion.update')
        ->where('id', '[0-9]+');

    Route::delete('/disciplineversion/{disciplineversion}','Disciplines\DisciplineversionsController@destroy')
        ->name('disciplineversions.disciplineversion.destroy')
        ->where('id', '[0-9]+');

});

//skillcategories
Route::group(
    [
        'prefix' => 'skillcategories',
    ], function () {

    Route::get('/', 'Disciplines\SkillcategoriesController@index')
        ->name('skillcategories.skillcategory.index');

    Route::get('/create','Disciplines\SkillcategoriesController@create')
        ->name('skillcategories.skillcategory.create');

    Route::get('/show/{skillcategory}','Disciplines\SkillcategoriesController@show')
        ->name('skillcategories.skillcategory.show')
        ->where('id', '[0-9]+');

    Route::get('/{skillcategory}/edit','Disciplines\SkillcategoriesController@edit')
        ->name('skillcategories.skillcategory.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Disciplines\SkillcategoriesController@store')
        ->name('skillcategories.skillcategory.store');

    Route::put('skillcategory/{skillcategory}', 'Disciplines\SkillcategoriesController@update')
        ->name('skillcategories.skillcategory.update')
        ->where('id', '[0-9]+');

    Route::delete('/skillcategory/{skillcategory}','Disciplines\SkillcategoriesController@destroy')
        ->name('skillcategories.skillcategory.destroy')
        ->where('id', '[0-9]+');

});

//skills
Route::group(
    [
        'prefix' => 'skills',
    ], function () {

    Route::get('/', 'Disciplines\SkillsController@index')
        ->name('skills.skill.index');

    Route::get('/create','Disciplines\SkillsController@create')
        ->name('skills.skill.create');

    Route::get('/show/{skill}','Disciplines\SkillsController@show')
        ->name('skills.skill.show')
        ->where('id', '[0-9]+');

    Route::get('/{skill}/edit','Disciplines\SkillsController@edit')
        ->name('skills.skill.edit')
        ->where('id', '[0-9]+');


    Route::get('/store', 'Disciplines\SkillsController@store')
        ->name('skills.skill.store1');


    Route::post('/', 'Disciplines\SkillsController@store')
        ->name('skills.skill.store');

    Route::put('skill/{skill}', 'Disciplines\SkillsController@update')
        ->name('skills.skill.update')
        ->where('id', '[0-9]+');

    Route::delete('/skill/{skill}','Disciplines\SkillsController@destroy')
        ->name('skills.skill.destroy')
        ->where('id', '[0-9]+');

});
//topics
Route::group(
    [
        'prefix' => 'topics',
    ], function () {

    Route::get('/', 'Disciplines\TopicsController@index')
        ->name('topics.topic.index');

    Route::get('/create','Disciplines\TopicsController@create')
        ->name('topics.topic.create');

    Route::get('/show/{topic}','Disciplines\TopicsController@show')
        ->name('topics.topic.show')
        ->where('id', '[0-9]+');

    Route::get('/{topic}/edit','Disciplines\TopicsController@edit')
        ->name('topics.topic.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Disciplines\TopicsController@store')
        ->name('topics.topic.store');

    Route::put('topic/{topic}', 'Disciplines\TopicsController@update')
        ->name('topics.topic.update')
        ->where('id', '[0-9]+');

    Route::delete('/topic/{topic}','Disciplines\TopicsController@destroy')
        ->name('topics.topic.destroy')
        ->where('id', '[0-9]+');

});

//skillmastery
Route::group(
    [
        'prefix' => 'userskillmasterylevels',
    ], function () {

    Route::get('/', 'User\UserSkillmasterylevelsController@index')
        ->name('userskillmasterylevels.userskillmasterylevel.index');

    Route::get('/create','User\UserSkillmasterylevelsController@create')
        ->name('skillmasterylevels.skillmasterylevel.create');

    Route::get('/show/{userskillmasterylevel}','User\UserSkillmasterylevelsController@show')
        ->name('userskillmasterylevels.userskillmasterylevel.show')
        ->where('id', '[0-9]+');

    Route::get('/{userskillmasterylevel}/edit','User\UserSkillmasterylevelsController@edit')
        ->name('userskillmasterylevels.userskillmasterylevel.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'User\UserSkillmasterylevelsController@store')
        ->name('userskillmasterylevels.userskillmasterylevel.store');

    Route::put('userskillmasterylevel/{userskillmasterylevel}', 'User\UserSkillmasterylevelsController@update')
        ->name('userskillmasterylevels.userskillmasterylevel.update')
        ->where('id', '[0-9]+');

    Route::delete('/userskillmasterylevel/{userskillmasterylevel}','User\UserSkillmasterylevelsController@destroy')
        ->name('userskillmasterylevels.userskillmasterylevel.destroy')
        ->where('id', '[0-9]+');

});

//useractivitylogs
Route::group(
    [
        'prefix' => 'useractivitylogs',
    ], function () {

    Route::get('/', 'User\UseractivitylogsController@index')
        ->name('useractivitylogs.useractivitylog.index');

    Route::get('/create','User\UseractivitylogsController@create')
        ->name('useractivitylogs.useractivitylog.create');

    Route::get('/show/{useractivitylog}','User\UseractivitylogsController@show')
        ->name('useractivitylogs.useractivitylog.show')
        ->where('id', '[0-9]+');

    Route::get('/{useractivitylog}/edit','User\UseractivitylogsController@edit')
        ->name('useractivitylogs.useractivitylog.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'User\UseractivitylogsController@store')
        ->name('useractivitylogs.useractivitylog.store');

    Route::put('useractivitylog/{useractivitylog}', 'User\UseractivitylogsController@update')
        ->name('useractivitylogs.useractivitylog.update')
        ->where('id', '[0-9]+');

    Route::delete('/useractivitylog/{useractivitylog}','User\UseractivitylogsController@destroy')
        ->name('useractivitylogs.useractivitylog.destroy')
        ->where('id', '[0-9]+');

});
//userbadges
Route::group(
    [
        'prefix' => 'userbadges',
    ], function () {

    Route::get('/', 'User\UserbadgesController@index')
        ->name('userbadges.userbadge.index');

    Route::get('/create','User\UserbadgesController@create')
        ->name('userbadges.userbadge.create');

    Route::get('/show/{userbadge}','User\UserbadgesController@show')
        ->name('userbadges.userbadge.show')
        ->where('id', '[0-9]+');

    Route::get('/{userbadge}/edit','User\UserbadgesController@edit')
        ->name('userbadges.userbadge.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'User\UserbadgesController@store')
        ->name('userbadges.userbadge.store');

    Route::put('userbadge/{userbadge}', 'User\UserbadgesController@update')
        ->name('userbadges.userbadge.update')
        ->where('id', '[0-9]+');

    Route::delete('/userbadge/{userbadge}','User\UserbadgesController@destroy')
        ->name('userbadges.userbadge.destroy')
        ->where('id', '[0-9]+');

});
//userexamanswers
Route::group(
    [
        'prefix' => 'userexamanswers',
    ], function () {

    Route::get('/', 'User\UserexamanswersController@index')
        ->name('userexamanswers.userexamanswer.index');

    Route::get('/create','User\UserexamanswersController@create')
        ->name('userexamanswers.userexamanswer.create');

    Route::get('/show/{userexamanswer}','User\UserexamanswersController@show')
        ->name('userexamanswers.userexamanswer.show')
        ->where('id', '[0-9]+');

    Route::get('/{userexamanswer}/edit','User\UserexamanswersController@edit')
        ->name('userexamanswers.userexamanswer.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'User\UserexamanswersController@store')
        ->name('userexamanswers.userexamanswer.store');

    Route::put('userexamanswer/{userexamanswer}', 'User\UserexamanswersController@update')
        ->name('userexamanswers.userexamanswer.update')
        ->where('id', '[0-9]+');

    Route::delete('/userexamanswer/{userexamanswer}','User\UserexamanswersController@destroy')
        ->name('userexamanswers.userexamanswer.destroy')
        ->where('id', '[0-9]+');

});
//userexamscores
Route::group(
    [
        'prefix' => 'userexamscores',
    ], function () {

    Route::get('/', 'User\UserexamscoresController@index')
        ->name('userexamscores.userexamscore.index');

    Route::get('/create','User\UserexamscoresController@create')
        ->name('userexamscores.userexamscore.create');

    Route::get('/show/{userexamscore}','User\UserexamscoresController@show')
        ->name('userexamscores.userexamscore.show')
        ->where('id', '[0-9]+');

    Route::get('/{userexamscore}/edit','User\UserexamscoresController@edit')
        ->name('userexamscores.userexamscore.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'User\UserexamscoresController@store')
        ->name('userexamscores.userexamscore.store');

    Route::put('userexamscore/{userexamscore}', 'User\UserexamscoresController@update')
        ->name('userexamscores.userexamscore.update')
        ->where('id', '[0-9]+');

    Route::delete('/userexamscore/{userexamscore}','User\UserexamscoresController@destroy')
        ->name('userexamscores.userexamscore.destroy')
        ->where('id', '[0-9]+');

});
//userinterests
Route::group(
    [
        'prefix' => 'userinterests',
    ], function () {

    Route::get('/', 'User\UserinterestsController@index')
        ->name('userinterests.userinterest.index');

    Route::get('/create','User\UserinterestsController@create')
        ->name('userinterests.userinterest.create');

    Route::get('/show/{userinterest}','User\UserinterestsController@show')
        ->name('userinterests.userinterest.show')
        ->where('id', '[0-9]+');

    Route::get('/{userinterest}/edit','User\UserinterestsController@edit')
        ->name('userinterests.userinterest.edit')
        ->where('id', '[0-9]+');

    Route::get('/{topic_id}/editinterest','User\UserinterestsController@editinterest')
        ->name('userinterests.userinterest.editinterest')
        ->where('id', '[0-9]+');


    Route::post('/', 'User\UserinterestsController@store')
        ->name('userinterests.userinterest.store');

    Route::put('userinterest/{userinterest}', 'User\UserinterestsController@update')
        ->name('userinterests.userinterest.update')
        ->where('id', '[0-9]+');

    Route::get('userinterest/updateinterests', 'User\UserinterestsController@updateinterests')
        ->name('userinterests.userinterest.updateinterests')
        ->where('id', '[0-9]+');

    Route::delete('/userinterest/{userinterest}','User\UserinterestsController@destroy')
        ->name('userinterests.userinterest.destroy')
        ->where('id', '[0-9]+');

});
//usernotifications
Route::group(
    [
        'prefix' => 'usernotifications',
    ], function () {

    Route::get('/', 'User\UsernotificationsController@index')
        ->name('usernotifications.usernotification.index');

    Route::get('/create','User\UsernotificationsController@create')
        ->name('usernotifications.usernotification.create');

    Route::get('/show/{usernotification}','User\UsernotificationsController@show')
        ->name('usernotifications.usernotification.show')
        ->where('id', '[0-9]+');

    Route::get('/{usernotification}/edit','User\UsernotificationsController@edit')
        ->name('usernotifications.usernotification.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'User\UsernotificationsController@store')
        ->name('usernotifications.usernotification.store');

    Route::put('usernotification/{usernotification}', 'User\UsernotificationsController@update')
        ->name('usernotifications.usernotification.update')
        ->where('id', '[0-9]+');

    Route::delete('/usernotification/{usernotification}','User\UsernotificationsController@destroy')
        ->name('usernotifications.usernotification.destroy')
        ->where('id', '[0-9]+');

});
//users
Route::group(
    [
        'prefix' => 'users',
    ], function () {

    Route::get('/', 'User\UsersController@index')
        ->name('users.user.index');

    Route::get('/create','User\UsersController@create')
        ->name('users.user.create');

    Route::post('registers', 'Auth\RegisterController@registers');

    Route::get('/show/{user}','User\UsersController@show')
        ->name('users.user.show')
        ->where('id', '[0-9]+');

    Route::get('/profile/{user}','User\UsersController@getprofile')
        ->name('profile')
        ->where('id', '[0-9]+');

    Route::get('/parentapproval/{code}', 'Auth\RegisterController@parentapproval')
        ->name('parentapproval');

    Route::get('/acceptedbyparent/{code}', 'Auth\RegisterController@acceptedbyparent')
        ->name('users.user.acceptedbyparent');

    Route::get('/rejecteddbyparent/{code}', 'Auth\RegisterController@rejecteddbyparent')
        ->name('users.user.rejecteddbyparent');

    Route::post('/updatepicture/{user}','User\UsersController@updatepicture')
        ->name('users.user.updatepicture')
        ->where('id', '[0-9]+');

    Route::post('/addrole/{user}/{role}','User\UsersController@addrole')
        ->name('users.user.addrole')
        ->where('id', '[0-9]+');

    Route::post('/removerole/{user}/{role}','User\UsersController@removerole')
        ->name('users.user.removerole')
        ->where('id', '[0-9]+');



    Route::get('/{user}/edit','User\UsersController@edit')
        ->name('users.user.edit')
        ->where('id', '[0-9]+');

    Route::get('/{user}/editrole','User\UsersController@editrole')
        ->name('users.user.editrole')
        ->where('id', '[0-9]+');

    Route::post('/', 'User\UsersController@store')
        ->name('users.user.store');


    Route::get('/badges/{user}', 'User\UsersController@userbadges')
        ->name('users.user.userbadges');


    Route::put('user/{user}', 'User\UsersController@update')
        ->name('users.user.update')
        ->where('id', '[0-9]+');

    Route::post('update/{user}', 'User\UsersController@updateprofile')
        ->name('users.update.user')
        ->where('id', '[0-9]+');

    Route::delete('/user/{user}','User\UsersController@destroy')
        ->name('users.user.destroy')
        ->where('id', '[0-9]+');

    Route::get('/invitefriend/{user}','User\UsersController@invitefriend')
        ->name('users.user.invitefriend')
        ->where('id', '[0-9]+');

    Route::get('/addchildren/{user}','User\UsersController@addchildren')
        ->name('users.user.addchildren')
        ->where('id', '[0-9]+');

    Route::post('/savechild/{user}', 'User\UsersController@savechild')
        ->name('invitedusers.inviteduser.savechild');

    Route::get('/childrenlist/{user}','User\UsersController@childrenlist')
        ->name('users.user.childrenlist')
        ->where('id', '[0-9]+');

});

//gamedetails
Route::group(
    [
        'prefix' => 'gamedetails',
    ], function () {

    Route::get('/', 'Games\GamedetailsController@index')
        ->name('gamedetails.gamedetail.index');

    Route::get('/create','Games\GamedetailsController@create')
        ->name('gamedetails.gamedetail.create');

    Route::get('/show/{gamedetail}','Games\GamedetailsController@show')
        ->name('gamedetails.gamedetail.show')
        ->where('id', '[0-9]+');

    Route::get('/{gamedetail}/edit','Games\GamedetailsController@edit')
        ->name('gamedetails.gamedetail.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Games\GamedetailsController@store')
        ->name('gamedetails.gamedetail.store');

    Route::put('gamedetail/{gamedetail}', 'Games\GamedetailsController@update')
        ->name('gamedetails.gamedetail.update')
        ->where('id', '[0-9]+');

    Route::delete('/gamedetail/{gamedetail}','Games\GamedetailsController@destroy')
        ->name('gamedetails.gamedetail.destroy')
        ->where('id', '[0-9]+');

});
//gamedownloads
Route::group(
    [
        'prefix' => 'gamedownloads',
    ], function () {

    Route::get('/', 'Games\GamedownloadsController@index')
        ->name('gamedownloads.gamedownload.index');

    Route::get('/create','Games\GamedownloadsController@create')
        ->name('gamedownloads.gamedownload.create');

    Route::get('/show/{gamedownload}','Games\GamedownloadsController@show')
        ->name('gamedownloads.gamedownload.show')
        ->where('id', '[0-9]+');

    Route::get('/{gamedownload}/edit','Games\GamedownloadsController@edit')
        ->name('gamedownloads.gamedownload.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Games\GamedownloadsController@store')
        ->name('gamedownloads.gamedownload.store');

    Route::put('gamedownload/{gamedownload}', 'Games\GamedownloadsController@update')
        ->name('gamedownloads.gamedownload.update')
        ->where('id', '[0-9]+');

    Route::delete('/gamedownload/{gamedownload}','Games\GamedownloadsController@destroy')
        ->name('gamedownloads.gamedownload.destroy')
        ->where('id', '[0-9]+');

});
//gamekids
Route::group(
    [
        'prefix' => 'gamerestrictedkids',
    ], function () {

    Route::get('/', 'Games\GamerestrictedkidsController@index')
        ->name('gamerestrictedkids.gamerestrictedkid.index');

    Route::get('/create','Games\GamerestrictedkidsController@create')
        ->name('gamerestrictedkids.gamerestrictedkid.create');

    Route::get('/show/{gamerestrictedkid}','Games\GamerestrictedkidsController@show')
        ->name('gamerestrictedkids.gamerestrictedkid.show')
        ->where('id', '[0-9]+');

    Route::get('/{gamerestrictedkid}/edit','Games\GamerestrictedkidsController@edit')
        ->name('gamerestrictedkids.gamerestrictedkid.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Games\GamerestrictedkidsController@store')
        ->name('gamerestrictedkids.gamerestrictedkid.store');

    Route::put('gamerestrictedkid/{gamerestrictedkid}', 'Games\GamerestrictedkidsController@update')
        ->name('gamerestrictedkids.gamerestrictedkid.update')
        ->where('id', '[0-9]+');

    Route::delete('/gamerestrictedkid/{gamerestrictedkid}','Games\GamerestrictedkidsController@destroy')
        ->name('gamerestrictedkids.gamerestrictedkid.destroy')
        ->where('id', '[0-9]+');

});
//games
Route::group(
    [
        'prefix' => 'games',
    ], function () {

    Route::get('/', 'Games\GamesController@index')
        ->name('games.game.index');

    Route::get('/create','Games\GamesController@create')
        ->name('games.game.create');

    Route::get('/show/{game}','Games\GamesController@show')
        ->name('games.game.show')
        ->where('id', '[0-9]+');

    Route::get('/{game}/edit','Games\GamesController@edit')
        ->name('games.game.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Games\GamesController@store')
        ->name('games.game.store');

    Route::put('game/{game}', 'Games\GamesController@update')
        ->name('games.game.update')
        ->where('id', '[0-9]+');

    Route::delete('/game/{game}','Games\GamesController@destroy')
        ->name('games.game.destroy')
        ->where('id', '[0-9]+');

});

Route::group(
    [
        'prefix' => 'examselections',
    ], function () {

    Route::get('/', 'Exams\ExamselectionsController@index')
        ->name('examselections.examselections.index');

    Route::get('/create','Exams\ExamselectionsController@create')
        ->name('examselections.examselections.create');

    Route::get('/show/{examselections}','Exams\ExamselectionsController@show')
        ->name('examselections.examselections.show')
        ->where('id', '[0-9]+');

    Route::get('/{examselections}/edit','Exams\ExamselectionsController@edit')
        ->name('examselections.examselections.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Exams\ExamselectionsController@store')
        ->name('examselections.examselections.store');

    Route::put('examselections/{examselections}', 'Exams\ExamselectionsController@update')
        ->name('examselections.examselections.update')
        ->where('id', '[0-9]+');

    Route::delete('/examselections/{examselections}','Exams\ExamselectionsController@destroy')
        ->name('examselections.examselections.destroy')
        ->where('id', '[0-9]+');

});

Route::group(
    [
        'prefix' => 'passages',
    ], function () {

    Route::get('/{exercise_id}', 'Exercises\PassagesController@index')
        ->name('passages.passage.index');

    Route::get('/create/{exercise_id}','Exercises\PassagesController@create')
        ->name('passages.passage.create');

    Route::get('/show/{passage}','Exercises\PassagesController@show')
        ->name('passages.passage.show')
        ->where('id', '[0-9]+');

    Route::get('/{passage}/edit','Exercises\PassagesController@edit')
        ->name('passages.passage.edit')
        ->where('id', '[0-9]+');

    Route::post('/{exercise_id}', 'Exercises\PassagesController@store')
        ->name('passages.passage.store');

    Route::put('passage/{passage}', 'Exercises\PassagesController@update')
        ->name('passages.passage.update')
        ->where('id', '[0-9]+');

    Route::get('/passage/{passage}','Exercises\PassagesController@destroy')
        ->name('passages.passage.destroy')
        ->where('id', '[0-9]+');

});

Route::group(
    [
        'prefix' => 'practiceresults',
    ], function () {

    Route::get('/', 'Exercises\PracticeresultsController@index')
        ->name('practiceresults.practiceresults.index');

    Route::get('/create','Exercises\PracticeresultsController@create')
        ->name('practiceresults.practiceresults.create');

    Route::get('/show/{practiceresults}','Exercises\PracticeresultsController@show')
        ->name('practiceresults.practiceresults.show')
        ->where('id', '[0-9]+');

    Route::get('/{practiceresults}/edit','Exercises\PracticeresultsController@edit')
        ->name('practiceresults.practiceresults.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Exercises\PracticeresultsController@store')
        ->name('practiceresults.practiceresults.store');

    Route::put('practiceresults/{practiceresults}', 'Exercises\PracticeresultsController@update')
        ->name('practiceresults.practiceresults.update')
        ->where('id', '[0-9]+');

    Route::delete('/practiceresults/{practiceresults}','Exercises\PracticeresultsController@destroy')
        ->name('practiceresults.practiceresults.destroy')
        ->where('id', '[0-9]+');

});
/*
Route::group(
[
    'prefix' => 'practiceresults',
], function () {

    Route::get('/', 'PracticeresultsController@index')
         ->name('practiceresults.practiceresult.index');

    Route::get('/create','PracticeresultsController@create')
         ->name('practiceresults.practiceresult.create');

    Route::get('/show/{practiceresult}','PracticeresultsController@show')
         ->name('practiceresults.practiceresult.show')
         ->where('id', '[0-9]+');

    Route::get('/{practiceresult}/edit','PracticeresultsController@edit')
         ->name('practiceresults.practiceresult.edit')
         ->where('id', '[0-9]+');

    Route::post('/', 'PracticeresultsController@store')
         ->name('practiceresults.practiceresult.store');

    Route::put('practiceresult/{practiceresult}', 'PracticeresultsController@update')
         ->name('practiceresults.practiceresult.update')
         ->where('id', '[0-9]+');

    Route::delete('/practiceresult/{practiceresult}','PracticeresultsController@destroy')
         ->name('practiceresults.practiceresult.destroy')
         ->where('id', '[0-9]+');

});*/



Route::group(
    [
        'prefix' => 'skillmasterylevels',
    ], function () {

    Route::get('/', 'Disciplines\SkillmasterylevelsController@index')
        ->name('skillmasterylevels.skillmasterylevel.index');

    Route::get('/create','Disciplines\SkillmasterylevelsController@create')
        ->name('skillmasterylevels.skillmasterylevel.create');

    Route::get('/show/{skillmasterylevel}','Disciplines\SkillmasterylevelsController@show')
        ->name('skillmasterylevels.skillmasterylevel.show')
        ->where('id', '[0-9]+');

    Route::get('/{skillmasterylevel}/edit','Disciplines\SkillmasterylevelsController@edit')
        ->name('skillmasterylevels.skillmasterylevel.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Disciplines\SkillmasterylevelsController@store')
        ->name('skillmasterylevels.skillmasterylevel.store');

    Route::put('skillmasterylevel/{skillmasterylevel}', 'Disciplines\SkillmasterylevelsController@update')
        ->name('skillmasterylevels.skillmasterylevel.update')
        ->where('id', '[0-9]+');

    Route::delete('/skillmasterylevel/{skillmasterylevel}','Disciplines\SkillmasterylevelsController@destroy')
        ->name('skillmasterylevels.skillmasterylevel.destroy')
        ->where('id', '[0-9]+');

});

Route::group(
    [
        'prefix' => 'xp_points',
    ], function () {

    Route::get('/', 'XpPointsController@index')
        ->name('xp_points.xp_point.index');

    Route::get('/create','XpPointsController@create')
        ->name('xp_points.xp_point.create');

    Route::get('/show/{xpPoint}','XpPointsController@show')
        ->name('xp_points.xp_point.show')
        ->where('id', '[0-9]+');

    Route::get('/{xpPoint}/edit','XpPointsController@edit')
        ->name('xp_points.xp_point.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'XpPointsController@store')
        ->name('xp_points.xp_point.store');

    Route::put('xp_point/{xpPoint}', 'XpPointsController@update')
        ->name('xp_points.xp_point.update')
        ->where('id', '[0-9]+');

    Route::delete('/xp_point/{xpPoint}','XpPointsController@destroy')
        ->name('xp_points.xp_point.destroy')
        ->where('id', '[0-9]+');

});


