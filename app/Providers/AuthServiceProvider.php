<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        'App\Models\Language' => 'App\Policies\AdminPolicy',
        'App\Models\Country' => 'App\Policies\CountryPolicy',
        'App\Models\Badge' => 'App\Policies\BadgePolicy',
        'App\Models\Discipline' => 'App\Policies\DisciplinePolicy',
        // Exercise Set Models
        'App\Models\Exerciseset' => 'App\Policies\ExerciseSetPolicy',
        'App\Models\Question' => 'App\Policies\ExerciseSetPolicy',
        'App\Models\Answeroption' => 'App\Policies\ExerciseSetPolicy',
        //Skill Category and Skills
        'App\Models\Skillcategory' => 'App\Policies\SkillCategoryPolicy',
        'App\Models\Skill' => 'App\Policies\SkillCategoryPolicy',
        'App\Models\Courseclass'=>'App\Policies\CourseClassPolicy',
        'App\Models\Exam'=>'App\Policies\ExamPolicy',
        'App\Models\Classexam'=>'App\Policies\ExamPolicy',
        'App\Models\GoogleclassExams'=>'App\Policies\ExamPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}
