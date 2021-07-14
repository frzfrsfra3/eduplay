<?php
//namespace App\Http\Resources;
use Illuminate\Http\Request;
use \App\Http\Resources\QuestionCollection;
use \App\Http\Resources\DisciplineResources;
use \App\Http\Resources\QuestionResource;
use Illuminate\Routing\RouteGroup;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('gamepack/1.0/')->group(function ($appID) {
    Route::get('get_boot_config' , 'GamePackAPI\GamePackController@getBootConfig');
    Route::post('profile/login' , 'GamePackAPI\AuthController@profile');
    Route::post('profile/validate' , 'GamePackAPI\AuthController@validate_profile');
    Route::put('profile/update' , 'GamePackAPI\AuthController@update');
    Route::get('topics', 'GamePackAPI\TopicsController@index');
    Route::get('curriculums', 'GamePackAPI\CurriculumsController@index');
    Route::get('skill_categories', 'GamePackAPI\SkillCategoriesController@index');
    Route::get('skills', 'GamePackAPI\SkillsController@index');
    Route::post('game_preferences/{user_id}', 'GamePackAPI\GamePreferencesController@index');
    Route::post('get_questions', 'GamePackAPI\QuestionsController@getQuestions');
    //Route::get('get_questions', 'GamePackAPI\QuestionsController@getQuestions');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/asas', function ($id) {
    return "Cool";
});

// the route should take me to a controller for the api
Route::get('/question',function () {
    return new QuestionResource(\App\Models\Question::find(1));
});

// the route should take me to a controller for the api
Route::post('/question',function () {
    return new QuestionResource(\App\Models\Question::find(1));
});

// the route should take me to a controller for the api
Route::get('/questions',function () {
    return new QuestionCollection(\App\Models\Question::all());
});

Route::post('/questions',function () {
    return new QuestionCollection(\App\Models\Question::all());
});


Route::get('/disciplines','API\APIDisciplines@disciplines') ;

Route::post('/disciplines','API\APIDisciplines@disciplines') ;

Route::get('/getlistoftopics','API\APIDisciplines@getlistoftopics') ;

Route::post('/getlistoftopics','API\APIDisciplines@getlistoftopics') ;

//Route::get('register', 'API\APIRegisterUser@register');

Route::get('register', 'API2\RegistrationController@register');
Route::post('register', 'API2\RegistrationController@register');
Route::post('verifyuser', 'API2\RegistrationController@verifyUser');

Route::get('forgetpassword', 'API\APIRegisterUser@forgetpassword');

Route::post('forgetpassword', 'API\APIRegisterUser@forgetpassword');

Route::get('getexersises', 'API\APIExercises@getexersises');

Route::post('getexersises', 'API\APIExercises@getexersises');

Route::get('getskillcategories','API\APIExercises@getSkillCategories');

Route::post('getskillcategories','API\APIExercises@getSkillCategories');

Route::get('getskills','API\APIExercises@getSkills');

Route::post('getskills','API\APIExercises@getSkills');

Route::get('login', 'API\APIRegisterUser@login');

Route::post('login', 'API\APIRegisterUser@login');

Route::get('changepassword', 'API\APIRegisterUser@changepassword');

Route::post('changepassword', 'API\APIRegisterUser@changepassword');

Route::get('getuserinfo', 'API\APIPreferences@getuserinfo');

Route::post('getuserinfo', 'API\APIPreferences@getuserinfo');

Route::get('loginsocialmedia', 'API\APIRegisterUser@loginsocialmedia');

Route::post('loginsocialmedia', 'API\APIRegisterUser@loginsocialmedia');

Route::get('setuserinterests', 'API\APIDisciplines@setuserinterests');

Route::post('setuserinterests', 'API\APIDisciplines@setuserinterests');

Route::get('unsetuserinterests', 'API\APIDisciplines@unsetuserinterests');

Route::post('unsetuserinterests', 'API\APIDisciplines@unsetuserinterests');

Route::get('getuserinterests', 'API\APIDisciplines@getuserinterests');

Route::post('getuserinterests', 'API\APIDisciplines@getuserinterests');

Route::get('setuserprofile', 'API\APIUserProfile@setuserprofile');

Route::post('setuserprofile', 'API\APIUserProfile@setuserprofile');

Route::get('getallschools', 'API\APISchool@getallschools');

Route::post('getallschools', 'API\APISchool@getallschools');

Route::get('getschool', 'API\APISchool@getschool');

Route::post('getschool', 'API\APISchool@getschool');

Route::get('getallgrades', 'API\APIGrades@getallgrades');

Route::post('getallgrades', 'API\APIGrades@getallgrades');

Route::get('getgrade', 'API\APIGrades@getgrade');

Route::post('getgrade', 'API\APIGrades@getgrade');

Route::get('setuserrole', 'API\APIPreferences@setuserrole');

Route::post('setuserrole', 'API\APIPreferences@setuserrole');

Route::get('unsetuserrole', 'API\APIPreferences@unsetuserrole');

Route::post('unsetuserrole', 'API\APIPreferences@unsetuserrole');

Route::get('getuserrole', 'API\APIPreferences@getuserrole');

Route::post('getuserrole', 'API\APIPreferences@getuserrole');

Route::get('setuserpreferences', 'API\APIPreferences@setuserpreferences');

Route::post('setuserpreferences', 'API\APIPreferences@setuserpreferences');

Route::get('getuserpreferences', 'API\APIPreferences@getuserpreferences');

Route::post('getuserpreferences', 'API\APIPreferences@getuserpreferences');

