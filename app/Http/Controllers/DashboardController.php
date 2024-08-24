<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Stclass;
use App\Models\TuitionClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {

        $stclassRecords = Stclass::where('id', Auth::id())->get();
        $classDetails = TuitionClass::all();
        return Inertia::render('Dashboard', [
            'stclassRecords' => $stclassRecords, 
            'classDetails' => $classDetails
        ]);
        // return response()->json(['stclassRecords' => $classDetails]);
    }

    public function joinClass(Request $request) {
        // $className = $request->input('className');
        // return response()->json(['stclassRecord' => $request->className]);

        $student = User::find(Auth::id()); // Assuming 'user' is a Student model

        // Find the class by its ID
        $class = TuitionClass::findOrFail($request->className);

        // Attach the class to the student's classes
        $student->tuition_classes()->attach($request->className);
        return response()->json(['stclassRecord' => $request->className]);
    }
}
