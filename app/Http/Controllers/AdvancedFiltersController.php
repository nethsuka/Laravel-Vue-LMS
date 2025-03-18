<?php

namespace App\Http\Controllers;

use App\Models\TuitionClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdvancedFiltersController extends Controller
{
    // private $studentAndPaymentDetails;
    private $finalQuery;
    private $classDetails;

    public function __construct()
    {
        // $this->studentAndPaymentDetails = DB::table('stu_cla_slips as scs')
        //                                     ->join('users as u', 'scs.user_id', '=', 'u.id')
        //                                     ->join('tuition_classes as tc', 'scs.tuition_class_id', '=', 'tc.id')
        //                                     ->leftJoin('stclasses as sc', function ($join) {
        //                                         $join->on('scs.user_id', '=', 'sc.user_id')
        //                                             ->on('scs.tuition_class_id', '=', 'sc.tuition_class_id');
        //                                     })
        //                                     ->select(
        //                                         'u.id as user_id',
        //                                         'u.name as student_name',
        //                                         'u.email',
        //                                         'u.w_number',
        //                                         'u.exam_year',
        //                                         'tc.id as class_id',
        //                                         'tc.class_name',
        //                                         DB::raw("CASE WHEN sc.id IS NOT NULL THEN 'yes' ELSE 'no' END as payment_status")
        //                                     )
        //                                     ->get();

        $firstPart = DB::table('stclasses as sc')
                        ->join('users as u', 'sc.user_id', '=', 'u.id')
                        ->join('tuition_classes as tc', 'sc.tuition_class_id', '=', 'tc.id')
                        ->leftJoin('stu_cla_slips as scs', function($join) {
                            $join->on('sc.user_id', '=', 'scs.user_id')
                                ->on('sc.tuition_class_id', '=', 'scs.tuition_class_id');
                        })
                        ->select(
                            'u.id as user_id',
                            'u.name as student_name',
                            'u.email',
                            'u.w_number',
                            'u.exam_year',
                            'tc.id as class_id',
                            'tc.class_name',
                            DB::raw("COALESCE(scs.paid, 'no') as payment_status")
                        );

        $secondPart = DB::table('stu_cla_slips as scs')
                        ->join('users as u', 'scs.user_id', '=', 'u.id')
                        ->join('tuition_classes as tc', 'scs.tuition_class_id', '=', 'tc.id')
                        ->select(
                            'u.id as user_id',
                            'u.name as student_name',
                            'u.email',
                            'u.w_number',
                            'u.exam_year',
                            'tc.id as class_id',
                            'tc.class_name',
                            'scs.paid as payment_status'
                        );

        // Combine both parts using union
        $this->finalQuery = $firstPart->union($secondPart)->get();

        $this->classDetails = TuitionClass::pluck('class_name');
    }

    public function index() {
        return Inertia::render('Admin/AdvancedFilters', [ 
            'studentAndPaymentDetails' => $this->finalQuery,
            'classDetails' => $this->classDetails
        ]);
    }
}
