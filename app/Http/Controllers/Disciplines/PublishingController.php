<?php

namespace App\Http\Controllers\Disciplines;

use App\Models\Discipline;
use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Disciplineversion;
use App\Models\Skillcategory;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;
use App\Models\Grade;

use Log;
use Exception;

class PublishingController extends Controller
{
    public function __construct()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
     //   $this->middleware('auth');

        //if trying to access this controller without being authenticated, it will ask him for authentication
     //   $this->middleware ('auth');
    }



    public function index ($disciplineid)

    {
        $discipline = Discipline::findorfail ($disciplineid);

        if (Auth::user ()->can ('coordinate', $discipline)) {

            $discipline_name = $discipline->discipline_name;
            $lastversion = Disciplineversion::where ('discipline_id', '=', $disciplineid)->max ('version');
            if (is_null ($lastversion) == true) $lastversion = 0;

            $skillcategories = Skillcategory::Where ([['discipline_id', '=', $disciplineid], ['version', '=', $lastversion], ['publish_status', '=', 'published']])
                ->orWhere ([['discipline_id', '=', $disciplineid], ['version', '>', $lastversion],['origin_id' ,'=',0]])->orderBy('sort_order')->paginate(1);

            $topics = Topic::all ('id', 'id')->all ();
            $grades = Grade::all ('grade_name', 'id')->all ();
            $disciplines = Discipline::pluck('discipline_name','id')->all();
            $message_text='';
       
            return view ('publishing.index', compact ('skillcategories', 'disciplines', 'topics', 'grades', 'lastversion','disciplineid' , 'discipline_name' ,'message_text'));


        }
        return view ('unauthorized');

    }

    public function accept($skillid , $disciplineid){

        $lastversion = Disciplineversion::where ('discipline_id', '=', $disciplineid)->max ('version');
        $acceptedskill=Skill::findorfail($skillid);
        $discipline=Discipline::findorfail($disciplineid);
        $skillcategory=Skillcategory::findorfail($acceptedskill->skill_category_id);
        if($acceptedskill){

            $acceptedskill->approve_status='approved';
            $acceptedskill->moderatedby= Auth::user ()->id;
            $acceptedskill->save();

        if ($acceptedskill->origin_id <>0 ) {

            $rejectedskills = Skill::where ('origin_id', '=', $acceptedskill->origin_id)->
            where ('id', '<>', $skillid)->
            where ('version', '=', $lastversion + 1)
                ->update (['approve_status' => 'declined', 'moderatedby' => Auth::user ()->id]);
        }
          if ($acceptedskill->origin_id ==0 ){
              $skill=Skill::findorfail($skillid);
          }
          else {
              $skill=Skill::findorfail($acceptedskill->origin_id);

          }
            return view ('collaboration.oneskill', compact ('skill','discipline' ,'skillcategory','lastversion'));
        }
        return;

        }

    public function reject ($skillid ,$disciplineid){
        $lastversion = Disciplineversion::where ('discipline_id', '=', $disciplineid)->max ('version');

        $rejectedskill=Skill::findorfail($skillid);
        $discipline=Discipline::findorfail($disciplineid);
        $skillcategory=Skillcategory::findorfail($rejectedskill->skill_category_id);

        if($rejectedskill){

            $rejectedskill->approve_status='declined';
            $rejectedskill->moderatedby= Auth::user ()->id;
            $rejectedskill->save();

            if ($rejectedskill->origin_id ==0 ){
                $skill=Skill::findorfail($skillid);
            }
            else {
                $skill=Skill::findorfail($rejectedskill->origin_id);

            }
            return view ('collaboration.oneskill', compact ('skill' ,'discipline' ,'skillcategory' ,'lastversion'  ));
        }

        return;

    }


    public function  acceptskillcategory($skillcategoryid , $disciplineid ,$isfirst){



        $lastversion = Disciplineversion::where ('discipline_id', '=', $disciplineid)->max ('version');
        $acceptedskillcategory=Skillcategory::findorfail($skillcategoryid);
        $discipline=Discipline::findorfail($disciplineid);
        if($acceptedskillcategory){

            $acceptedskillcategory->approve_status='approved';
            $acceptedskillcategory->moderatedby= Auth::user ()->id;
            $acceptedskillcategory->save();

            if ($acceptedskillcategory->origin_id <>0 ) {
                $rejectedskills = Skillcategory::where ('origin_id', '=', $acceptedskillcategory->origin_id)->
                where ('id', '<>', $skillcategoryid)->
                where ('version', '=', $lastversion + 1)
                    ->update (['approve_status' => 'declined', 'moderatedby' => Auth::user ()->id]);
            }
            if ($acceptedskillcategory->origin_id ==0 ){
                $skillcategory=Skillcategory::findorfail($skillcategoryid);
            }
            else {
                $skillcategory=Skillcategory::findorfail($acceptedskillcategory->origin_id);

            }

            $i=$isfirst;
            return view ('collaboration.oneskillcategory', compact ('skillcategory','discipline' ,'lastversion' ,'i'));
        }
        return;
   }


    public function rejectskillcategory ($skillcategoryid,$disciplineid ,$isfirst){
        $message_text='';
        $lastversion = Disciplineversion::where ('discipline_id', '=', $disciplineid)->max ('version');
        $rejectedskillcategory=Skillcategory::findorfail($skillcategoryid);
        $discipline=Discipline::findorfail($disciplineid);

        if($rejectedskillcategory){
            $rejectedskillcategory->approve_status='declined';
            $rejectedskillcategory->moderatedby= Auth::user ()->id;
            $rejectedskillcategory->save();

            if ($rejectedskillcategory->origin_id ==0 ){
                $skillcategory=Skillcategory::findorfail($skillcategoryid);
            }
            else {
                $skillcategory=Skillcategory::findorfail($rejectedskillcategory->origin_id);

            }

            $i=$isfirst;
            return view ('collaboration.oneskillcategory', compact ('skillcategory','discipline','lastversion' ,'message_text' ,'i'));
        }
   

    }

    public function  publish ($discipline_id )
    {

        $discipline=Discipline::findorfail($discipline_id);
        $lastversion = Disciplineversion::where ('discipline_id', '=', $discipline_id)->max ('version');
        $newversion =$lastversion+1;





        /*
        -check if there is 	any "skill_categories" with next version (v3) and approve_status='pending' ||
  			any "skill" with next version (v3) and approve_status='pending'
	   --> prompt that all changes need to be either approved or declined
        */

        $skillcategories_pending  = Skillcategory::where  ([['discipline_id',$discipline_id],['version' ,$newversion ] ,['approve_status' ,'pending']] )->count  ();
        $skill_pending_count = skill::with ('skillcategory' )
                              ->where ('version' , '=' , $newversion)
                                 ->where('approve_status' ,'=','pending')
                                 ->whereHas('skillcategory', function($q )  use ($discipline_id) {
                                            $q->where('discipline_id','=',$discipline_id);})
                                                           ->count ();






        if ($skillcategories_pending <>0  || $skill_pending_count <>0 ) {


                $status_val='there some skillcategories or skill are pending ';


                return redirect ()->route ('collaboration.index', $discipline_id)->with ('message_text', $status_val);
            }
        else {


            //all skill and skillcategories approved or declined

        /*    1- case skill categories with declined changes:
	           --> get all the "skill_categories" and "Skills" where (version= 'v3' and approve_status='declined')
               --> delete these records */

            $status_val='all skill and skillcategories approved or declined ';

            $deleted_skill_categories=$this->delete_declined_skill_categories ($discipline_id ,$newversion);
            $status_val=$status_val.'  - deleted skill categories = ' . (string)$deleted_skill_categories ;
            $deleted_skill=$this->delete_declined_skill ($discipline_id ,$newversion);
            $status_val=$status_val . '  - deleted skill  = ' . (string)$deleted_skill ;
            $changed_skill_cat=$this->deleted_skill_categories($discipline_id ,$newversion);
            $status_val=$status_val . ' <br> - efected skill category by changed   = ' . (string)$changed_skill_cat ;

            $changed_skill_is_deleted=$this->deleted_skill($discipline_id ,$newversion);
            $status_val=$status_val . ' <br> - efected skill  by changed   = ' . (string)$changed_skill_is_deleted ;

            $updated_skill_categories=$this->update_publish_status_skill_categories ($discipline_id ,$newversion);
            $status_val=$status_val . ' <br> - efected skill categories  by changed (publish_status=\'published)  = ' . (string)$updated_skill_categories ;


            $updated_skill=$this->update_publish_status_skills ($discipline_id ,$newversion);
            $status_val=$status_val . ' <br> - efected skill   by changed (publish_status=\'published)  = ' . (string)$updated_skill ;

            $clonned_skill_categories=$this->clone_skill_categories_not_changed($discipline_id,$lastversion);
            $status_val=$status_val . ' <br> - cloned skill categories (publish_status=\'published\'and approve_status=\'not changed\')  = ' . (string)$clonned_skill_categories ;

            $cloned_skill=$this->clone_skill_not_changed($discipline_id,$lastversion);
            $status_val=$status_val . ' <br> - cloned skill (publish_status=\'published\'and approve_status=\'not changed\')  = ' . (string)$cloned_skill ;

            $adjust_relation_count=$this->adjust_relation($discipline_id,$newversion,$lastversion);
            $status_val=$status_val . ' <br> -count of adjusted skills , the skill_category->  = ' . (string)$adjust_relation_count ;

            $add_new_verion =$this->add_new_discipline_version($discipline_id,$newversion,$lastversion);
            $status_val=$status_val . ' <br> ' . $add_new_verion;

            return redirect ()->route ('collaboration.index', $discipline_id)->with ('message_text', $status_val);
          //  return $status_val ;

        }







    }

    private function  delete_declined_skill_categories ($discipline_id , $newversion ) {
       // delete a skill categories where are declined and a new version

        $affected  = Skillcategory::where  ([['discipline_id',$discipline_id],['version' ,$newversion ] ,['approve_status' ,'declined']] )->delete();
        return $affected;
    }

    private function  delete_declined_skill ($discipline_id , $newversion ) {
        // delete a skill categories where are declined and a new version
        $affected  = skill::with ('skillcategory' )->
                        where('version' , '=' , $newversion)->
                        where('approve_status' ,'=','declined')
                         ->whereHas('skillcategory', function($q )  use ($discipline_id) {
                             $q->where('discipline_id','=',$discipline_id);})
                               ->delete();
               return $affected;
    }

    private function  deleted_skill_categories ($discipline_id , $newversion ) {


        $i=0;
         $deleted__skill_categories   = Skillcategory::where  ([['discipline_id',$discipline_id],['version' ,$newversion ],['approve_status' ,'approved'] ,['publish_status' ,'deleted']] )->get();
         foreach ($deleted__skill_categories as $deleted__skill_category) {
             $origin_id=$deleted__skill_category ->origin_id;

             $origin_skill_categories=Skillcategory::where('id','=',$origin_id)->first();
             if ($origin_skill_categories) {
             $origin_skill_categories->approve_status = 'changed';
             $origin_skill_categories->save();
             }
             $i=(int)$i+1;
         }
         return  $i ;

    }

    private function  deleted_skill ($discipline_id , $newversion ) {

        /* --> get all the "skill_categories" where (version= 'V3' and publish_status='deleted' and approve_status='approved')
             --> change the origin record approve_status(where id= current:origin_id) to approve_status='changed'
             NB:these records indicate that these skills should not be taken into consideration in next versions
        */

        $i=0;
        $deleted__skills   = Skill::with ('skillcategory' )->
                            where ('version' , '=' , $newversion)->where('publish_status' ,'deleted')
            ->whereHas('skillcategory', function($q )  use ($discipline_id) {
                $q->where('discipline_id','=',$discipline_id);})->get();


        foreach ($deleted__skills as $deleted__skill) {
            $origin_id=$deleted__skill ->origin_id;

            $origin_skill=Skill::where('id','=' ,$origin_id)->first();
            if ($origin_skill ) {
            $origin_skill->approve_status = 'changed';
            $origin_skill->save();
            }
            $i=(int)$i+1;
        }
        return  $i ;

    }


    private function  update_publish_status_skill_categories ($discipline_id , $newversion ) {

/*
        --> get all the "skill_categories" where (version= 'V3' and publish_status='unpublished' and approve_status='approved')
        - change publish_status, approve_status to publish_status='published', approve_status='not changed'
            - get the  orgin record where (id=this.origin_id)
        - change the origin record approve_status(where id=this.origin_id) to  approve_status='changed'
*/

        $i=0;
        $changed_skill_categories   = Skillcategory::where  ([['discipline_id',$discipline_id],['version' ,$newversion ],['approve_status' ,'approved'] ,['publish_status' ,'unpublished']] )->get();
        foreach ($changed_skill_categories as $changed_skill_category) {

            $origin_id=$changed_skill_category ->origin_id;

            $changed_skill_category->publish_status='published';
            $changed_skill_category->approve_status='not changed';
            $changed_skill_category->save();


            $origin_skill_categories=Skillcategory::where('id' ,'=' ,$origin_id)->first();
            if ($origin_skill_categories) {
                $origin_skill_categories->approve_status = 'changed';
                $origin_skill_categories->save ();
            }
            $i=(int)$i+1;
        }
        return  $i ;

    }


    private function  update_publish_status_skills ($discipline_id , $newversion ) {

        /*
                --> get all the "skill " where (version= 'V3' and publish_status='unpublished' and approve_status='approved')
                - change publish_status, approve_status to publish_status='published', approve_status='not changed'
                    - get the  orgin record where (id=this.origin_id)
                - change the origin record approve_status(where id=this.origin_id) to  approve_status='changed'
        */

        $i=0;
      //  dd('dd');
        $changed_skills   = Skill::with ('skillcategory' )->
            where('version' , '=' , $newversion)->where('publish_status' ,'=','unpublished') ->
            where('approve_status' ,'=','approved')->
            whereHas('skillcategory', function($q )  use ($discipline_id) {
                $q->where('discipline_id','=',$discipline_id);})->get();





        foreach ($changed_skills as $changed_skill) {


            $origin_id = $changed_skill->origin_id;

            $changed_skill->publish_status = 'published';
            $changed_skill->approve_status = 'not changed';
            $changed_skill->save ();


            $origin_skill = Skill::where ('id', '=', $origin_id)->first ();
            if ($origin_skill){
                $origin_skill->approve_status = 'changed';
            $origin_skill->save ();
        }
            $i=(int)$i+1;
        }
      //  dd($i);
        return  $i ;

    }


    private function clone_skill_categories_not_changed ($discipline_id , $currentversion){

        /*
        3- case not changed skill categories:
	        --> get all the "skill_categories" where (version= V2 and publish_status='published'and approve_status='not changed')
	        - -> create a new copy record of these skill categories with values version= V3, publish_status='published', approve_status='not changed', origin_id=the previous_id
         *
         * */

        $i=0;
        $not_changed_skill_categories   = Skillcategory::where  ([['discipline_id',$discipline_id],['version' ,$currentversion ],['approve_status' ,'not changed'] ,['publish_status' ,'published']] )->get();
        foreach ($not_changed_skill_categories as $not_changed_skill_category) {


            $new_skill_category=new Skillcategory;
            $new_skill_category->discipline_id=$not_changed_skill_category->discipline_id;
            $new_skill_category->skill_category_name=$not_changed_skill_category->skill_category_name;
            $new_skill_category->skill_category_decsription=$not_changed_skill_category->skill_category_decsription;
            $new_skill_category->version=$currentversion+1;
            $new_skill_category->sort_order=$not_changed_skill_category->sort_order;
            $new_skill_category->createdby=$not_changed_skill_category->createdby;
            $new_skill_category->updatedby=$not_changed_skill_category->updatedby;
            $new_skill_category->approve_status='not changed';
            $new_skill_category->publish_status='published';
            $new_skill_category->origin_id=$not_changed_skill_category->id;
            $new_skill_category->save();
         $i=(int)$i+1;





        }
        return  $i ;


    }


    private function clone_skill_not_changed ($discipline_id , $currentversion){

        /*
        3- case not changed skill :
	        --> get all the "skill" where (version= V2 and publish_status='published'and approve_status='not changed')
	        - -> create a new copy record of these skill  with values version= V3, publish_status='published', approve_status='not changed', origin_id=the previous_id
         *
         * */
       // dd('dd');
        $i=0;

        $not_changed_skills =Skill::with ('skillcategory' )->
            where('version' , '=' , $currentversion)->where('publish_status' ,'=','published')
            ->where('approve_status' ,'=','not changed')
            ->whereHas('skillcategory', function($q )  use ($discipline_id) {
                $q->where('discipline_id','=',$discipline_id);})->get();



        foreach ($not_changed_skills as $not_changed_skill) {

            $new_skill=new Skill;
            $new_skill->skill_category_id=$not_changed_skill->skill_category_id;
            $new_skill->topic_id=$not_changed_skill->topic_id;
            $new_skill->grade_id=$not_changed_skill->grade_id;

            $new_skill->skill_name=$not_changed_skill->skill_name;
            $new_skill->skill_description=$not_changed_skill->skill_description;

            $new_skill->version=$currentversion+1;

            $new_skill->publish_status='published';
            $new_skill->approve_status='not changed';

            $new_skill->sort_order=$not_changed_skill->sort_order;
            $new_skill->updatedby=$not_changed_skill->updatedby;
            $new_skill->createdby=$not_changed_skill->createdby;

            $new_skill->publish_status='published';
            $new_skill->origin_id=$not_changed_skill->id;
            $new_skill->save();
            $i=(int)$i+1;
        }
        return  $i ;


    }


    public function adjust_relation ($discipline_id , $newversion ,$currentversion)
    {
        /*    4- Adjusting relations: the skill_category_id for all skill records
         --> loop over skills where (version= v3 and publish_status='published)
         --> get its skill_category from skillcategory table (where id=skill_category_id and version=v2)
         --> if approve_status='changed'
         -get the child of this skill category (where id= origin_id and publish_status='published)
         -update the skill_category_id attribute of the skill to the id of this child category
             else do nothing;  */

        $i = 0;
        $new_skills = Skill::with ('skillcategory')->
            where('version', '=', $newversion)->
            where('publish_status', 'published')
            ->whereHas('skillcategory', function($q )  use ($discipline_id) {
                $q->where('discipline_id','=',$discipline_id);})->get();

        foreach ($new_skills as $new_skill) {
            $old_skill_category_id=$new_skill->skill_category_id ;
            $new_skill_category=Skillcategory::where([['discipline_id',$discipline_id],['version' ,$newversion ],['approve_status' ,'not changed'] ,['origin_id' ,$old_skill_category_id]] )->first();
            if($new_skill_category) {

                $new_skill->skill_category_id=$new_skill_category->id;
                $new_skill->save();
                $i=(int)$i+1;
            }
        }
        return  $i ;
    }


    public function add_new_discipline_version ($discipline_id , $newversion ){

        $new_discipline_version = new Disciplineversion;
        $new_discipline_version->discipline_id=$discipline_id;
        $new_discipline_version->version=$newversion;
        $new_discipline_version->ispublished=1;
        $new_discipline_version->save();
      //  dd($new_discipline_version);
        return 'new_discipline_version added ';

    }
}