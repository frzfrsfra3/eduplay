<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\AddXppoint;
use App\Models\Pendingtask;
use Redirect;
class Controller extends BaseController {
    //collectRatingWithUser, Collect OneSetRatingsWithUser, paginate,
    // userTourStatus, updateUserTourStatus, getToKnowEduPlay

    use AddXppoint;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * get collection rating with user's name and image.
     */
    public function collectRatingsWithUser($array,$minimum_rating = null) {
        return collect($array)->map(function ($dataSet) use($minimum_rating) {
            if (!empty($dataSet->ratings)) {
                $rates = collect($dataSet->ratings)
                ->map(function ($rate) {
                    $user = User::find($rate->author_id);
                    if(!empty($user)){
                        return (object)['rate' => $rate->rating, 'body' => $rate->body, 'user_name' => $user->name, 'user_image' => $user->user_image, 'created_at' => $rate->updated_at, ];
                    } else {
                        return (object)['rate' => Null, 'body' => Null, 'user_name' => Null, 'user_image' => Null, 'created_at' => Null, ];
                    }
                })
                ->sortByDesc('created_at');
                if(!empty($minimum_rating)){
                    $rates  = $rates->take($minimum_rating);
                }
                $dataSet['ratings_data'] = $rates;
            }
            
            return $dataSet;
        });
    }

    /**
     * get one collection rating with user's name and image.
     */
    public function collectOneSetRatingsWithUser($array) {
        if (!empty($array->ratings)) {
            $rates = collect($array->ratings)->map(function ($rate) {
                $user = User::find($rate->author_id);
                if(!empty($user)){
                    return (object)['rate' => $rate->rating, 'body' => $rate->body, 'user_name' => $user->name, 'user_image' => $user->user_image, 'created_at' => $rate->updated_at, ];
                } else {
                    return (object)['rate' => Null, 'body' => Null, 'user_name' => Null, 'user_image' => Null, 'created_at' => Null, ];
                }
            })->sortByDesc('created_at');
            return $array['ratings_data'] = $rates;
        }
    }

    /**
     * Set custom pagination on new collation
     */
    public function paginate($items, $perPage, $page = null, $options = []) {
        $page = $page ? : (Paginator::resolveCurrentPage() ? : 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * Fetch login user tour visit status- Developed by : WC
     */
    public static function userTourStatus() {
        if (Auth::user()) {
            $status = User::select('id', 'visit_tour')->find(Auth::user()->id);
            return $status->visit_tour;
        } else {
            return 0;
        }
    }

    /**
     * Update user visit tour status -Developed by : WC
     */
    public function updateUserTourStatus($status) {
        $user = User::find(Auth::user()->id);
        if($user->visit_tour == 2) {
            //dd(1);
            Session::put("not_now_tour", 2);
            $user->visit_tour = $status;
            $user->save();
            echo 'success';
        } else if ($status == 2) { // Not now feature
            Session::put("not_now_tour", 2);
            $user->visit_tour = 2;
            $user->save();
            echo 'success';
        } else {
            // end tour
            $user->visit_tour = $status;
            $user->save();
            echo 'success';
            // For xppoints Badges
            $this->add_xp_point (Auth::user ()->id, 'viewproducttour');
        }
    }

    // get to know eduplay
    public function getToKnowEduplay(){
        $task= Pendingtask::where('user_id','=',Auth::user ()->id)
                ->where ('pending_task_description','=','Get to Know EduPlayCloud')
                ->first();
            if ($task)
            {
                $task->status='done';
                $task->task_type=1;
                $task->save();
            }
            return Redirect::to('https://www.youtube.com/watch?v=j-a3JKPSc4s');
    }
}
