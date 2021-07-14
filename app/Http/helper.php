<?php
/**
 * Change plain number to formatted currency
 *
 * param $number
 * param $currency
 */
namespace app\Http;
use App\Models\Grade;
use App\Models\Skill;
use App\Models\User;
use App\Models\Userinterest;
use App\Models\Role;
use App\Mail\DemoMail;
use Carbon\Carbon;
use App\Models\Inviteduser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/**
 * Pre the data
 *
 * param [type] $id
 * return void
 */
function pre($data)
{
    echo '<pre>';
        print_r($data);
    echo '</pre>';
    die;
}

/**
 * Undocumented function
 *
 * param [type] $id
 * return void
 */
function getgradename($id)
{
    $grade = Grade::findOrFail($id);
    $gradename = $grade->grade_name;

    return $gradename;
}

/**
 * Undocumented function
 *
 * param [type] $skillcategoryid
 * param [type] $lastversion
 * return void
 */
function getskills($skillcategoryid, $lastversion)
{
    $skills = skill::where([['skill_category_id', '=', $skillcategoryid],['version', '=', $lastversion]])->get();

    return $skills;
}

/**
 * Undocumented function
 *
 * param [type] $skillid
 * return void
 */
function getskillsbyorigin($skillid )
{
    $skills = skill::where('origin_id', '=', $skillid)->get();

    return $skills;
}

/**
 * Undocumented function
 *
 * param [type] $user
 * return void
 */
function userregistred($user)
{
    try {
        if (session()->has('bit_learner')) {
            if (session('bit_learner') == 'on') {
                $user->roles()->attach(Role::where('name', 'Learner')->first());
            }
        }

        if (session()->has('bit_teacher')) {
            if (session('bit_teacher') == 'on') {
                $user->roles()->attach(Role::where('name', 'Teacher')->first());
            }
        }

        if (session()->has('bit_parent')) {
            if (session('bit_parent') == 'on') {
                $user->roles()->attach(Role::where('name', 'Parent')->first());
            }
        }

        if ($user->roles()->count () == 0) {
            $user->roles()->attach(Role::where('name', 'Learner')->first());
        }
        Storage::disk('local')->append('userregistred.txt', 'before bit_discipline 0');
        if (session()->has('bit_discipline')) {
            $disciplines = session('bit_discipline');
            foreach ($disciplines as $discipline) {
                echo key ($disciplines);
                echo '=>';
                echo $discipline;
                echo "<br>";
                next ($disciplines);
            }
        }
        Storage::disk('local')->append('userregistred.txt', 'before bit_discipline 1');
        if (session()->has('bit_discipline')) {
            $disciplines = session('bit_discipline');

            foreach ($disciplines as $discipline) {
                if ($discipline == 'on') {
                    $userinterest = new Userinterest;
                    $userinterest->user_id = $user->id;
                    $userinterest->discipline_id = key($disciplines);
                    $userinterest->save();
                    next($disciplines);
                }
            }
        }
        // Topics interest
        $bitTopicsSession = session('bit_topics');
        Storage::disk ('local')->append('userregistred-topics.txt', 'before bit_topics 1');
        if (isset($bitTopicsSession) && !empty($bitTopicsSession)) {
            $topics = explode(',', $bitTopicsSession);

            foreach($topics as $topic) {
                $userinterest = new Userinterest;
                $userinterest->user_id = $user->id;
                $userinterest->topic_id = ($topic);
                $userinterest->save();
            }
        }
        Storage::disk('local')->append('userregistred.txt', 'before bda');
        if (session()->has('bday')) {
            $dob = session('bday');
            $user->dob = $dob;
            $user->save();
        }
        Storage::disk('local')->append('userregistred.txt', 'after bda');
        Storage::disk('local')->append('parnetmail.txt', 'check has parentemail');
        if (session()->has('parentemail')) {
            $parent_mail = session('parentemail');
            $user->parentmail = $parent_mail;
            $user->save();
        } else {
            Storage::disk('local')->append('parnetmail.txt', 'no parentemail');
        }
        $age = (Carbon::parse($dob)->age);
        if ($age <= 13) {
            $confirmation_code = str_random(100);
            $user->confirmation_code = $confirmation_code;
            $user->isapproved_byparent = 0;
            $user->save();
            $email = $user->parentmail;

            Mail::to($email)->send(new DemoMail($confirmation_code, $user));
            // Send a mail to parent to approve their child request
        } else {
            $user->confirmation_code = null;
            $user->isapproved_byparent = 1;
            $user->save();
        }
        $invitedusers = Inviteduser::where('email', '=', $user->email)->where('isinvitedregistered', '=', 0)->get();
        foreach ($invitedusers as $inviteduser) {
            $inviteduser->isinvitedregistered = 1;
            $inviteduser->invitationstatus = 'accepted';
            $inviteduser->save();
        }
        Storage::disk('local')->append('parnetmail.txt', 'done....');
        return;
    } catch (Exception $exception) {
        Storage::disk('local')->append('registererror.txt', $exception);
    }
}
