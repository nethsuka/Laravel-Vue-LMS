<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class EditResourceController extends Controller
{
    public function show($resourceId){
        $resource = Resource::findOrFail($resourceId);
        $videos = ResourceVideo::where('resource_id', $resourceId)->get();

        return Inertia::render('Admin/EditResource', [ 
            'resource' => $resource,
            'videos' => $videos
        ]);

    }

    public function saveResourceChanges(Request $request) {
        $resource = Resource::findOrFail($request->id);

        $updated =  $resource->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'category' => $request->input('category'),
        ]);

        if($updated){
            return back()->with([
                'successMsg' => 'Changes saved successfully',
            ]);
        }else{
            return back()->with([
                'errorMsg' => 'Error occured !',
            ]);
        }
    }

    public function addVideo(Request $request) {

        $videoAdd = ResourceVideo::create([
            'resource_id' => $request->resource_id,
            'name' => $request->name,
            'link' => $request->link,
            'index' => $request->index
        ]);

        if($videoAdd){
            return back()->with([
                'successMsg' => 'Video added successfully',
            ]);
        }else{
            return back()->with([
                'errorMsg' => 'Error occured !',
            ]);
        }
    }

}
