<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\ClassVideo;
use Illuminate\Http\Request;

class ClassControlsController extends Controller
{
    private $videoDetails;

    public function __construct()
    {
        $this->videoDetails = ClassVideo::all();  // Assuming this is an Eloquent collection
    }

    public function index() {
        return Inertia::render('Admin/ClassControls', [ 
            'videoDetails' => $this->videoDetails,
        ]);
    }

    public function updateClassVideoList(Request $request) {
        // Convert modifiedList from request to ClassVideo instances if necessary
        $modifiedList = collect($request->modifiedList)->map(function ($item) {
            return ClassVideo::find($item['id']);  // Find ClassVideo instances by ID
        });

        // Call the function to find missing items
        $missingItems = $this->findMissingItems($this->videoDetails, $modifiedList);

        foreach($missingItems as $item) {
            ClassVideo::where('id', $item->id)->delete();
        }

        foreach ($request->modifiedList as $updateObj) {
            // Accessing 'id' as an array element
            ClassVideo::where('id', $updateObj['id'])->update([
                'video_link' => $updateObj['video_link'],
                'video_name' => $updateObj['video_name'],
                'index' => $updateObj['index'],
            ]);
        }
        
        // return response()->json(['missingItems' => $request->modifiedList]);
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
