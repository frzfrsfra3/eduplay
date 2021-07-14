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
//Check command url.
Route::get('run-command', 'Mails\MailController@checkInThreeDayUserLoggedIn');

Route::get('/test-mail', function(){
  return view('mails.exerciseset')->with([
      'url' => 'http://www.google.com',
      'id' => 1
  ]);
});

// Root
Route::get('/', 'HomeController@home');

// Welcome
Route::get('/welcome', 'HomeController@home')->name('welcome');

//Microsoft teams
Route::get('microsoft-team','HomeController@microsoftTeams');

// Who we are
Route::get('/who-we-are', 'HomeController@getWhoWeArePage')->name('who-we-are');

// What we are
Route::get('/what-we-do', 'HomeController@getWhatWeDoPage')->name('what-we-do');

// Contact us
Route::get('/contact-us', 'HomeController@getContactUsPage')->name('contact-us');

// FAQ
Route::get('/faq', 'HomeController@getFaqPage')->name('faq');

// Privacy Policy
Route::get('/privacy-policy', 'HomeController@getPrivacyPolicyPage')->name('privacy-policy');
Route::get('/game/privacy-policy/', 'HomeController@getPrivacyPolicyPageForGame')->name('privacy-policy-for-game');

// Forum
Route::get('/forum', 'HomeController@getForumPage')->name('forum');

// Careers
Route::get('/careers', 'HomeController@getCareersPage')->name('careers');
//Update Question JSON with question id.
Route::get('/update/existing/question-json','Exercises\ExercisesetsController@checkAndUpdateQuestionJSON');

// Teachers
// Route::get('/teachers', function () {
//     return view('eduplaycloud.teachers');
// })->name('teachers');
Route::get('/teachers','HomeController@getToExercises')->name('teachers');

// Students
// Route::get('/students', function () {
//     return view('eduplaycloud.students');
// })->name('students');
Route::get('/students','HomeController@getTopDiscipline')->name('students');

Route::get('/parents','HomeController@getParent')->name('parents');

/*Route::get('/reports', function () {
    return view('eduplaycloud.users.reports.reports');
})->name('reports');*/

//My Task Display
Route::get('/my-task','UserHomeController@getMyTasks')->name('my-task');


// Tour : Developed By : WC
Route::group(
  [
    'prefix' => 'admin',
  ], function () {
  Route::get('/db-clean','Admin\AdminDBController@index')
      ->name('admin.db-clean');

  Route::get('/answer/clean','Admin\AdminDBController@cleanAnswerOption')
      ->name('admin.answer.clean');

  Route::get('/questions/clean','Admin\AdminDBController@cleanQuestions')
      ->name('admin.questions.clean');

  Route::get('/exercise/clean','Admin\AdminDBController@cleanExercise')
      ->name('admin.exercise.clean');
              
});

// Reports
Route::group(
    [
        'prefix' => 'reports',
    ], function () {
    Route::get('/', 'Reports\TeacherReportsController@index')->name('reports');

    Route::get('learner/performance/{id}','Reports\TeacherReportsController@learnerPerformance');

    Route::get('skill/performance/{classId}/{userId}','Reports\TeacherReportsController@skillPerformance')->where('classId', '[0-9]+')->where('userId', '[0-9]+')->name('skillPerformance');
    //Skill performance filter route develop by WC.
    Route::get('skill/performance/filter','Reports\TeacherReportsController@getSkillPerformanceFilter');

    Route::get('skill/performance/view/by/test/{classId}/{userId}','Reports\TeacherReportsController@skillPerformanceViewbyTest')->where('classId', '[0-9]+')->where('userId', '[0-9]+')->name('skillPerformanceViewbyTest');

    Route::get('exercise/set/report/{classId}/{userId}/{skillId}','Reports\TeacherReportsController@exerciseSetReport')->where('classId', '[0-9]+')->where('userId', '[0-9]+')->where('skillId', '[0-9]+')->name('exerciseSetReport');

    Route::get('exercise/set/report/exam/{classId}/{userId}/{examId}','Reports\TeacherReportsController@exerciseSetReportTest')->where('classId', '[0-9]+')->where('userId', '[0-9]+')->where('examId', '[0-9]+')->name('exerciseSetReportExam');

    Route::get('recent/activities/{userId}','Reports\TeacherReportsController@allActivities')->name('allActivities');
});

// Sign up
Route::get('/signup', function () {
    return view('auth.signup_date');
})->name('signup');

// Sign up 2
Route::post('/signup_2', function () {
    return view('auth.signup_2');
})->name('signup_2');

// Sign up 3
Route::get('/signup_3', function () {
    return view('auth.signup_3');
})->name('signup_3');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/editor', function () {
    return view('bulkeditor');
})->name('editor');

Route::get('/api_question/{id}', 'Exercises\QuestionsController@api_question')
    ->name('questions.question.api_question')
    ->where('id', '[0-9]+');

Route::get('/api_answer/{id}', 'Exercises\QuestionsController@api_answer')
    ->name('questions.question.api_answer');

Route::post('/signup_date', 'Auth\RegisterController@signup_date')
    ->name('signup_date');

Route::post('/signup_topics', 'Auth\RegisterController@signup_topics')
    ->name('signup_topics.signup');

Route::post('/signup_1', 'Auth\RegisterController@signup_1')
    ->name('signup_1');

Route::post('/', 'Auth\RegisterController@signup_2')->name('signup_2');

//home
Route::get('/home','HomeController@index')->name('home');

