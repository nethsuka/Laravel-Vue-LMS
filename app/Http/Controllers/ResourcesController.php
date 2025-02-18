<?php

namespace App\Http\Controllers;

use App\Models\StuResSlip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ResourcesController extends Controller
{
    public function index() {
        $userId = Auth::user()->id;

        $userResourcesInfo = DB::table('resources as r')
            ->leftJoin('stu_res_slips as srs', function ($join) use ($userId) {
                $join->on('r.id', '=', 'srs.resource_id')
                    ->where('srs.user_id', '=', $userId);
            })
            ->select(
                'r.id as resource_id',
                'r.name as resource_name',
                'r.price',
                'r.category',
                DB::raw("COALESCE(srs.paid, 'no') as paid"),
                'srs.expiry_date',
                DB::raw("CASE WHEN srs.resource_id IS NOT NULL THEN TRUE ELSE FALSE END AS buy")
            )
            ->get();

        // Get the current date and time in Sri Lanka timezone
        $todayInSriLanka = Carbon::now('Asia/Colombo');

        $userVideoData = DB::table('resources as r')
            ->leftJoin('stu_res_slips as srs', function($join) {
                $join->on('r.id', '=', 'srs.resource_id')
                    ->where('srs.user_id', '=', Auth::user()->id);
            })
            ->leftJoin('resource_videos as rv', 'r.id', '=', 'rv.resource_id')
            ->where(function($query) use ($todayInSriLanka) {
                $query->whereNull('srs.expiry_date')
                    ->orWhere('srs.expiry_date', '>', $todayInSriLanka);
            })
            ->where('srs.user_id', $userId)
            ->where('srs.paid', 'yes')
            ->select('r.id as resource_id', 'rv.id as video_id', 'rv.name as video_name', 'rv.link as video_link', 'rv.index as video_index')
            ->get();


        $paidResources = StuResSlip::join('resources', 'stu_res_slips.resource_id', '=', 'resources.id')
            ->where('stu_res_slips.user_id', Auth::id())
            ->where('stu_res_slips.expiry_date', '>=', $todayInSriLanka)
            ->select('stu_res_slips.*', 'resources.name as resource_name')
            ->get();

        return Inertia::render('Resources', [ 
            'userResourcesInfo' => $userResourcesInfo,
            'userVideoData' => $userVideoData,
            'paidResources' => $paidResources,
        ]);
        // return response()->json(['userVideoData' => $userVideoData]);
    }
}
