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

    public function addResource(Request $request) {

        $videoAdd = Resource::create([
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category
        ]);

        if($videoAdd){
            return back()->with([
                'successMsg' => 'Resource added successfully',
            ]);
        }else{
            return back()->with([
                'errorMsg' => 'Error occured !',
            ]);
        }
    }

    public function deleteResource(Request $request) {
        $deleteResource = Resource::where('id', $request->resource_id)->delete();

        if($deleteResource){
            return back()->with([
                'successMsg' => 'Resource deleted successfully',
            ]);            
        }else{
            return back()->with([
                'errorMsg' => 'Error occured !',
            ]);
        }
    }
}
