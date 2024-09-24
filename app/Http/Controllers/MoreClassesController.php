<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TuitionClass;
use App\Models\StuClaSlip;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;


class MoreClassesController extends Controller
{
    
    public function index() {

        $classDetails = TuitionClass::get(['id','class_name','tele_group']);
        $paidClassDetails = StuClaSlip::where('user_id', Auth::id())->get(['tuition_class_id','paid']);

        return Inertia::render('MoreClasses', [
            'classDetails' => $classDetails,
            'paidClassDetails' => $paidClassDetails,
        ]);

        // return response()->json(['classDetails' => $classDetails]);
        // return response()->json(['paidClassDetails' => $paidClassDetails]);

    }
}
