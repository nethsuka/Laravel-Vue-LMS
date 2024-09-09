<?php

namespace App\Http\Controllers;

use App\Models\Slip;
use Inertia\Inertia;
use App\Models\StuClaSlip;
use App\Models\TuitionClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function index() {
        $classDetails = TuitionClass::all();
        $paidClasses = DB::table('stu_cla_slips')
                        ->join('tuition_classes', 'stu_cla_slips.tuition_class_id', '=', 'tuition_classes.id')
                        ->where('stu_cla_slips.user_id', Auth::id())
                        ->pluck('tuition_classes.class_name');

        return Inertia::render('Payment', [
            'classDetails' => $classDetails,
            'paidClasses' => $paidClasses,
        ]);
        // return response()->json(['paidClasses' => $paidClasses]);

    }

    public function store(Request $request) {
        
        $form1_data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'paid_classes' => 'required|array',
            'slip' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        //------------Saving data in Zip file starts------------
        $classes_paid = implode(',', $form1_data['paid_classes']);

        $slip = $request->file('slip');
        $fileName = time() . '_' . $slip->getClientOriginalName(); //making a file name
        // $slip->move(public_path('mounthly_slips'), $fileName);
        $path = $slip->storeAs('monthly_slips', $fileName, 'public');

        Slip::create([
            'note' => $request->note,
            'slip_url' => $path,
            'paid_classes' => $classes_paid,
            'st_email' => $request->email,
        ]);
        //-----------Saving data in Zip file ends-------------

        foreach ($form1_data['paid_classes'] as $class) {
            $classID = TuitionClass::where('class_name', $class)->value('id');
            $slipID = Slip::where('slip_url', $path)->value('id');
            $stID = Auth::user()->id;

            StuClaSlip::create([
                'user_id' => $stID,
                'tuition_class_id' => $classID,
                'slip_id' => $slipID,
            ]);
        }
        
        return back()->with([
            'successMsg' => 'Payment details submitted successfully.',
        ]);
    }
}
