<?php

namespace App\Http\Controllers\Games;

use App\Models\Exam;
use App\Models\App;
use App\Models\Age;
use App\Models\Game;
use App\Models\Category;
use App\Models\Developer;
use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Auth;
use App\Models\Gamedetail;
use App\Models\gamePreference;
use App\Models\User;
use App\Models\Courseclass;
use App\Models\Gamedownload;
use Trexology\ReviewRateable\Models\Rating;
use App\Models\Exerciseset;
use App\Http\Traits\AddXppoint;
use Illuminate\Support\Facades\Lang;
use App\Mail\GameCodeShare;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class GamesController extends Controller
{
    use AddXppoint;
    /**
     * Display a listing of the games.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $paginationcount = 25;
        $games = $this->getGamesFilterData($paginationcount);

        return view ('games.index', compact ('games'));
    }
    
    /**
     * Develop by Wc.
     * 
     * Display filtered games.
     * 
     * param Illuminate\Http\Request $request
     * return Illuminate\View\View
     */
    public function getGameResult(){

        $paginationcount = 25;
        $filter_games = $this->getGamesFilterData($paginationcount);
            
            if (!empty(request('Rating_search'))) {
                $games_collection = $filter_games->filter(function ($game_value, $key) {
                    //Filter by Rating count.
                    if (!empty(request('Rating_search'))) {
                        if (request('Rating_search') === $game_value->averageRating(1) [0]) {
                            return $game_value->averageRating(1) [0] == request('Rating_search');
                        }
                    }
                });
                //Repagination by custom pagination
                $games = $this->paginate($games_collection, $paginationcount);
            } else {
             
                if(request('SortBy_search') === 'Descending'){
                  $sortByData = $this->allGameFilterSortByDesc($filter_games);
                } else {
                  $sortByData = $this->allGameFilterSortByAsc($filter_games);
                }

                $games = $this->paginate($sortByData, $paginationcount);
              }
              

        return view ('games.one-game', compact ('games'))->render();
    }


       /**
     * Added filter sort by filter type.
     * 
     * 
     */
    public function allGameFilterSortByDesc($filter_games){
      if(request('filter_search') === 'publisher' ){
        $descData = collect($filter_games)->sortByDesc(function ($game_value, $key) {
            return $game_value->developer['name'];
        });
      } else if(request('filter_search') === 'age_range'){
        $descData = collect($filter_games)->sortByDesc(function ($game_value, $key) {
            return $game_value->minimum_age;
        });
      } else if(request('filter_search') === 'category'){
        $descData = collect($filter_games)->sortByDesc(function ($game_value, $key) {
          return $game_value->category;
        });
      } else if(request('filter_search') === 'operating_system'){
        $descData = collect($filter_games)->sortByDesc(function ($game_value, $key) {
          return $game_value->patform;
        }); 
      } else {
        $descData = $filter_games;
      }

      return $descData;
    }

     /**
     * Added filter sort by filter type.
     * 
     * 
     */
    public function allGameFilterSortByAsc($filter_games){
      if(request('filter_search') === 'publisher' ){
        $ascData = collect($filter_games)->sortBy(function ($game_value, $key) {
          return $game_value->developer['name'];
        });
      } else if(request('filter_search') === 'age_range'){
        $ascData = collect($filter_games)->sortBy(function ($game_value, $key) {
          return $game_value->minimum_age;
        });
      } else if(request('filter_search') === 'category'){
        $ascData = collect($filter_games)->sortBy(function ($game_value, $key) {
          return $game_value->category;
        });
      } else if(request('filter_search') === 'operating_system'){
        $ascData = collect($filter_games)->sortBy(function ($game_value, $key) {
          return $game_value->patform;
        }); 
      } else {
        $ascData = $filter_games;
      }

      return $ascData;
    }

    /**
     * 
     * Develop by WC
     *  
     * Get games filter data.
     * param Illuminate\Http\Request $request
     * return Response
     */
    public function getGamesFilterData($paginationcount){

        $games =  Game::where('status','=','published')->where('isapproved','=','Y')->with ('discipline');

        //Fetch Data by developer name.
        if(request('Publisher_search') != ''){   
            $games->whereHas('developer',function($developer){
                if(request('Publisher_operator') === 'like'){
                    $developer->where('name','like','%'.request('Publisher_search').'%');
                } else {
                    $developer->where('name','=',request('Publisher_search'));
                }
            });
        } else {
            $games->with('developer');
        }

        //Fetch data by Min age.
        if(request('Age_search') != ''){
            if(request('Age_operator') === 'like'){
                $games->where('minimum_age','LIKE','%'.request('Age_search').'%');
            } else {
                $games->where('minimum_age','=',request('Age_search'));                            
            }
        }

        //Fetch data by Category.
        if(request('Category_search') != ''){
            if(request('Category_operator') === 'like'){
                $games->where('category','LIKE','%'.request('Category_search').'%');
            } else {
                $games->where('category','=',request('Category_search'));                            
            }
        }

        //Fetch data by OS.
        if(request('OS_search') != ''){
            $games->where('patform','=',request('OS_search'));
        }



        return $games->get();
        return $games->paginate ($paginationcount);
    }

    /**
     * Show the form for creating a new game.
     *
     * return Illuminate\View\View
     */
    public function create ()
    {
        $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();
        $developers = Developer::pluck ('id', 'id')->all ();
        $apps = App::pluck ('id', 'id')->all ();
        $categories = Category::pluck ('id', 'id')->all ();
        $ages = Age::pluck ('id', 'id')->all ();

        return view ('games.create', compact ('disciplines', 'developers', 'apps', 'categories', 'ages'));
    }

    /**
     * Store a new game in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Game::create ($data);

            return redirect ()->route ('games.game.index')
                ->with ('success_message', 'Game was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified game.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show (Request $request,$id)
    {
        $gamedetails = Gamedetail::with('game.developer')->where('game_id',$id)->first();
        $downloadCount = Gamedownload::where('game_id',$id)->count();
        $game = Game::findorFail($id);
        $userrate=0;
        if (Auth::user() ) {
            if ($game->find( Auth::user() ) ) {
            } 
        }
        $userrate = $this->collectOneSetRatingsWithUser($game);
          
        return view ('games.show', compact ('gamedetails','downloadCount','userrate','game'));
    }

    /**
     * Show the form for editing the specified game.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {
        $game = Game::findOrFail ($id);
        $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();
        $developers = Developer::pluck ('id', 'id')->all ();
        $apps = App::pluck ('id', 'id')->all ();
        $categories = Category::pluck ('id', 'id')->all ();
        $ages = Age::pluck ('id', 'id')->all ();

        return view ('games.edit', compact ('game', 'disciplines', 'developers', 'apps', 'categories', 'ages'));
    }

    /**
     * Update the specified game in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update ($id, Request $request)
    {
        try {

            $data = $this->getData ($request);

            $game = Game::findOrFail ($id);
            $game->update ($data);

            return redirect ()->route ('games.game.index')
                ->with ('success_message', 'Game was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified game from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {
        try {
            $game = Game::findOrFail ($id);
            $game->delete ();

            return redirect ()->route ('games.game.index')
                ->with ('success_message', 'Game was successfully deleted!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData (Request $request)
    {
        $rules = [
            'discipline_id' => 'required',
            'developer_id' => 'required',
            'game_name' => 'required|numeric|min:-2147483648|max:2147483647',
            'patform' => 'required',
            'app_id' => 'required',
            'secrete_key' => 'required|string|min:1|max:500',
            'game_icon' => 'required|string|min:1|max:250',
            'image1' => 'required|numeric|string|min:1|max:250',
            'image2' => 'required|numeric|string|min:1|max:250',
            'image3' => 'required|numeric|string|min:1|max:250',
            'image4' => 'required|numeric|string|min:1|max:250',
            'image5' => 'required|numeric|string|min:1|max:250',
            'category_id' => 'required',
            'age_id' => 'required|numeric|min:0|max:4294967295',
            'status' => 'required',
            'isapproved' => 'required',
            'isactive' => 'required',
            'description' => 'required',

        ];


        $data = $request->validate ($rules);


        return $data;
    }

    /**
     * Developed by : WC
     * This function is used to review & ratings for games
     * 
     * param Illuminate\Http\Request $request
     * return Response
     */
    public function addreview(Request $request)
    {
        $user = Auth::user();
        $id = $request->id;
        $rate = $request->score;
        if ($rate == "")  {
            return response()->json('fail');
        }
        $title = ($request->title) ? $request->title : '';

        $comment = ($request->comment) ? $request->comment : '';

        $exerciseset = Game::findorfail($id);
        
        // $ratingauth=$exerciseset->find( $user);
        $ratingauth=$exerciseset->ratings->where('author_id', $user->id)->first();
        
        if (!$ratingauth)  {
            $this->add_xp_point (Auth::user ()->id, 'writereview');
            $rating = $exerciseset->rating([
                'title' => $title,
                'body' => $comment,
                'rating' => $rate,
            ], $user);
        }
        else
        {
            $rating = $exerciseset->updateRating($ratingauth->id, [
                'title' => $title,
                'body' => $comment,
                'rating' =>  $rate,
            ]);
        }

        return response()->json('success');

    }

    /**
     * Developed by : WC
     * my reviews list
     * 
     * param Request @request
     * return View
     */
    public function myReviews(Request $request) {
        // My Ratings
        $ratings = Rating::where('author_id',Auth::user()->id)->orderBy('id','DESC')->paginate(2);
        $ratings_data = array();
        $html='';
        foreach ( $ratings as $key => $val ) {
            $user = User::where('id',$val->author_id)->first();

            // Check 
            if ($val->reviewrateable_type == 'App\Models\Exerciseset') {
                $exerciseset = Exerciseset::where('id',$val->reviewrateable_id)->select('id','exerciseset_image','title')->first();
                $ratings_data['id'] = $exerciseset->id;
                $ratings_data['name'] = $exerciseset->title;
                $ratings_data['image'] = $exerciseset->exerciseset_image;

            } else if ($val->reviewrateable_type == 'App\Models\Courseclass') {
                $coursclass = Courseclass::where('id',$val->reviewrateable_id)->select('id','iconurl','class_name')->first();
                $ratings_data['id'] = $coursclass->id;
                $ratings_data['name'] = $coursclass->class_name;
                $ratings_data['image'] = $coursclass->iconurl;

            } else if ($val->reviewrateable_type == 'App\Models\Game') {
                $game = Game::where('id',$val->reviewrateable_id)->select('id','game_icon','game_name')->first();
                $ratings_data['id'] = $game->id;
                $ratings_data['name'] = $game->game_name;
                $ratings_data['image'] = $game->game_icon;
                

            } else {
                $ratings_data['id'] = Auth::user()->id;
                $ratings_data['name'] = Auth::user()->name;
            }
            $ratings_data['rate'] = $val->rating;
            $ratings_data['body'] = $val->body;
            $ratings_data['user_image'] = $user->user_image;
            $ratings_data['created'] = $val->updated_at;
            $ratings[$key]['ratings_data'] = $ratings_data;
                
        }

        if ($request->ajax()) {
            
            $count = count($ratings);
            if ($count == 0) {
                return 0;
            } else {
                return view('games.ajax_reviews',compact('ratings'));
            }
        }
        
        return view ('games.my_reviews', compact ('ratings'));
    }

    /**
     * Developed by : WC
     * show all ratings of individual games
     * 
     * param int $id
     * return View
     */

    public function onegame ($id)
    {
        $data = $this->getGameInfo($id);
        
        return view ('games.onegame', $data);
    }

    /**
     * Developed by : WC
     * get game details
     * 
     * param int @id
     * return Response
     */
    public function getGameInfo($id) 
    {
        $gamedetails = Gamedetail::with('game.developer')->where('game_id',$id)->first();
        $downloadCount = Gamedownload::where('game_id',$id)->count();
        $game = Game::findorFail($id);
        $userrate=0;
        if (Auth::user() ) {
            if ($game->find( Auth::user() ) ) {
            } 
        }
        //$userrate = $this->collectOneSetRatingsWithUser($game);
        $userrate = Rating::with('author')->where('reviewrateable_id',$id)->orderBy('id','DESC')->paginate(2);    
        
        return compact ('gamedetails','downloadCount','userrate','game');
    }


    function storeDownload(Request $request){
        $game = $request->game_id;

        $downloadCount = Gamedownload::create([
            'user_id' => Auth::user()->id,
            'game_id' => $game,
            'download_type' => 'google',
        ]);

        return $downloadCount;
    }
    
    /**
     * 
     * Display my code page.
     * 
     */
    public function myGameCodeDisplay($deepLink_game = null, $deepLink_codeType = null , $deepLink_code = null){
        
        $data = [
            'deepLink_game' => $deepLink_game, 
            'deepLink_codeType' => $deepLink_codeType, 
            'deepLink_code' => $deepLink_code,
            ''
        ];
        if ( Auth::check() )
            $gameCodes = gamePreference::where('user_id','=',Auth::user()->id)->orderBy('id', 'DESC')->paginate(20);
        else
            $gameCodes = [];
      return view('eduplaycloud.users.game_codes.index',compact('gameCodes'))->with($data);
    }

    /**
     * 
     * Generate Code and store from my exercise. 
     * 
     */
    public function postGenerateCode(Request $request){

      $code =substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);

      $gamePreferenceData = [
          'user_id' => Auth::user()->id, 
          'code' => $code, 
          'topic_id' => $request->topic_id, 
          'discipline_id' => $request->discipline_id, 
          'grade_id' => $request->grade_id, 
          'list_exercise_ids' => $request->exercise_id, 
        ];

      $gameCode = gamePreference::create($gamePreferenceData);

      return redirect()->route('games.my.codes')->with('success_message', Lang::get('controller.generate_code_msg'));
    }

    public function generateExamCode($id){

        $code = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);

        $list_exercise_ids = "";
            
        $examID = $id;

        $exam = Exam::find($examID);
        foreach ($exam->exam_exercisesets as $exam_exerciseset)
        {
            $list_exercise_ids .= $exam_exerciseset->exerciseset->id . ",";
        }


        $gamePreferenceData = [
            'user_id' => Auth::user()->id, 
            'code' => $code, 
            'list_exercise_ids' => $list_exercise_ids, 
            ];

      $gameCode = gamePreference::create($gamePreferenceData);

      return redirect()->route('games.my.codes')->with('success_message', Lang::get('controller.generate_code_msg'));
    }


      /**
     * teacher adds learner to the class
     * 
     * param Illuminate\Http\Request $request
     * param int $class_id
     * return Illuminate\View\View
     */
    public function addlearner(Request $request) {

      $name = $request->name;
      $code = $request->code;

      if (strlen($name) > 0) {
          $users = User::select('id', 'name', 'email', 'user_image')->where('email', '=',  $name )->where('id','!=',Auth::user()->id)->get();
          if (count($users) > 0) {
              return view('eduplaycloud.users.game_codes.learner', compact('users','code'));
            } else {
              return view('eduplaycloud.users.game_codes.learner', compact('users','code'));
          }
      } else {
          $users = null;
          return view('eduplaycloud.users.game_codes.learner', compact('users','code'));
      }
    }

    /**
     * 
     * Share code by email to learner.
     * 
     */
    public function postShareCodeToLearner(Request $request){

      $email = $request->email;
      $code = $request->code;
      $user = Auth::user();

      Mail::to($email)->send(new GameCodeShare($user, $code));
      Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $email );
      Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
    
      if (Mail::failures()) {
          Lang::get('controller.game_code_mail_unsuccess');
          $status = false;
        } else {
          Lang::get('controller.game_code_mail_success');
          $status = true;
      }

      return response()->json(['status' => $status, 'msg' => $msg]);

    }

    /**
     * Remove game Preference code.
     * 
     */
    public function gamePreferenceDestroy($codeID){ 
      $gameCode = gamePreference::where('id','=',$codeID)->where('user_id','=',Auth::user()->id)->delete();
      return redirect()->route('games.my.codes')->with('success_message', Lang::get('controller.game_code_delete'));
    }

}
