<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Discipline;
use App\Models\Disciplinecollaborator;
use Illuminate\Auth\Access\HandlesAuthorization;

class DisciplinePolicy
{
    use HandlesAuthorization;

    public function collaborate(User $user, Discipline $discipline)
    {
       //authenticated user should be a collaborator fo that Discipline
      $isapproved=false;
      $firstrecord=Disciplinecollaborator::where ([['user_id','=',$user->id],['discipline_id' ,'=' ,$discipline->id]])->first();

      if ($firstrecord) {
            $approvalstatus=$firstrecord->approvalstatus;
          if ( $approvalstatus =='approved') {
              $isapproved=true;

          }
      }
      return $isapproved ;
    }

    public function coordinate(User $user, Discipline $discipline)
    {
        //authenticated user should be a coordinator for that discipline
        $isapproved=false;
        $firstrecord=Disciplinecollaborator::where ([['user_id','=',$user->id],['discipline_id' ,'=' ,$discipline->id],['iscoordinator','=','1']])->first();
        if ($firstrecord) {

         //   $approvalstatus=$firstrecord->approvalstatus;
            if ( $firstrecord->approvalstatus =='approved') {
                $isapproved=true;

            }

        }
        return $isapproved ;
    }

    //Users who can request to collaborate
    public function requestCollaborate(User $user){
        return $user->hasRole('Teacher');
    }

    /**
     * Determine whether the user can create disciplines.
     */
    public function create(User $user)
    {
        // only admin can create a new discipline
    }

    /**
     * Determine whether the user can view the discipline.
     */
    public function viewedit(User $user, Discipline $discipline)
    {
        //this function is not used?
        $isapproved=false;
        return $isapproved ;
    }

    /**
     * Determine whether the user can update the discipline.
     */
    public function update(User $user, Discipline $discipline)
    {
        //
    }

    /**
     * Determine whether the user can delete the discipline.
     */
    public function delete(User $user, Discipline $discipline)
    {
        //
    }
}
