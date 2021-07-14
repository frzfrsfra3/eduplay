<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Exerciseset;
use App\Models\Question;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExerciseSetPolicy
{
    //policies for exercise sets, questions and answeroptions
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole('Admin')) {
            return true;
        }
    }

    // viewing and practicing Exercise set Questions
    public function viewExerciseSetQuestions(User $user, ExerciseSet $exerciseSet)
    {Storage::disk ('local')->append ('exercisepolicy.txt','view: '. $exerciseSet->createdby);
        // if the exercise set is not free only users who have bought this exercise set can view its questions
        // or if the user is a learner in a class containing this exercise set
        if($exerciseSet->price ==0){return true;}
        else{
                if ($exerciseSet->buyers()->get()->contains($user)){
                    return true;
                };
                $userenrolledclasses=$user->enrolledclasses();
                foreach($userenrolledclasses as $courseclass){
                    if($courseclass->exercises()->get()->contains($exerciseSet)){
                    return true;
                    }
                }
        }
        return false;
    }

    // create and publish
    public function create(User $user)
    {
        // all authenticated users can  create exercise sets but only teachers can publish to public library
    }

    public function publish(User $user)
    {
        // all authenticated users can  create exercise sets but only teachers can publish to public library
        if($user->hasRole('Teacher')){
            return true;
        }
        else {
            return false;}
    }

    public function update(User $user, ExerciseSet $exerciseSet)
    {
        // only the person who created the exercise set can update it
        if ($user->id==$exerciseSet->createdby) {Storage::disk ('local')->append ('exercisepolicy.txt','update: '. $exerciseSet->createdby);
            return true;}
        else {
            return false;}
    }

    public function delete(User $user, ExerciseSet $exerciseSet)
    {
        // only the person who created the exercise set can delete it
        if ($user->id==$exerciseSet->createdby) {
            return true;}
        else {
            return false;}
    }

    public  function showbuy(User $user, ExerciseSet $exerciseSet) {

        if ($exerciseSet->price >0 ) {

            if($exerciseSet->createdby == $user->id ) return false;
           $buyer=$exerciseSet->buyers ()->where('user_id','=',$user->id)->first();
           if(!$buyer) return true;
           else return false;


    }
    else return false;

}

    public  function  addtoprivatelibrary(User $user, ExerciseSet $exerciseSet) {

        if ($exerciseSet->price ==0 ) {

                if($exerciseSet->createdby == $user->id ) return false;


                $buyer=$exerciseSet->buyers ()->where('user_id','=',$user->id)->first();
                if(!$buyer) return true;
                else return false;


        }
         return false;

    }


}
