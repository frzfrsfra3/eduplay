<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filter;
use Auth;
use Illuminate\Support\Str;

class FilterController extends Controller
{
    /**
     * 
     * Get users filter.
     */
    public function getUserFilter(){
      
      if(Auth::user()){
        $filterData = Filter::where('user_id','=',Auth::user()->id)->get();
      } else {
        $filterData = [];
      }
      
      return $filterData;
    }

    /**
     * Store user's attempt filter data.
     * 
     */
    public function saveUserFilter(Request $request){
      if(Auth::user()){
        $type = Str::lower($request->type);
        $filterData = [
          'user_id' => Auth::user()->id,
          'type' => $type,
          'operator' => $request->operator,
          'value' => $request->name,

        ];

        
        if($request->operator == 'SortBy') {
          $savedFilter = Filter::where('user_id','=',Auth::user()->id)->where('operator','=',$request->operator)->first();
          
        } else {
          
          $savedFilter = Filter::where('user_id','=',Auth::user()->id)
                                ->where('type','=',$type)
                                ->where('operator','=',$request->operator)->first();
        }

        if(!empty($savedFilter)) {
          $savedFilter->fill($filterData);
          $savedFilter->save();

          $message = 'update';
        } else {
          Filter::create($filterData);
          $message = 'create';
        }
      } else {
        $message = '';
      }
      return $message;
    }

    /**
     * Remove filter one by one from database.
     * 
     */
    public function deleteUserFilter(Request $request){
      if(Auth::user()){
         Filter::where('user_id','=',Auth::user()->id)->where('type','=',$request->type)->delete();
         $message = 'delete';
      } else {
          $message = null;
      }
      return $message;
    }


    /**
     * Remove All Filter data for Auth user from database. 
     */
    public function allFilterDataClear(){
      if(Auth::user()){
        Filter::where('user_id','=',Auth::user()->id)->delete();
        $msg = 'All delete';
      } else {
        $msg =  null;
      }
      return $msg; 
    }
}
