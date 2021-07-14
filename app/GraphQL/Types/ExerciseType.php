<?php

namespace app\graphql\Types;


use App\Models\Exerciseset;
use App\Http\Controllers\Controller;

class ExerciseType
{
    public function maxduration(Exerciseset $exerciseset){
        return gmdate("H:i:s", $exerciseset->question->sum('maxtime'));
    }

    public function skillscount(Exerciseset $exerciseset){
        return $exerciseset->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id');
    }

    public function averagerating(Exerciseset $exerciseset){
        return $exerciseset->averageRating(1)[0];
    }

    public function getReviews(Exerciseset $exerciseset)
    {
#        $exerciseRatingList = $exercisesetcontroller->collectRatingsWithUser($exerciseset, 2);
#        foreach ($exerciseRatingList as $ratekey => $rate){
#            $codereviewCount = 1;
#            if ($rate->id == $exerciseset->id) {
##                if (count($rate->ratings_data) > 0) {
#                    foreach ($rate->ratings_data as $item) {
                        #$item->user_image)
                        #$item->rate
                        #$item->created_at
                        #$item->body
#                        $codereviewCount++;
#                    }

        #               }

#            }
#        }
#        return
    }


}