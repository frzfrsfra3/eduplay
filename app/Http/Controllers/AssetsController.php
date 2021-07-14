<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Auth;
use File;
use SplFileInfo; 
use Response;
use App\Models\Question;

class AssetsController extends Controller
{
    // index, getInfo, getDownload, getDelete, myassetsUpload, calculateDirectorySize
    // ChecFileExist

    /**
     * push files into arrays based on extension
     * return views/users/myassets
     */
    public function index(){
        $userid=Auth::user()->id;
        $path=public_path('assets/eduplaycloud/upload/exercisesset/user-'.$userid);
        if(File::isDirectory($path)){
            $directories = File::allFiles($path);
            $file_size = 0;
            $images=[];
            $csvs=[];
            $audios=[];

            foreach($directories as $key=>$data){
                // Count Size
                $file_size += $data->getSize();
                // get file data
                $file = new SplFileInfo($data);

                // for the differentiate all files
                if($file->getExtension() == "csv"){
                    $csvArray=array_push($csvs,$file);
                }else if($file->getExtension() == "mp3"){
                    $audioArray=array_push($audios,$file);
                }else{
                    $imageArray=array_push($images,$file);
                }
            }

            $file_size = number_format($file_size / 1000000,2);
            $userQuota = number_format(Auth::user()->quota / 1000, 2);
            return view('users.myassets',["images"=>$images,"csvs"=>$csvs,"audios"=>$audios,"file_size"=>$file_size,"userid"=>$userid,'userQuota' => $userQuota]);

        }
        else{
            return view('users.myassets');
        }
    }

    // return filename
    function getInfo($data)
    {
        $file = new SplFileInfo($data);

        return $file_name = $file->getFilename();
    }

    // Download File
    public function getDownload($path,$etc)
    {
        $userid=Auth::user()->id;
        if($etc == "csv"){
            $etc='csv';
        }else if($etc == "mp3"){
            $etc='audio';
        }else{
            $etc='image';
        }

        $file= public_path().'/assets/eduplaycloud/upload/exercisesset/user-'.$userid.'/'.$etc.'/'.$path;
        return Response::download($file);
    }

    // Delete File
    public function getDelete($path,$etc)
    {
        $userid=Auth::user()->id;
        if($etc == "csv"){
            $etc='csv';
        }else if($etc == "mp3"){
            $etc='audio';
        }else{
            $etc='image';
        }

        $file= public_path().'/assets/eduplaycloud/upload/exercisesset/user-'.$userid.'/'.$etc.'/'.$path;
        unlink($file);
        return 'success';
        return redirect()->route('myassets');
    }

    // Upload file direct folder
    public function myassetsUpload (Request $request) {
        //dd($request->userfiles->originalName);
        foreach($request->userfiles as $name){
            $fileExtension = $name->getClientOriginalExtension();
            if($fileExtension == 'mp3'){
                $ext='audio';
            } elseif($fileExtension == 'csv') {
                $ext='csv';
            } else {
                $ext='image';
            }

            $path=public_path().'/assets/eduplaycloud/upload/exercisesset/user-'.Auth::user()->id.'/'.$ext;

            $fileName = str_replace(' ', '_',$name->getClientOriginalName());
            // echo $fileName;
            if (file_exists($path.'/'.$fileName)){
              if($ext == 'csv'){
                $name->move($path, $fileName);
              } else {
                continue;
              }
            }else{
                $name->move($path, $fileName);
            }
        }
        return 'true';
    }

    //Calculate directory size for file quota.
    public function calculateDirectorySize(){

        $file_size = 0;
        $path = public_path('assets/eduplaycloud/upload/exercisesset/user-'.Auth::user()->id);
        foreach( File::allFiles($path) as $file)
        {
            $file_size += $file->getSize();
        }
        
        return number_format($file_size / 1000000,2);
    }

    /**
     * check CSV File exists or not...  and count affected questions.
     */
    public function checkFileExists(){
      $name = request('name');
      $path=public_path().'/assets/eduplaycloud/upload/exercisesset/user-'.Auth::user()->id.'/csv';

      $fileName = str_replace(' ', '_',$name);
      // echo $fileName;
      if (file_exists($path.'/'.$fileName)){
        $effetedQuestion =  Question::where('param','=',$fileName)->count();

        return response()->json(['exists' => true,'question_count' => $effetedQuestion]);
      } else {
        return response()->json(['exists' => false,'question_count' => 0]);
      }

    }
}
