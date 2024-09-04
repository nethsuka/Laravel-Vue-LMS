<?php

namespace App\Http\Controllers;

use App\Models\ClassTute;
use App\Models\ClassVideo;
use Inertia\Inertia;
use App\Models\Stclass;
use App\Models\StExtendDate;
use App\Models\StuClaSlip;
use App\Models\TuitionClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {

        $stclassRecords = Stclass::where('user_id', Auth::id())->get(['user_id','tuition_class_id']);
        $classDetails = TuitionClass::get(['id','class_name','tele_group']);
        $extendDetails = StExtendDate::where('user_email', Auth::user()->email)->first('extend_date');
        $paidClassDetails = StuClaSlip::where('user_id', Auth::id())->get(['tuition_class_id','paid']);
        $videoLinks = ClassVideo::all();

        return Inertia::render('Dashboard', [
            'stclassRecords' => $stclassRecords, 
            'classDetails' => $classDetails,
            'extendDetails' => $extendDetails,
            'paidClassDetails' => $paidClassDetails,
            'videoLinks' => $videoLinks,
        ]);
        // return response()->json(['videoLinks' => $videoLinks,]);
    }

    public function joinClass(Request $request) {

        $student = User::find(Auth::id()); // Assuming 'user' is a Student model

        // Find the class by its ID
        $class = TuitionClass::findOrFail($request->className);

        // Attach the class to the student's classes
        $student->tuition_classes()->attach($request->className);
        // return response()->json(['stclassRecord' => $request->className]);
    }

    public function joinOnline(Request $request) {

        $linkData = TuitionClass::where('id', $request->classID)->first('zoom_link');

        return Inertia::location($linkData->zoom_link);
    }
}
