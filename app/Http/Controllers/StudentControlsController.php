<?php

namespace App\Http\Controllers;

use App\Models\StExtendDate;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentControlsController extends Controller
{
    private $studentDetails;
    private $extendDetails;

    public function __construct()
    {
        $this->studentDetails = User::all();
        $extendDetails = StExtendDate::all();
    }

    public function index() {
        return Inertia::render('Admin/StudentControls', [ 
            'studentDetails' => $this->studentDetails,
            'extendDetails' => $this->extendDetails
        ]);
    }
}