Route::post('/language/{lang}',array(
                'Middleware'=>'LanguageSwitcher',
                'uses'=>'LanguagesController@switch' ))
                ->name('language.switch');

Route::post('/login', 'Auth\LoginController@login');
Route::post('/dd', 'Auth\LoginController@login');

//Develop by WB
Route::group(
    [
        'prefix' => 'mail',
    ], function () {

    Route::post('/exerciseset', 'Mails\MailController@mailSendForExerciseset')
        ->name('mail.exerciseset');

        Route::post('/assignment', 'Mails\MailController@mailSendForAssignment')
        ->name('mail.assignment');


    Route::get('exerciseset/show/{exerciseset}/{ispublic?}','Mails\MailController@show')
    ->name('mail.exerciseset.show')
    ->where('id', '[0-9]+');

});


Route::group(
    [
        'prefix' => 'explore',
    ], function () {

    /*Route::get('/{tab?}', function(){
        return view('eduplaycloud.explore.index');
    })->name('explore');*/
 
    Route::get('/disciplines', 'ExploreController@explorediscipline')
        ->name('explore');
    
    Route::get('/one/discipline', 'ExploreController@getExploreOneDiscipline')
        ->name('explore.curriculum.single');
    
    Route::get('/discipline/create', 'ExploreController@createCurriculumDetails')
        ->name('explore.curriculum.create');

    Route::post('/discipline/create', 'ExploreController@storeCurriculumDetails')
        ->name('explore.curriculum.store');


    Route::get('/disciplines/filter','ExploreController@exploreDisciplineFilter')
        ->name('explore.disciplines.filter');

    Route::get('/exerciseset', 'ExploreController@exploreexerciseset')
        ->name('explore.exerciseset');
    

    Route::get('/classes', 'ExploreController@exploreclasses')
        ->name('explore.classes');

    Route::get('/disciplines/summary/{id}','ExploreController@disciplineSummary')
        ->name('explore.discipline.summary')
        ->where('id', '[0-9]+');
    
    Route::get('/disciplines/published/{id}','ExploreController@latestPublished')
        ->name('explore.discipline.published')
        ->where('id', '[0-9]+');
    
    Route::get('/disciplines/draft/{id}','ExploreController@latestDraft')
        ->name('explore.discipline.draft')
        ->where('id', '[0-9]+');
    
    Route::get('/disciplines/draft/skill/{id}','ExploreController@latestDraftSkillWise')
        ->name('explore.discipline.draft.skill')
        ->where('id', '[0-9]+');    
    Route::get('/curriculumn/exercisesets','ExploreController@curriculumnExerciseset')
        ->name('explore.curriculum.exerciseset');
    Route::get('/curriculumn/classes','ExploreController@curriculumnClasses')
        ->name('explore.curriculum.classes');

    Route::get('/curriculumn/skill-list/{curriculumn_id}','ExploreController@getCurriculumSkillList')
        ->name('explore.curriculum.skill-list');
    
});

Auth::routes();

// Unauthorized
Route::get('/unauthorized', function () {
    return redirect('/public');
})->name('unauthorized');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

// Role
Route::group(
    [
        'prefix' => 'roles',
    ], function () {

   /* Route::get('/', 'RolesController@listroles')
        ->name('roles.list');*/
});

// Schools
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

// Countries
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

// Curricula
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

// Grades
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

// Activities
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

// Badges
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

// Business rules
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

// Invited users
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

    //Develop by Wc
    Route::get('/child/password-change','User\InvitedusersController@childResetPassword')->name('child-password-change');
});

// Languages
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

// News letter subscriptions
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

// Notification actions
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

