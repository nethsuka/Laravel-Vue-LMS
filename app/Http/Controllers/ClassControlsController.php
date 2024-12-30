<?php

namespace App\Http\Controllers;

use App\Models\ClassTute;
use Inertia\Inertia;
use App\Models\ClassVideo;
use App\Models\TuitionClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ClassControlsController extends Controller
{
    private $videoDetails;
    private $classDetails;
    private $tuteDetails;

    public function __construct()
    {
        $this->videoDetails = ClassVideo::all();  // Assuming this is an Eloquent collection
        $this->classDetails = TuitionClass::select('id', 'class_name', 'tele_group','zoom_link')->get();
        $this->tuteDetails = ClassTute::all();
    }

    public function index() {
        return Inertia::render('Admin/ClassControls', [ 
            'videoDetails' => $this->videoDetails,
            'classDetails' => $this->classDetails,  
            'tuteDetails' => $this->tuteDetails,  
        ]);
                    // return response()->json(['tuteDetails' => $this->tuteDetails]);

    }

    public function updateClassVideoList(Request $request) {

        if($request->modifiedList != null) {
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
                    'expiry_date' => $updateObj['expiry_date'],
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

    public function addNewClass(Request $request) {

        $existingClass = TuitionClass::where('class_name', $request->class_name)->first();

        if ($existingClass) {
            // return response()->json(['error' => 'Class with this name already exists.'], 400);
            return;
        }

        TuitionClass::create([
            'class_name' => $request->class_name,
            'zoom_link' => $request->zoom_link,
            'tele_group' => $request->tele_link,
        ]);

        return back()->with([
            'successMsg' => 'Class added successfully.',
        ]);
        // return Redirect::route('class_controls');
    }

    public function updateclass(Request $request) {

        TuitionClass::where('class_name', $request->class_name)->update([
            'tele_group' => $request->tele_group,
            'zoom_link' => $request->zoom_link,
        ]);

        return back()->with([
            'successMsg' => 'Class details updated successfully.',
        ]);
    }

    public function addNewVideo(Request $request) {

        ClassVideo::create([
            'tuition_class_id' => $request->tuition_class_id,
            'video_link' => $request->video_link,
            'video_name' => $request->video_name,
            'expiry_date' => $request->expiry_date,
            'index' => $request->index,
        ]);

        return back()->with([
            'successMsg' => 'Added new video successfully.',
        ]);
    }

    public function addTute(Request $request) {

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName(); //making a file name
        $path = $file->storeAs('class_tutes', $fileName, 'public');

        ClassTute::create([
            'tuition_class_id' => $request->classId,
            'tute_path' => $path,
            'tute_name' => $request->tute_name,
        ]);
    }


    public function deleteTute(Request $request) {

        $record = ClassTute::where('id', $request->tuteId)->first();

        ClassTute::where('id', $request->tuteId)->delete();

        if (!$record) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $fileToDelete = $record->tute_path; // e.g., 'class_tutes/1735555922_azurepic.PNG'
        $fullPath = storage_path('app/public/' . $fileToDelete);

        // Check if the file exists and delete it
        if (File::exists($fullPath)) {
            File::delete($fullPath);
            // return response()->json(['success' => 'File deleted successfully']);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
        
    }

    public function deleteClass(Request $request) {

        TuitionClass::where('id', $request->classId)->delete();
    }
}
