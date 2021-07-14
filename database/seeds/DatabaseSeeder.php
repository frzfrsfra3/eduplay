<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Modify by Webclues

        //Languages,
        $this->call(LanguagesTableSeeder::class);

        //Countries,
        $this->call(CountriesSeeder::class);

        // Role comes before User seeder here.
        $this->call(RoleTableSeeder::class);

        //Badges
        $this->call(BadgesTableSeeder::class);

        // Xp_points for the different activities
        $this->call(XPpointsTableSeeder::class);

        //Different Mastery Levels
        $this->call(SkillMasteryLevelsTableSeeder::class);

        //first time login activities
        $this->call(ActivitiesTableSeeder::class);

        // User seeder will use the roles above created.
        $this->call(UserTableSeeder::class);

        //Curriculum, Grades
        $this->call(CurriculaGradeTablesSeeder::class);    
              
        // Topics, Disciplines Curricula, Disciplineversion, Collaborators
        $this->call(DisciplinesTableSeeder::class);

        //Skill Categories and Skills
        $this->call(Skills_CategoriesTablesSeeder::class);


        // Client code

        //  // // Role comes before User seeder here.
        //  $this->call(RoleTableSeeder::class);
        //  //Languages,
        //  $this->call(LanguagesTableSeeder::class);
        //  $this->call([
        //      CountriesSeeder::class,          //Countries,
        //      UserTableSeeder::class,          // User seeder will use the roles above created.
        //      BadgesTableSeeder::class,
        //      CurriculaGradeTablesSeeder::class, //Curriculum, Grades
        //      ActivitiesTableSeeder::class,    //first time login activities
        //      XPpointsTableSeeder::class,      // Xp_points for the different activities
        //      SkillMasteryLevelsTableSeeder::class,//Different Mastery Levels
        //   ]);
        //   $this->call([
        //       DisciplinesTableSeeder::class,      // Topics, Disciplines Curricula, Disciplineversion, Collaborators
        //       Skills_CategoriesTablesSeeder::class,//Skill Categories and Skills
        //       ExerciseSetTableSeeder::class,      //ExerciseSet, Questions and Answers, exercisesetbuyers and an Exam with Examquestions
        //       ClassCoursesTableSeeder::class,     // Class, ClassLearners, ClassExercises, ClassExams
        //       UserExamAnswersTableSeeder::class,  //UserExamAnswers
        //   //    PracticeResults::class,  //
        //   //    Userbadges::class,       //
        //   //    Userexamscores::class,   //
        //   //    UserInterests::class,  //
        //   //    UserSkillMasteryLevels::class,
        //   ]);
    }
}
