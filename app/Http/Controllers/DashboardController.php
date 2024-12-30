<?php

namespace App\Http\Controllers;

use App\Models\ClassTute;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Stclass;
use App\Models\ClassVideo;
use App\Models\StuClaSlip;
use App\Models\StExtendDate;
use App\Models\TuitionClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {

        $paidClassArray = Stclass::where('user_id', Auth::id())->pluck('tuition_class_id')->toArray();
        
        $classDetails = TuitionClass::whereIn('id', $paidClassArray)->get(['id', 'class_name', 'tele_group']);
        $extendDetails = StExtendDate::where('user_email', Auth::user()->email)->first('extend_date');
        $paidClassDetails = StuClaSlip::where('user_id', Auth::id())->get(['tuition_class_id','paid']);
        $videoLinks = ClassVideo::all();
        $classTutes = ClassTute::all();

        return Inertia::render('Dashboard', [ 
            'classDetails' => $classDetails,
            'extendDetails' => $extendDetails,
            'paidClassDetails' => $paidClassDetails,
            'videoLinks' => $videoLinks,
            'classTutes' => $classTutes,

        ]);
        
        // return response()->json(['classDetails' => $classDetails]);
    }
    

    public function joinOnline(Request $request) {

        $linkData = TuitionClass::where('id', $request->classID)->first('zoom_link');

        return Inertia::location($linkData->zoom_link);
    }
}
