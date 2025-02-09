<?php

namespace App\Http\Controllers;

use App\Models\ExtraVideo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdditionalLessonController extends Controller
{
    private $extendDetails;

    public function __construct()
    {
        $this->extendDetails = ExtraVideo::all();
    }

    public function index() {
        return Inertia::render('Admin/AdditionalLesson', [ 
            'extendDetails' => $this->extendDetails
        ]);
    }
}
