<?php

namespace App\Http\Controllers;

use App\Models\Slip;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function index() {
        return Inertia::render('Payment');
    }

    public function store(Request $request) {
        
        $form1_data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'paid_classes' => 'required|array',
            'slip' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $classes_paid = implode(',', $form1_data['paid_classes']);

        $slip = $request->file('slip');
        $fileName = time() . '_' . $slip->getClientOriginalName(); //making a file name
        // $slip->move(public_path('mounthly_slips'), $fileName);
        $path = $slip->storeAs('mounthly_slips', $fileName, 'public');

        Slip::create([
            'note' => $request->name,
            'slip_url' => $path,
            'paid_classes' => $classes_paid,
            'st_email' => $request->email,
        ]);

        // Process data for form 1
        // return redirect()->back()->with('errorMessage', 'Form 1 submitted successfully!');
        return back()->with([
            'successMsg' => 'Payment details submitted successfully.',
        ]);
    }
}
