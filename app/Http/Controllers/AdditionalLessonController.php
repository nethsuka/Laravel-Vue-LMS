<?php

namespace App\Http\Controllers;

use App\Models\ExtraVideo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdditionalLessonController extends Controller
{
    private $extendDetails;

    public function __construct()
    {
        $this->extendDetails = ExtraVideo::all();
    }

    public function index() {
        return Inertia::render('Admin/AdditionalLesson', [ 
            'extendDetails' => $this->extendDetails
        ]);
    }

    public function deleteExtraVideo(Request $request) {
        $process = ExtraVideo::where('id', $request->id)->delete();
    
        if($process){
            return back()->with([
                'successMsg' => 'Extra lesson deleted successfully.',
            ]);
        }else{
            return back()->with([
                'errorMsg' => 'Error occured !',
            ]);
        }
    }
}
