<?php

namespace App\Http\Controllers;

use App\Models\Slip;
use App\Models\Stclass;
use App\Models\StuClaSlip;
use App\Models\TuitionClass;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ClassFeeController extends Controller
{
    public function index() {

        $results = DB::table('stu_cla_slips as s')
            ->join('users as u', 's.user_id', '=', 'u.id')
            ->join('slips as sl', 's.slip_id', '=', 'sl.id')
            ->leftJoin('stclasses as st', 's.user_id', '=', 'st.user_id') // Changed to LEFT JOIN
            ->leftJoin('tuition_classes as cl', 'st.tuition_class_id', '=', 'cl.id')
            ->leftJoin('stu_cla_slips as sc', 's.slip_id', '=', 'sc.slip_id')
            ->leftJoin('tuition_classes as paid_cl', 'sc.tuition_class_id', '=', 'paid_cl.id')
            ->select(
                's.slip_id',
                'u.name as student_name',
                'u.id as stID',
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
                'u.id',
                'sl.note',
                'sl.slip_url',
                'sl.st_email',
                's.paid',
                's.created_at',
                's.updated_at'
            )
            ->orderBy('s.created_at', 'DESC') // Order by latest created records
            ->get();



        return Inertia::render('Admin/ClassFee', ['results' => $results]);
        // return response()->json(['results' => $results]);
    }


    public function acceptPayment(Request $request) {

        $paidClasses = explode(',', $request->paidClasses);
        $student = User::find($request->stID);

        foreach ($paidClasses as $class) {
            $classID = TuitionClass::where('class_name', $class)->first('id');
            
            // Check if the record already exists
            $recordExists = DB::table('stclasses')
                ->where('user_id', $student->id)
                ->where('tuition_class_id', $classID->id)
                ->exists();
            
            // If the record doesn't exist, insert it
            if (!$recordExists) {
                DB::table('stclasses')->insert([
                    'user_id' => $student->id,
                    'tuition_class_id' => $classID->id,
                ]);
            }
        }

        StuClaSlip::where('slip_id', $request->slipID)->update(['paid' => 'yes']);
    }


    public function undoPayment(Request $request) {

        $paidClasses = explode(',', $request->paidClasses);
        $student = User::find($request->stID);

        foreach ($paidClasses as $class) {
            $classID = TuitionClass::where('class_name', $class)->first('id');

            DB::table('stclasses')
                ->where('user_id', $student->id)
                ->where('tuition_class_id', $classID->id)
                ->delete();
        }

        StuClaSlip::where('slip_id', $request->slipID)->update(['paid' => 'no']);
    }


    public function clearSlipTable() {

        $joinClassData = Stclass::select('user_id', 'tuition_class_id')->get();
        $paidClasData = StuClaSlip::select('user_id', 'tuition_class_id', 'paid')->get();

        if (count($paidClasData) == 0) {
            return;
        }

        foreach ($joinClassData as $classObj) {
            $found = false;
    
            foreach ($paidClasData as $paidObj) {
                // Check if both user_id and tuition_class_id match
                if ($classObj->user_id == $paidObj->user_id && $classObj->tuition_class_id == $paidObj->tuition_class_id) {
                    $found = true; // A match was found
                    break; // Exit the inner loop early
                }
            }
    
            // If not found in paidClasData, delete the record from Stclass
            if (!$found) {
                // $classObj->delete();
                Stclass::where('user_id', $classObj->user_id)
                    ->where('tuition_class_id', $classObj->tuition_class_id)
                    ->delete();
            }
        }

        Slip::query()->delete();
        // StuClaSlip::query()->delete();

        $directory = 'monthly_slips'; // Directory inside 'public' disk

        // Ensure the directory exists
        if (Storage::disk('public')->exists($directory)) {
            // Get all files from the directory
            $files = Storage::disk('public')->files($directory);

            // Delete each file
            foreach ($files as $file) {
                Storage::disk('public')->delete($file);
            }
        }

    }

    public function deleteStudentSlip(Request $request) {
        $data = Slip::find($request->slipID);
        if ($data) {
            $filePath = $data->slip_url; // Get the file path (relative to the 'public' disk)
    
            // Check if the file exists in the storage
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
    
            Slip::destroy($request->slipID);
    
        }
    }
}
