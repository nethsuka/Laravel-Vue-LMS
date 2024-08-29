<?php

namespace App\Http\Controllers;

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
        $classDetails = TuitionClass::all();
        $extendDetails = StExtendDate::where('user_email', Auth::user()->email)->get('extend_date');
        $paidClassDetails = StuClaSlip::where('user_id', Auth::id())->get(['tuition_class_id','paid']);
        return Inertia::render('Dashboard', [
            'stclassRecords' => $stclassRecords, 
            'classDetails' => $classDetails,
            'extendDetails' => $extendDetails,
            'paidClassDetails' => $paidClassDetails,
        ]);
        // return response()->json(['stclassRecords' => $stclassRecords]);
    }

    public function joinClass(Request $request) {

        $student = User::find(Auth::id()); // Assuming 'user' is a Student model

        // Find the class by its ID
        $class = TuitionClass::findOrFail($request->className);

        // Attach the class to the student's classes
        $student->tuition_classes()->attach($request->className);
        // return response()->json(['stclassRecord' => $request->className]);
        // return Inertia::render('Dashboard');
    }
}