Route::get('unsetuserpreferences', 'API\APIPreferences@unsetuserpreferences');

Route::post('unsetuserpreferences', 'API\APIPreferences@unsetuserpreferences');

Route::get('getlanguages', 'API\APILanguage@getlanguages');

Route::post('getlanguages', 'API\APILanguage@getlanguages');

Route::get('getlanguage', 'API\APILanguage@getlanguage');

Route::post('getlanguage', 'API\APILanguage@getlanguage');

Route::get('getallbadges', 'API\APIBadge@getallbadges');

Route::post('getallbadges', 'API\APIBadge@getallbadges');

Route::get('getbadge', 'API\APIBadge@getbadge');

Route::post('getbadge', 'API\APIBadge@getbadge');

Route::get('getuserbadges', 'API\APIBadge@getuserbadges');

Route::post('getuserbadges', 'API\APIBadge@getuserbadges');

Route::get('setnotificationstatus', 'API\APIUsernotification@setnotificationstatus');

Route::post('setnotificationstatus', 'API\APIUsernotification@setnotificationstatus');

Route::get('getusernotifications', 'API\APIUsernotification@getusernotifications');

Route::post('getusernotifications', 'API\APIUsernotification@getusernotifications');


Route::post('setuserimage', 'API\APIUserProfile@setuserimage');

Route::post('setuserimage', 'API\APIUserProfile@setuserimage');

// Route::get('setuserimage', 'API\APIUserProfile@setuserimage');

// Route::post('setuserimage', 'API\APIUserProfile@setuserimage');

Route::post('setuserimage64', 'API\APIUserProfile@setuserimage64');

Route::get('setuserimage64', 'API\APIUserProfile@setuserimage64');


Route::post('getuserimage', 'API\APIUserProfile@getuserimage');

Route::get('getuserimage', 'API\APIUserProfile@getuserimage');



Route::get('getquestions', 'API\APIQuestions@getquestions');

Route::post('getquestions', 'API\APIQuestions@getquestions');

Route::get('getskillquestions', 'API\APIQuestions@getSkillquestions');

Route::post('getskillquestions', 'API\APIQuestions@getSkillquestions');

Route::get('get-count-of-questions', 'API\APIQuestions@getCountOfQuestions');

Route::post('get-count-of-questions', 'API\APIQuestions@getCountOfQuestions');


Route::get('getquestion_id', 'API\APIQuestions@getquestion_id');

Route::post('getquestion_id', 'API\APIQuestions@getquestion_id');



Route::get('setscore', 'API\APIScores@setscore');

Route::post('setscore', 'API\APIScores@setscore');

Route::get('getscore', 'API\APIScores@getscore');

Route::post('getscore', 'API\APIScores@getscore');

Route::get('setmastry', 'API\Testexams@setmastry');

Route::post('setmastry', 'API\Testexams@setmastry');

Route::get('updatequetion', 'API\Testexams@updatequetion');

Route::post('updatequetion', 'API\Testexams@updatequetion');

Route::get('setpraticemastry', 'API\Testexams@setpraticemastry');

Route::post('setpraticemastry', 'API\Testexams@setpraticemastry');

Route::post('setuserpoints', 'API\APIPoints@setuserpoints');

Route::get('setuserpoints', 'API\APIPoints@setuserpoints');

Route::post('saveuseranswer', 'API\APIuseranswers@saveuseranswer');

Route::get('saveuseranswer', 'API\APIuseranswers@saveuseranswer');

Route::post('saveuseranswers_json', 'API\APIuseranswers@saveuseranswers_json');

Route::get('saveuseranswers_json', 'API\APIuseranswers@saveuseranswers_json');

Route::get('getallcountries', 'API\APICountries@getallcountries');

Route::post('getallcountries', 'API\APICountries@getallcountries');

Route::get('reportquestion', 'API\APIQuestions@reportquestion');

Route::post('reportquestion', 'API\APIQuestions@reportquestion');

Route::get('getuserscore', 'API\APIUserReports@getuserscore');

Route::post('getuserscore', 'API\APIUserReports@getuserscore');

Route::get('usermasterydetails', 'API\APIUserReports@usermasterydetails');

Route::post('usermasterydetails', 'API\APIUserReports@usermasterydetails');

Route::get('single_question', 'API\APIQuestions@single_question');

Route::post('single_question', 'API\APIQuestions@single_question');

Route::get('topicstats', 'API\APIDisciplines@topicstats');

Route::post('topicstats', 'API\APIDisciplines@topicstats');
//get me the list of all questions
Route::get('/', 'APIsController@index');

Route::resource('exams', 'ExamAPIController');

Route::get('set-game-preference', 'API\APIgamePreference@setGamePreference');

Route::post('set-game-preference', 'API\APIgamePreference@setGamePreference');

Route::get('list-ofgame-preference', 'API\APIgamePreference@listOfCodes');

Route::post('list-ofgame-preference', 'API\APIgamePreference@listOfCodes');

Route::get('delete-game-preference', 'API\APIgamePreference@deleteCodes');

Route::post('delete-game-preference', 'API\APIgamePreference@deleteCodes');

/*Route::get('retrieve-questions', 'API\APIgamePreference@retrieveQuestion');

Route::post('retrieve-questions', 'API\APIgamePreference@retrieveQuestion');*/

Route::get('retrieve-questions', 'API\APIQuestions@retrieveCodeQuestion');

Route::post('retrieve-questions', 'API\APIQuestions@retrieveCodeQuestion');

Route::get('code-verification', 'API\APIQuestions@codeVerification');

Route::post('code-verification', 'API\APIQuestions@codeVerification');