// Pending tasks
Route::group(
    [
        'prefix' => 'pendingtasks',
    ], function () {

    Route::get('/', 'User\\@index')
        ->name('pendingtasks.pendingtask.index');

    Route::get('/mypendingtasks', 'User\PendingtasksController@mylist')
        ->name('pendingtasks.mypendingtasks');

    /* prepare by WC */
    Route::get('/mypendingtasks/filter','User\PendingtasksController@mylistFilter');

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

// Class exercises
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

// Exercise set buyers
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

// Exercise sets
Route::group(
    [
        'prefix' => 'exercisesets',
    ], function () {

    Route::get('/', 'Exercises\ExercisesetsController@index')
        ->name('exercisesets.exerciseset.index');

    Route::get('/create','Exercises\ExercisesetsController@create')
        ->name('exercisesets.exerciseset.create');

    Route::get('/show/{exerciseset}/{ispublic?}','Exercises\ExercisesetsController@show')
        ->name('exercisesets.exerciseset.show')
        ->where('id', '[0-9]+');

    //Select curriculum when create new exersice set.
    // Develop by WP
    Route::get('/select-curriculum','Exercises\ExercisesetsController@selectCurriculum')
        ->name('exercisesets.exerciseset.select-curriculum');
    //Select grade with curriculum selected.
    // Develop by WP
    Route::post('/select-curriculum/grade','Exercises\ExercisesetsController@selectGradeWithCurriculum')
        ->name('exercisesets.exerciseset.grade');
    //Select curriculum filter
    Route::get('select-curriculum/filter','Exercises\ExercisesetsController@selectCurriculumFilter');

    Route::get('/summary/{exerciseset}/{ispublic}','Exercises\ExercisesetsController@summary')
        ->name('exercisesets.exerciseset.summary')
        ->where('id', '[0-9]+');

    Route::get('/{exerciseset}/edit','Exercises\ExercisesetsController@edit')
        ->name('exercisesets.exerciseset.edit')
        ->where('id', '[0-9]+');

    Route::put('/', 'Exercises\ExercisesetsController@store')
        ->name('exercisesets.exerciseset.store');

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

    Route::post('/question/preview','Exercises\ExercisesetsController@QuestionAjaxCall');

    Route::post('/question-copy', 'Exercises\ExercisesetsController@QuestionsCopy')->name('exercise.copy.question');
    Route::post('/question-move', 'Exercises\ExercisesetsController@QuestionsMove')->name('exercise.move.question');

    //Develop by WC
    //Publish to class
    Route::get('pusblish-to-class','Exercises\ExercisesetsController@publishToClass');
    Route::get('pins/pusblish-to-class','Exercises\ExercisesetsController@pinspublishToClass');

    Route::get('pusblish-to-googleclass','Exercises\ExercisesetsController@publishToGoogleclass');
    
    Route::get('/filter', 'Exercises\ExercisesetsController@myPrivateLibraryFilter')
        ->name('exercisesets.exerciseset.filter');
    
    //  Pin Filter
    Route::get('/pins/filter', 'Exercises\ExercisesetsController@pinsFilter')
        ->name('exercisesets.exerciseset.filter');

    Route::get('/importform/{exerciseset}', 'Exercises\ExercisesetsController@importform')
        ->name('exercisesets.exerciseset.importform');

    //bluk import
    Route::post('/import-bulk', 'Exercises\ExercisesetsController@storeImportBulkQuestion')
        ->name('exercisesets.importform.store');
    //Import bulk result display.
   Route::get('/import-bulk/{exerciseset}/result', 'Exercises\ExercisesetsController@getImportBulkResult')
    ->name('exercisesets.importbulk.result');

    Route::post('/import/{exerciseset}', 'Exercises\ExercisesetsController@import')
        ->name('exercisesets.exerciseset.import')
        ->where('id', '[0-9]+');

    Route::post('/addrate', 'Exercises\ExercisesetsController@addrate')
        ->name('exercisesets.exerciseset.addrate');

    Route::post('/addtomylibrary/{exerciseset}', 'Exercises\ExercisesetsController@addtomylibrary' )
        ->name('exercisesets.exerciseset.addtomylibrary')
        ->where('id', '[0-9]+');

    Route::get('/removefrommylibrary/{exerciseset}', 'Exercises\ExercisesetsController@removefrommylibrary' )
    ->name('exercisesets.exerciseset.removefrommylibrary')
    ->where('id', '[0-9]+');

    Route::get('/buyexercise/{exerciseset}', 'Exercises\PracticeController@buyexercise' )
            ->name('exercisesets.buyexercise')
            ->where('id', '[0-9]+');

     Route::post('/buy/{exerciseset}', 'Exercises\PracticeController@buy' )
           ->name('exercisesets.buy')
           ->where('id', '[0-9]+');

    Route::post('/addreview', 'Exercises\ExercisesetsController@addreview')
        ->name('exercisesets.exerciseset.addreview');


    Route::get('/getgrades/{discipline}/{language}','Exercises\ExercisesetsController@getgrades')
        ->name('classexercises.classexercise.getgrades')
        ->where('id', '[0-9]+');

    Route::get('/getgradeslist/{discipline}/{language}','HomeController@getgrades')
        ->name('classexercises.classexercise.getgrades')
        ->where('id', '[0-9]+');

    Route::get('/getClassgrades/{discipline}','Exercises\ExercisesetsController@getClassgrades')
        ->name('classexercises.classexercise.getClassgrades')
        ->where('id', '[0-9]+');

    //Develop By WC
    Route::get('/listall','Exercises\ExercisesetsController@getAdminExerciseList')
          ->name('admin.exercise.index');

    Route::get('admin/create','Exercises\ExercisesetsController@getAdminExerciseCreate')
         ->name('admin.exercise.create');

    Route::get('admin/show/{exercise}','Exercises\ExercisesetsController@getAdminExerciseShow')
         ->name('admin.exercise.show')
         ->where('id', '[0-9]+');

    Route::get('admin/{exercise}/edit','Exercises\ExercisesetsController@getAdminExerciseEdit')
         ->name('admin.exercise.edit')
         ->where('id', '[0-9]+');

    Route::post('admin/store', 'Exercises\ExercisesetsController@getAdminExerciseStore')
         ->name('admin.exercise.store');

    Route::put('admin/exercise/{exercise}', 'Exercises\ExercisesetsController@getAdminExerciseUpdate')
         ->name('admin.exercise.update')
         ->where('id', '[0-9]+');

    Route::delete('admin/exercise/{exercise}','Exercises\ExercisesetsController@getAdminExerciseDestroy')
         ->name('admin.exercise.destroy')
         ->where('id', '[0-9]+');

    Route::get('/getdisciplies/{laungauge}/{topicid}','Exercises\ExercisesetsController@getdisciplies');
    Route::get('/getdisciplieslist/{laungauge}/{topicid}','HomeController@getdisciplies');

    Route::get('/get/skills','Exercises\ExercisesetsController@getSkillsBySkillCateId');

    Route::get('/question/image/upload','Exercises\ExercisesetsController@getQuestionImageUpload');

    Route::delete('owner/delete/{exerciseset}','Exercises\ExercisesetsController@ownerDestroy')
    ->name('exercisesets.owner.destroy');
});

// Class learners
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

// Course classes
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

    Route::get('/pins/filter','Course\CourseclassesController@pinsFilter');

    Route::post('/teacher/update','Course\CourseclassesController@teacherAboutUpdate')
         ->name('courseclasses.courseclass.teacher');

    Route::get('/{courseclass}/edit','Course\CourseclassesController@edit')
         ->name('courseclasses.courseclass.edit')
         ->where('id', '[0-9]+');

    Route::post('/', 'Course\CourseclassesController@store')
         ->name('courseclasses.courseclass.store');

    Route::post('courseclass/{courseclass}', 'Course\CourseclassesController@update')
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
    
    Route::post('/invitenonlearner/','Course\CourseclassesController@invitenonlearner')
        ->name('CourseclassesController.classlearner.invitenonlearner');

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

    // WC- Comment for new flow implimentation
    Route::post('/addexam/{courseclassid}/{examid}','Course\CourseclassesController@addexam')
        ->name('courseclasses.courseclass.addexam')
        ->where('id', '[0-9]+'); 
    
    Route::post('/addexam/{courseclassid}','Course\CourseclassesController@addexam')
        ->name('courseclasses.courseclass.addexam')
        ->where('id', '[0-9]+');

    Route::get('/removeexam/{classId}/{classexamid}/','Course\CourseclassesController@removeexam')
        ->name('courseclasses.courseclass.removeexam')
        ->where('id', '[0-9]+');

    Route::post('/removeexercise/{courseclassid}/{exerciseid}','Course\CourseclassesController@removeexercise')
        ->name('courseclasses.courseclass.removeexercise')
        ->where('id', '[0-9]+');

    Route::post('/isavailableclass/{courseclassid}','Course\CourseclassesController@isavailableclass')
        ->name('courseclasses.courseclass.isavailableclass')
        ->where('id', '[0-9]+');
    //Develop by Wc.
    Route::post('/learner/remove','Course\CourseclassesController@removeClassLearner');

    Route::get('/assignment/filter', 'Course\CourseclassesController@assignmentFilter');

    Route::get('/class/filter','Course\CourseclassesController@getClassFilter');

    Route::post('/addreview', 'Course\CourseclassesController@addClassReview')
        ->name('courseclasses.courseclass.addclassreview');

    Route::delete('/assignments/{id}','Course\CourseclassesController@assignmentDelete')
        ->name('courseclasses.assignments.delete');
    // add exam to class
    Route::get('/addexamtoclass/{courseclassid}','Course\CourseclassesController@addexamtoclass')
        ->name('courseclasses.courseclass.addexamtoclass')
        ->where('id', '[0-9]+');
    //Edit exam date.
    Route::post('/editexamdate', 'Course\CourseclassesController@updateExamDate')
        ->name('courseclasses.edit.examdate');

    Route::get('/assignment/details/{id}/{class_id}','Course\CourseclassesController@classAssignmentDetails')
        ->name('courseclasses.assigment.detail');

    Route::get('/google-classes','Course\CourseclassesController@getGoogleClasses')
        ->name('courseclasses.google.classes');

    Route::get('/google-classes/create','Course\CourseclassesController@createGoogleClasses')
        ->name('courseclasses.google.classescreate');

    Route::post('/import/google-class','Course\CourseclassesController@importGoogleClasses')
        ->name('courseclasses.google.import');
    
    Route::delete('gclass/delete/{classid}','Course\CourseclassesController@gclassDestroy')
        ->name('courseclasses.google.destroy');
}); 

