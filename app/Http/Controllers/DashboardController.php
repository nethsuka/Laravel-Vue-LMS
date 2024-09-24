<?php

namespace App\Http\Controllers;

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

        // $stclassRecords = Stclass::where('user_id', Auth::id())->get(['user_id','tuition_class_id']);
        // $classDetails = TuitionClass::get(['id','class_name','tele_group']);

        $paidClassArray = Stclass::where('user_id', Auth::id())->pluck('tuition_class_id')->toArray();
        
        $classDetails = TuitionClass::whereIn('id', $paidClassArray)->get(['id', 'class_name', 'tele_group']);
        $extendDetails = StExtendDate::where('user_email', Auth::user()->email)->first('extend_date');
        $paidClassDetails = StuClaSlip::where('user_id', Auth::id())->get(['tuition_class_id','paid']);
        $videoLinks = ClassVideo::all();

        return Inertia::render('Dashboard', [ 
            'classDetails' => $classDetails,
            'extendDetails' => $extendDetails,
            'paidClassDetails' => $paidClassDetails,
            'videoLinks' => $videoLinks,
        ]);
        
        // return response()->json(['classDetails' => $classDetails]);
    }

    public function joinClass(Request $request) {

        $student = User::find(Auth::id());

        // Find the class by its ID
        // $class = TuitionClass::where('id', $request->classID)->first(['class_name']);

        // $student->tuition_classes()->attach($request->className);
        DB::table('stclasses')->insert([
            'user_id' => Auth::id(),
            'tuition_class_id' => $request->classID,
        ]);
        // return response()->json(['stclassRecord' => $className]);
    }

    public function joinOnline(Request $request) {

        $linkData = TuitionClass::where('id', $request->classID)->first('zoom_link');

        return Inertia::location($linkData->zoom_link);
    }
}
