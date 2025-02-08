<?php

namespace App\Http\Controllers;

use App\Models\ExtraVideo;
use App\Models\StExtendDate;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentControlsController extends Controller
{
    private $studentDetails;
    private $extendDetails;

    public function __construct()
    {
        $this->studentDetails = User::all();
        $this->extendDetails = StExtendDate::all();
    }

    public function index() {
        return Inertia::render('Admin/StudentControls', [ 
            'studentDetails' => $this->studentDetails,
            'extendDetails' => $this->extendDetails
        ]);
    }

    public function updateExtendDate(Request $request) {

        $updateRecorde = StExtendDate::where('user_email', $request->email)->update(['extend_date' => $request->newDate,]);

        if($updateRecorde) {
            return back()->with([
                'successMsg' => 'Date updated successfully.',
            ]);
        }
    }

    public function addExtraVideo(Request $request) {
        $videoAdd = ExtraVideo::create([
            'st_id' => $request->st_id,
            'st_name' => $request->st_name,
            'st_email' => $request->st_email,
            'name' => $request->name,
            'video_link' => $request->video_link,
            'expiry_date' => $request->expiry_date
        ]);

        if($videoAdd){
            return back()->with([
                'successMsg' => 'Video added successfully',
            ]);
        }else{
            return back()->with([
                'errorMsg' => 'Error occured !',
            ]);
        }
    }

    public function deleteUser(Request $request) {
        $user = User::findOrFail($request->stu_id);
        $email = $user->email;
        StExtendDate::where('user_email', $email)->delete();
        $complete = $user->delete();

        if($complete){
            return back()->with([
                'successMsg' => 'User deleted successfully',
            ]);
        }else{
            return back()->with([
                'errorMsg' => 'Error occured !',
            ]);
        }
    }
}