// Course classes
Route::group(
  [
      'prefix' => 'google-classroom',
  ], function () {
        Route::get('/{classId}/show','Course\GoogleClassRoomController@googleClassroomDetails')
              ->name('google.classroom.details');
        Route::post('/{classId}/update','Course\GoogleClassRoomController@classroomUpdate')
              ->name('google.classroom.update');
        Route::get('/student/{classid}/import','Course\GoogleClassRoomController@importClassStudent')
              ->name('classroom.student.import');

        Route::post('/learner/remove','Course\GoogleClassRoomController@removeGoogleClassLearner');

        Route::post('/removeexercise/{courseclassid}/{exerciseid}','Course\GoogleClassRoomController@removeexercise')
        ->name('classroom.exercise.removeexercise')
        ->where('id', '[0-9]+');

        // add exam to class
        Route::get('/addexamtoclass/{courseclassid}','Course\GoogleClassRoomController@addexamtoclass')
        ->name('classroom.exam.addexamtoclass')
        ->where('id', '[0-9]+');

        Route::post('/addexam/{courseclassid}','Course\GoogleClassRoomController@addexam')
        ->name('classroom.exam.addexam')
        ->where('id', '[0-9]+');

        Route::get('/removeexam/{classId}/{classexamid}/','Course\GoogleClassRoomController@removeexam')
        ->name('classroom.exam.removeexam')
        ->where('id', '[0-9]+');

        Route::get('mail', function(){
            return view('mails.sendgooglestudentinvitation');
        });
  });


