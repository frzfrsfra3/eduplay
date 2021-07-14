<?php
namespace App\Http\Controllers\Pins;
use App\Models\Pin;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Session;
use App\Models\Exerciseset;
use Illuminate\Support\Facades\Lang;
use App\Http\Traits\AddXppoint;
class PinsController extends Controller {

    use AddXppoint;
    public function __construct() {

    }

    /**
     * Developed by : WC
     * Used to create new pins
     * 
     * param Illuminate\Http\Request $request
     * return Redirect
     */
    public function store(Request $request) {
        try {
            $uid = Auth::user()->id;
            $pin = new Pin;
            $pin->user_id = $uid;
            $pin->class_id = $request->class_id;
            $pin->description = $request->description;
            $pin->url = $request->url;
            if ($request->hasFile('image')) { // Check if image is in requested data
                $name = $this->imageUpload($request->file('image'));
                $pin->image = $name;
            }
            $pin->save(); // save record
            $this->add_xp_point (Auth::user ()->id, 'createpins');
            if ($request->class_id != "") {
                return redirect()->route('courseclasses.courseclass.show', [$request->class_id,'#resources#pills-pins'])->with('success_message', Lang::get('pins.pins_created'));
            } else {
                return redirect()->route('exercisesets.exerciseset.private','#pills-pins')->with('success_message', Lang::get('pins.pins_created'));
            }
        }
        catch(Exception $exception) {
            return back()->withInput()->with(['error_message' => $exception->getMessage() ]); // Return specific error
            
        }
    }

    /**
     * Developed by : WC
     * This function is used to fetch pin data based on its id
     * 
     * param int $id
     * return Response
    */
    public function edit($id) {
        $findPin = Pin::findOrFail($id);
        return $findPin;
    }

    /**
     * Developed By : WC
     * This function is used to update pin record
     * 
     * param Illuminate\Http\Request $request
     * return Redirect
    */
    public function update(Request $request) {
        try {
            $pin = Pin::find($request->id);
            $pin->description = $request->description;
            $pin->url = $request->url;
            if ($request->hasFile('image')) { // Check if image is in requested data
                $name = $this->imageUpload($request->file('image'));
                $pin->image = $name;
            }
            $pin->save(); // update record
            if ($request->class_id != "") {
                return redirect()->route('courseclasses.courseclass.show', [$request->class_id , '#resources#pills-pins'])->with('success_message', Lang::get('pins.pins_updated'));
            } else {
                return redirect()->route('exercisesets.exerciseset.private','#pills-pins')->with('success_message', Lang::get('pins.pins_updated'));
            }
        }
        catch(Exception $exception) {
            return back()->withInput()->with(['error_message' => $exception->getMessage() ]); // Return specific error
            
        }
    }

    /**
     * Developed by : WC
     * This function is ued to upload pin images
     * 
     * param String $image
     * return $name
     */
    public function imageUpload($image) {
        $uid = Auth::user()->id;
        $name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path() . "/assets/eduplaycloud/users-$uid/pins", $name);
        return $name;
    }

    /**
     * Developed by : WC
     * This function is used to delete pins
     * 
     * param int $id
     * return Redirect
     */
    public function destroy($id) {
        $pin = Pin::find($id);
        $classId = $pin->class_id;
        $pin->delete();
        if ($classId != null) {
            return redirect()->route('courseclasses.courseclass.show', [$classId,'#resources#pills-pins'])->with('success_message', Lang::get('pins.pins_deleted'));
        } else {
            return redirect()->route('exercisesets.exerciseset.private','#pills-pins')->with('success_message', Lang::get('pins.pins_deleted'));
        }
    }
}
