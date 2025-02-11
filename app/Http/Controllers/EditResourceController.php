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

    public function updateResourceVideoList(Request $request) {

        $videos = ResourceVideo::where('resource_id', $request->resourceId)->get();

        if($request->updatedArray != null) {
            // Convert updatedArray from request to ClassVideo instances if necessary
            $modifiedList = collect($request->updatedArray)->map(function ($item) {
                return ResourceVideo::find($item['id']);  // Find ClassVideo instances by ID
            });

            // Call the function to find missing items
            $missingItems = $this->findMissingItems($videos, $modifiedList);

            foreach($missingItems as $item) {
                ResourceVideo::where('id', $item->id)->delete();
            }

            foreach ($request->updatedArray as $updateObj) {
                // Accessing 'id' as an array element
                ResourceVideo::where('id', $updateObj['id'])->update([
                    'link' => $updateObj['link'],
                    'name' => $updateObj['name'],
                    'index' => $updateObj['index'],
                ]);
            }
            
            // return response()->json(['missingItems' => $request->modifiedList]);
            return back()->with([
                'successMsg' => 'Changes saved successfully',
            ]);
        }
    }

    // Function to find missing items in $partialArray from $fullArray based on 'id'
    public function findMissingItems($fullArray, $partialArray) {
        // Extract IDs from the partial array
        $partialIds = $partialArray->pluck('id')->toArray();  // Use 'pluck' to get just the IDs

        // Find objects in the full array whose ID is not in the partial array
        return $fullArray->filter(function ($obj) use ($partialIds) {
            return !in_array($obj->id, $partialIds);
        });
    }

}