// Class exams
Route::group(
    [
        'prefix' => 'classexams',
    ], function () {

    Route::get('/', 'Course\ClassexamsController@index')
        ->name('classexams.classexam.index');

    Route::get('/create','Course\ClassexamsController@create')
        ->name('classexams.classexam.create');

    Route::get('/show/{classexam}','Course\ClassexamsController@show')
        ->name('classexams.classexam.show')
        ->where('id', '[0-9]+');

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

// Exams
Route::group(
    [
        'prefix' => 'exams',
    ], function () {

    Route::get('/', 'Exams\ExamsController@index')
        ->name('exams.exam.index')
        ->where('page','[A-Z,0-9]+');

    Route::get('/filter','Exams\ExamsController@myAssigmentDisplayFiltered');

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

    //Route::get('/{exam}/{page}/edit','Exams\ExamsController@edit')
    Route::get('/{exam}/{page}/edit','Exams\ExamsController@create_firstpage')
        ->name('exams.exam.edit')
        ->where('id', '[0-9]+');

    Route::put('/{classId?}', 'Exams\ExamsController@store')
        ->name('exams.exam.store');

    Route::post('exam/{exam}', 'Exams\ExamsController@update')
        ->name('exams.exam.update')
        ->where('id', '[0-9]+');

    Route::get('/exam/{exam}','Exams\ExamsController@destroy')
        ->name('exams.exam.destroy')
        ->where('id', '[0-9]+');
    /* Prepare by WC */
    Route::post('/getCurriculam','Exams\ExamsController@getCurriculam')
        ->name('Exams.exam.getCurriculam');

    Route::post('/getExercisesset','Exams\ExamsController@getExercisesset')
        ->name('Exams.exam.getExercisesset');

    Route::get('/topics/filter/{edit?}','Exams\ExamsController@create_firstpage');

    Route::get('/curriculum/filter','Exams\ExamsController@curriculumFiltes');

    Route::get('/exercisesset/filter','Exams\ExamsController@getExercisessetFilter');

    Route::get('/skill/filter','Exams\ExamsController@getskillFilter');

    Route::post('/getSkillCategories','Exams\ExamsController@getSkillCategories')
        ->name('Exams.exam.getSkillCategories');

    Route::post('/getQuestions','Exams\ExamsController@getQuestions')
        ->name('Exams.exam.getQuestions');

    Route::get('/getQuestions/filter','Exams\ExamsController@getQuestionsByFilter');

    Route::post('/getSelectedQuestions','Exams\ExamsController@getSelectedQuestions')
        ->name('Exams.exam.getSelectedQuestions');

    Route::get('/exportExam/{exam}','Exams\ExamsController@exportExam')
        ->name('exams.exam.exportExam')->where('id', '[0-9]+');

    Route::post('/exportExam/{exam}','Exams\ExamsController@exportExamPost')
    ->name('exams.exam.exportExam')->where('id', '[0-9]+');
        //->name('exams.exam.exportExam')->where('id', '[0-9]+');

    Route::get('/mero/question','Exams\ExamsController@addedNewQuestion');

    Route::post('/updateExamStatus/{exam}','Exams\ExamsController@updateExamStatus')
    ->name('exams.exam.updateExamStatus');
});

// Exam questions
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

// Questions
Route::group(
    [
        'prefix' => 'questions',
    ], function () {

    Route::get('/', 'Exercises\QuestionsController@index')
        ->name('questions.question.index');

    Route::get('/create','Exercises\QuestionsController@create')
        ->name('questions.question.create');

    Route::get('/show/{question}','Exercises\QuestionsController@show')
        ->name('questions.question.show')
        ->where('id', '[0-9]+');

    Route::get('/{question}/edit','Exercises\QuestionsController@edit')
        ->name('questions.question.edit')
        ->where('id', '[0-9]+');

    Route::post('/store', 'Exercises\QuestionsController@store')
        ->name('questions.question.store');


    Route::put('question/{question}', 'Exercises\QuestionsController@update')
        ->name('questions.question.update')
        ->where('id', '[0-9]+');

    Route::delete('/question/{question}','Exercises\QuestionsController@destroy')
        ->name('questions.question.destroy')
        ->where('id', '[0-9]+'); 

    Route::get('/show/{question}','Exercises\QuestionsController@nestshow')
        ->name('questions.question.nestshow')
        ->where('id', '[0-9]+');

    Route::post('/{question}/edit_question', 'Exercises\QuestionsController@edit_question')
        ->name('questions.question.edit_question')
        ->where('id', '[0-9]+');

    Route::get('/edit_question/{question}', 'Exercises\QuestionsController@edit_question')
        ->name('questions.question.edit_question_new')
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
    
    //Develop by wc
    // This is for select curriculum for question's selected
    Route::get('/curriculum','Exercises\QuestionsController@postQuestionsLinkToSkill')
        ->name('questions.question.curriculum');

    Route::post('/curriculum','Exercises\QuestionsController@postQuestionsLinkToSkill')
        ->name('questions.question.curriculum');
    
    Route::get('link/select-curriculum/filter','Exercises\QuestionsController@LinkToSkillSelectCurriculumFilter');

    Route::get('/curriculum/grade','Exercises\QuestionsController@insertCurriculumToExerciseset')
        ->name('questions.exerciseset.grade');

    Route::post('/curriculum/grade','Exercises\QuestionsController@insertCurriculumToExerciseset')
        ->name('questions.exerciseset.grade');
    
    //Questions filter
    Route::get('/{exercise}/filter','Exercises\QuestionsController@getQuestionsFilter');

    Route::post('/linked','Exercises\QuestionsController@questionsLinked')
        ->name('questions.linked');

});

// Answer options
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

    Route::post('/store', 'Exercises\AnsweroptionsController@store')
        ->name('answeroptions.answeroption.store');

    Route::put('answeroption/{answeroption}', 'Exercises\AnsweroptionsController@update')
        ->name('answeroptions.answeroption.update')
        ->where('id', '[0-9]+');

    Route::delete('/answeroption/{answeroption}','Exercises\AnsweroptionsController@destroy')
        ->name('answeroptions.answeroption.destroy')
        ->where('id', '[0-9]+');

    // Route for edit answer in the exerciseset show page
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

// Discipline collaborators
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

// Disciplines
Route::group(
[
    'prefix' => 'disciplines',
], function () {

    Route::get('/', 'Disciplines\DisciplinesController@index')
         ->name('disciplines.discipline.index');

    Route::get('/listall', 'Disciplines\DisciplinesController@listall')
        ->name('disciplines.discipline.listall');

    Route::get('/create','Disciplines\DisciplinesController@create')
         ->name('disciplines.discipline.create');

    Route::get('/show/{discipline}','Disciplines\DisciplinesController@show')
         ->name('disciplines.discipline.show')
         ->where('id', '[0-9]+');
    
    Route::get('/copy/{discipline}','Disciplines\DisciplinesController@copy')
         ->name('disciplines.discipline.copy')
         ->where('id', '[0-9]+'); 

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

// Collaboration
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

// Practice as guest, user answer 5 question and then return back to login / registration
Route::group (
    ['prefix'=>'guestpractice'],function (){

    Route::get('/guest/guestpractice', 'Exercises\GuestPracticeController@guestpractice')
        ->name('guest.guestpractice');    
        
    Route::post('/guest/guestpractice', 'Exercises\GuestPracticeController@guestpractice')
        ->name('guest.guestpractice')
        ->where('id', '[0-9]+');

        

// Route::get('/guest/guestpractice', 'Exercises\GuestPracticeController@guestpractice')
//     ->name('guest.guestpractice')
//     ->where('id', '[0-9]+');

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

// Practice to exsrcie set
Route::group (
    ['prefix'=>'practice-old'],function (){

    Route::get('/{exerciseset}', 'Exercises\PracticeOldController@index')
        ->name('practice.old.index')
        ->where('id', '[0-9]+');

    Route::get('/disciplinepractice/{userinterest_id}', 'Exercises\PracticeOldController@disciplinepractice')
        ->name('practice.old.disciplinepractice')
        ->where('id', '[0-9]+');

    Route::get('/next/{nextquestion}', 'Exercises\PracticeOldController@nextquestion')
        ->name('practice.old.question.nextquestion')
        ->where('id', '[0-9]+');

    Route::get('/nextquestion_interset/{nextquestion}/{userinterest_id}', 'Exercises\PracticeOldController@nextquestion_interset')
        ->name('practice.old.question.nextquestion_interset')
        ->where('id', '[0-9]+');

    Route::get('/answer/{answerid}' ,'Exercises\PracticeOldController@clickedanswer')
        ->name('practice.old.answer.clickedanswer')
        ->where('id', '[0-9]+');

    Route::get('/question/{questionid}' ,'Exercises\PracticeOldController@correctanswer')
        ->name('practice.old.question.correctanswer')
        ->where('id', '[0-9]+');

    Route::get('/result/{exerciseset}/{userinterest_id?}' ,'Exercises\PracticeOldController@result')
        ->name('practice.old.question.result')
        ->where('id', '[0-9]+');

});

// Practice to exsrcie set
Route::group (
    ['prefix'=>'practice'],function (){
        Route::get('/disciplinepractice','Exercises\PracticeController@userPractice')
        ->name('practice.userdisciplinepractice');
    Route::post('/report-problem','Exercises\PracticeController@reportProblem')
        ->name('practice/report-problem');

    Route::post('/finish','Exercises\PracticeController@finishPractice')
        ->name('practice.finish');

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
        
    //Develop by Wc.
    Route::post('/disciplinepractice','Exercises\PracticeController@userPractice')
        ->name('practice.userdisciplinepractice');

    Route::get('answer-report/{practice_token}','Exercises\PracticeController@getUserPracticeAnswerReport')
        ->name('practice.answer.report');
   
    
    Route::get('/next/questions','Exercises\PracticeController@nextQuestion');
    Route::get('/answere/store','Exercises\PracticeController@storeAnswereToPracticeTable');
});


// Take an Exam
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

    
    Route::get('/n/n/next/{questionid}', 'Exams\TakeexamController@nextSessionQuestion')
        ->name('takeexam.next.question');

    /*Route::get('/question/{questionid}' ,'Exams\TakeexamController@correctanswer')
        ->name('practice.question.correctanswer')
        ->where('id', '[0-9]+');
    Route::get('/result/{exerciseset}' ,'Exams\TakeexamController@result')
        ->name('practice.question.result')
        ->where('id', '[0-9]+');*/
});

// Knowledgemap
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

// Discipline versions
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

// Skill categories
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

// Skills
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

// Pins : Developed by WC
Route::group(
[
    'prefix' => 'pins',
], function () {
    
    Route::post('/create', 'Pins\PinsController@store')
            ->name('pins.pin.store');

    Route::get('/{pin}/edit','Pins\PinsController@edit')
            ->name('pins.pin.edit')
            ->where('id', '[0-9]+');

    Route::post('pin', 'Pins\PinsController@update')
            ->name('pins.pin.update');
    
    Route::get('/pin/{id}','Pins\PinsController@destroy')
        ->name('pins.pin.destroy')
        ->where('id', '[0-9]+');
            
});

// Avatars : Developed by WC
Route::group(
    [
        'prefix' => 'avatars',
    ], function () {
        Route::get('/', 'Avatars\AvatarsController@getAvatarForAdmin')
              ->name('avatars.admin.avatar');
        
        Route::get('/create','Avatars\AvatarsController@avatarCreate')
              ->name('avatars.avatar.create');
        
        Route::post('/store', 'Avatars\AvatarsController@avatarStore')
              ->name('avatars.avatar.store');

        Route::get('/{avatar}/edit','Avatars\AvatarsController@avataredit')
              ->name('avatars.avatar.edit')
              ->where('id', '[0-9]+');

        Route::put('avatar/{avatar}', 'Avatars\AvatarsController@avatarupdate')
              ->name('avatars.avatar.update')
              ->where('id', '[0-9]+');

        Route::delete('/avatar/{id}','Avatars\AvatarsController@avatarDestroy')
              ->name('avatars.avatar.destroy')
              ->where('id', '[0-9]+');

        Route::get('/accessories', 'Avatars\AvatarsController@getAccessoriesForAdmin')
              ->name('avatars.avatar.accessories');
        
        Route::get('/accessories/create', 'Avatars\AvatarsController@avatarAccessoriesCreate')
              ->name('avatars.accessories.create');
        
        Route::post('/accessories/store', 'Avatars\AvatarsController@avatarAccessoriesStore')
              ->name('avatars.accessories.store');
        
        Route::get('accessories/{accessories}/edit', 'Avatars\AvatarsController@avatarAccessoriesEdit')
              ->name('avatars.accessories.edit');
        
        Route::put('/{accessories}/accessories/update', 'Avatars\AvatarsController@avatarAccessoriesUpdate')
              ->name('avatars.accessories.update')
              ->where('id', '[0-9]+');

        Route::delete('/accessories/{id}','Avatars\AvatarsController@avatarAccessoriesDestroy')
              ->name('avatars.accessories.destroy')
              ->where('id', '[0-9]+');
        
        Route::get('/accessories/{id}', 'Avatars\AvatarsController@getAccessories')
              ->name('avatars.avatar.avatars');
    
        Route::post('/update-avatar','Avatars\AvatarsController@updateAvatar')
              ->name('update-avatar');

    });

// Tour : Developed By : WC
Route::group(
    [
        'prefix' => 'tours',
    ], function () {
        
    Route::get('/update/{status}', 'Controller@updateUserTourStatus')
            ->name('tours.tour.update');
                
});

// Topics
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

    Route::post('/settings', 'Disciplines\TopicsController@viewSettings')
        ->name('settings');

    Route::get('/exercisesets', 'Disciplines\TopicsController@exercisesets')
        ->name('topics.topic.exercisesets');
    
        //Develop by wc
    Route::get('/exercisesets/filter','Disciplines\TopicsController@topicExerciseFilter');

    Route::get('/get/userintrested','Disciplines\TopicsController@getUserIntrested');

    Route::get('/skill-categories','Disciplines\TopicsController@getskillCategoriesByExercisesets')  
            ->name('topics.exercisesets.skill');
    
    Route::get('/exercise/practice','Disciplines\TopicsController@getPracticeByExercisesets')
            ->name('topics.exercisesets.practice');

    Route::post('/add','Disciplines\TopicsController@add')
            ->name('topics.topic.add');

});

// Skill mastery
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

// User activity logs
Route::group(
[
    'prefix' => 'useractivitylogs',
], function () {

    Route::get('/user/{id}', 'User\UseractivitylogsController@index')
         ->name('useractivitylogs.useractivitylog.index');

    Route::get('/create/{id}','User\UseractivitylogsController@create')
         ->name('useractivitylogs.useractivitylog.create');

    Route::get('/show/{useractivitylog}','User\UseractivitylogsController@show')
         ->name('useractivitylogs.useractivitylog.show')
         ->where('id', '[0-9]+');

    Route::get('/{useractivitylog}/edit','User\UseractivitylogsController@edit')
         ->name('useractivitylogs.useractivitylog.edit')
         ->where('id', '[0-9]+');

    Route::post('/user/{id}', 'User\UseractivitylogsController@store')
         ->name('useractivitylogs.useractivitylog.store');

    Route::put('useractivitylog/{useractivitylog}', 'User\UseractivitylogsController@update')
         ->name('useractivitylogs.useractivitylog.update')
         ->where('id', '[0-9]+');

    Route::delete('/useractivitylog/{useractivitylog}','User\UseractivitylogsController@destroy')
         ->name('useractivitylogs.useractivitylog.destroy')
         ->where('id', '[0-9]+');

});

// User badges
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

// User exam answers
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

// User exam scores
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

// User interests
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

    Route::post('/updateusertopic', 'User\UserinterestsController@updateUserTopic')
        ->name('updateusertopic');

});

