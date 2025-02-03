<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ResourceControlsController extends Controller
{
    public function index() {

        $resourcesWithVideoCount = Resource::withCount('videos')->get();


        return Inertia::render('Admin/ResourceControls', [ 
            'resourcesWithVideoCount' => $resourcesWithVideoCount
        ]);

        // return response()->json(['resourcesWithVideoCount' => $resourcesWithVideoCount]);

    }
}
