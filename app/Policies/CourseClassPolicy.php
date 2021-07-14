<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Courseclass;
use App\Models\Question;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourseClassPolicy
{
    //policies for exercise sets, questions and answeroptions
    use HandlesAuthorization;



    // viewing and practicing Exercise set Questions
    public function view(User $user, Courseclass $courseclass)
    {
        // if the exercise set is not free only users who have bought this exercise set can view its questions
        // or if the user is a learner in a class containing this exercise set
    }

    // create and publish
    public function create(User $user)
    {

      return $user->hasRole ('Teacher');

    }

    public function publish(User $user)
    {
        // all authenticated users can  create exercise sets but only teachers can publish to public library
    }

    public function update(User $user, Courseclass $courseclass)
    {
        if($user->id==$courseclass->teacher_userid) {
            return true ;
        }

        return false;
        // only the person who created the exercise set can update it

    }

    public function delete(User $user, Courseclass $courseclass)
    {
        // only the person who created the exercise set can delete it
    }
}