// User notifications
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

// Plans
Route::resource('admin/plans', 'Admin\Plans\PlansController');
Route::post('admin/plans/insert_option', 'Admin\Plans\PlansController@insertPlanOption')->name('insert_plan_option');
Route::post('admin/plans/update_option', 'Admin\Plans\PlansController@updatePlanOption')->name('update_plan_option');
Route::post('admin/plans/delete_option', 'Admin\Plans\PlansController@deletePlanOption')->name('delete_plan_option');


Route::resource('users/{user}/subscriptions', 'User\UserSubscriptionsController');

// Users
Route::group(
[
    'prefix' => 'users',
], function () {

    Route::get('/', 'User\UsersController@index')
         ->name('users.user.index');

    Route::get('/create','User\UsersController@create')
         ->name('users.user.create');

    Route::get('/show/{user}','User\UsersController@show')
         ->name('users.user.show')
         ->where('id', '[0-9]+');

         Route::get('/user/{user}/subscription','User\UsersController@userplans')
         ->name('users.user.subscriptions')
         ->where('id', '[0-9]+');

    Route::get('/profile/{user}','User\UsersController@getprofile')
        ->name('users.user.profile')
        ->where('id', '[0-9]+');

        Route::post('profile/{user}/updateinterests','User\UsersController@updateUserInterests')
        ->name('users.user.profile.update-interests')
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

    Route::get('/profile/parent_requests/create', 'Parent\ParentRequestsController@create')->name('createParentRequest');
    Route::post('/profile/parent_requests/store', 'Parent\ParentRequestsController@store')->name('storeParentRequest');
    Route::get('/profile/parent_requests/{id}/approve', 'Parent\ParentRequestsController@approve')->name('approveParentRequest');

    Route::post('/savechild/{user}', 'User\UsersController@savechild')
        ->name('invitedusers.inviteduser.savechild');

    //Development by WC.
    Route::get('/editchild/{user}', 'User\UsersController@editchild')
    ->name('invitedusers.inviteduser.editchild');

    Route::get('/deletechild/{user}', 'User\UsersController@deletechild');

    Route::post('/savechild/{user}/{child}', 'User\UsersController@updatechild')
    ->name('invitedusers.inviteduser.updateChild');
    
    Route::get('/childrenlist/{user}','User\UsersController@childrenlist')
        ->name('users.user.childrenlist')
        ->where('id', '[0-9]+');

    Route::post('change/password', 'User\UsersController@changePassword');
    //develop by wc
    Route::post('child/change/password', 'User\UsersController@childChangePassword');

    // Validation
    Route::post('validate/password', 'User\UsersController@validatePassword');

});

