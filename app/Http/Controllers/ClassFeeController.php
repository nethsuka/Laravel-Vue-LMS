<?php

namespace App\Http\Controllers;

use App\Models\StuClaSlip;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassFeeController extends Controller
{
    public function index() {

        $results = DB::table('stu_cla_slips as s')
            ->join('users as u', 's.user_id', '=', 'u.id')
            ->join('slips as sl', 's.slip_id', '=', 'sl.id')
            ->join('stclasses as st', 's.user_id', '=', 'st.user_id')
            ->join('tuition_classes as cl', 'st.tuition_class_id', '=', 'cl.id')
            ->leftJoin('stu_cla_slips as sc', 's.slip_id', '=', 'sc.slip_id')
            ->leftJoin('tuition_classes as paid_cl', 'sc.tuition_class_id', '=', 'paid_cl.id')
            ->select(
                's.slip_id',
                'u.name as student_name',
                DB::raw('GROUP_CONCAT(DISTINCT cl.class_name ORDER BY cl.class_name) as joined_classes'),
                DB::raw('GROUP_CONCAT(DISTINCT paid_cl.class_name ORDER BY paid_cl.class_name) as paid_classes'),
                'sl.note as slip_note',
                'sl.slip_url as slip_url',
                'sl.st_email as user_email',
                's.paid as paid',
                's.created_at as payment_date',
                's.updated_at'
            )
            ->groupBy(
                's.slip_id',
                'u.name',
                'sl.note',
                'sl.slip_url',
                'sl.st_email',
                's.paid',
                's.created_at',
                's.updated_at'
            )
            ->get();


        return Inertia::render('Admin/ClassFee', ['results' => $results]);
        // return response()->json(['results' => $results]);
    }

    public function acceptPayment(Request $request) {

        StuClaSlip::where('slip_id', $request->slipID)->update(['paid' => 'yes']);
    }
}
