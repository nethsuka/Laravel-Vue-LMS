<?php

namespace App\Http\Controllers;

use App\Models\ClassVideo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExtraLessonsController extends Controller
{
    private $extraLessons;

    public function __construct() {

        $this->extraLessons = ClassVideo::all();
    }

    public function index() {
        return Inertia::render('ExtraLessons', [ 
            'extraLessons' => $this->extraLessons,
        ]);
    }
}