// Game details
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

// Game downloads
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

// Game kids
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

Route::get('/{game}/code/{codetype}/{code}','Games\GamesController@myGameCodeDisplay')
->name('games.my.codes-deeplink');


// Games
Route::group(
    [
        'prefix' => 'games',
    ], function () {

    Route::get('/', 'Games\GamesController@index')
        ->name('games.game.index');

    Route::get('/filter','Games\GamesController@getGameResult');

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
    
    Route::post('/addreview', 'Games\GamesController@addreview')
        ->name('games.game.addreview');

    Route::get('/my-reviews','Games\GamesController@myReviews')
        ->name('games.game.myreviews');

    Route::get('/view/{game}','Games\GamesController@onegame')
        ->name('games.game.view')
        ->where('id', '[0-9]+');

    Route::get('/get-reviews/{page}','Games\GamesController@getReviews')
        ->name('games.game.get-reviews')
        ->where('id', '[0-9,A-Z]+');

    Route::get('/game-download-store','Games\GamesController@storeDownload')
        ->name('games.download.store');
    
    Route::get('/my-codes','Games\GamesController@myGameCodeDisplay')
        ->name('games.my.codes');
    
  
    
    Route::post('/generate-code','Games\GamesController@postGenerateCode')
        ->name('games.generate.code');
    
        Route::get('/generate-exam-code/{id}','Games\GamesController@generateExamCode')
        ->name('games.generate.exam.code');

    Route::get('/addlearner/list','Games\GamesController@addlearner')
        ->name('games.learner.list');

    Route::post('/code/share','Games\GamesController@postShareCodeToLearner')
        ->name('games.code.share');
    
    Route::delete('code/delete/{codeId}','Games\GamesController@gamePreferenceDestroy')
        ->name('games.generate.destroy');

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

// Reset password
Route::post('password/reset/email', 'Auth\SendsPasswordResetEmailsController@sendResetLinkEmail');
Route::post('password/update', 'Auth\RegisterController@reset');
//Route::post('password/update', 'Auth\ResetPasswordController@reset');

// Register new user
Route::post('register/new/user', 'Auth\RegisterController@registerNewUser');
Route::post('validate/unique/email', 'UserHomeController@validateUniqueEmail');
Route::post('child/validate/unique/email', 'UserHomeController@validationUniqueChildEmail');
Route::get('notapprovedbyparent',function(){
    return view('notapprovedbyparent');
});

// arrprovedaccount
Route::get('/arrprovedAccount', 'Auth\RegisterController@arrprovedAccount')->name('arrprovedAccount');

Route::get('verify/{email}/{token}', 'Auth\RegisterController@verifyAccount')->name('verifyAccount');
// Invite User
Route::post('/inviteUsers','User\InvitedusersController@inviteUsers')->name('inviteUsers');
Route::get('/my-assets',"AssetsController@index")->name('myassets');
Route::get('/my-assets/download/{path}/{etc}',"AssetsController@getDownload")->name('myassetsDownload');
Route::get('/my-assets/delete/{path}/{etc}',"AssetsController@getdelete")->name('myassetsDelete');
Route::post('/my-assets/upload',"AssetsController@myassetsUpload")->name('myassetsUpload');
Route::get('/my-assets/calculate',"AssetsController@calculateDirectorySize");
Route::get('/my-assets/csv/exists',"AssetsController@checkFileExists")->name('myassets.csv.exists');
// getToKnowEduplay
Route::get('/get/to/know','Controller@getToKnowEduplay');

Route::group(
  [
      'prefix' => 'filter',
  ], function () {
      Route::get('/', 'FilterController@getUserFilter')
           ->name('filters.filter.getUserFilter');
      Route::get('/save', 'FilterController@saveUserFilter');
      Route::get('/delete', 'FilterController@deleteUserFilter');
      Route::get('/all-delete', 'FilterController@allFilterDataClear');
});

Route::get('/419',function(){
    return view('errors.419');
});