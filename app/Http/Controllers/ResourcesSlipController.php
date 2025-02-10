<?php

namespace App\Http\Controllers;

use App\Models\ResourceSlip;
use App\Models\StuResSlip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ResourcesSlipController extends Controller
{
    private $resourcesPaymentDetails;

    public function __construct()
    {
        $this->resourcesPaymentDetails = DB::table('stu_res_slips')
                                            ->join('users', 'stu_res_slips.user_id', '=', 'users.id')
                                            ->join('resources', 'stu_res_slips.resource_id', '=', 'resources.id')
                                            ->join('resource_slips', 'stu_res_slips.slip_id', '=', 'resource_slips.id')
                                            ->select(
                                                'users.name as student_name',
                                                'users.email as student_email',
                                                'stu_res_slips.slip_id',
                                                'resource_slips.slip_url',
                                                'resource_slips.note',
                                                'stu_res_slips.paid',
                                                'stu_res_slips.expiry_date',
                                                'resource_slips.created_at as payment_date',
                                                DB::raw("GROUP_CONCAT(resources.name SEPARATOR ', ') as selected_resources")
                                            )
                                            ->groupBy(
                                                'stu_res_slips.slip_id',
                                                'users.name',
                                                'users.email',
                                                'resource_slips.slip_url',
                                                'resource_slips.note',
                                                'stu_res_slips.paid',
                                                'stu_res_slips.expiry_date',
                                                'resource_slips.created_at'
                                            )
                                            ->get();
    }

    public function index() {
        return Inertia::render('Admin/ResourcesSlip', [ 
            'resourcesPaymentDetails' => $this->resourcesPaymentDetails
        ]);
    }

    public function acceptPayment(Request $request) {

        StuResSlip::where('slip_id', $request->slipID)
                    ->update([
                        'paid' => 'yes',
                        'expiry_date' => Carbon::now('Asia/Colombo')->addDays(30)
                    ]);
    }

    public function deletePayment(Request $request) {

        $data = ResourceSlip::find($request->slipID);
        if ($data) {
            $filePath = $data->slip_url;
    
            // Check if the file exists in the storage
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
    
            ResourceSlip::destroy($request->slipID);
        }  
    }

    public function deleteExpiredRecords() {
        $expiredSlipIds = StuResSlip::whereNotNull('expiry_date')
            ->where('expiry_date', '<', Carbon::now('Asia/Colombo'))
            ->pluck('slip_id') // Get only the slip_id column
            ->unique(); // Ensure unique slip_ids

        foreach ($expiredSlipIds as $slipId) {
            $slip = ResourceSlip::where('id', $slipId)->first(); // Assuming the table is called 'slip'

            if ($slip && $slip->slip_url) {
                $filePath = $slip->slip_url; // Get the slip_url which contains the file path

                // Step 3: Check if the file exists before attempting to delete
                if (Storage::disk('public')->exists($filePath)) {
                    // Delete the file from storage
                    Storage::disk('public')->delete($filePath);
                }

                $slip->delete();

            }
        }
    }
}
