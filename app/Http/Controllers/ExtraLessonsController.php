<?php

namespace App\Http\Controllers;

use App\Models\ClassVideo;
use App\Models\ExtraVideo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExtraLessonsController extends Controller
{
    private $extraLessons;

    public function __construct() {

        $this->extraLessons = ExtraVideo::where('st_id', Auth::id())
                                ->where('expiry_date', '>=', Carbon::now('Asia/Colombo'))
                                ->get();
    }

    public function index() {
        return Inertia::render('ExtraLessons', [ 
            'extraLessons' => $this->extraLessons,
        ]);
    }
}
