<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Vendor;
use App\Models\Agency;

class InquiryController extends Controller
{
    public function store(Request $request, $type, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'event_date' => 'nullable|date',
            'message' => 'required|string',
        ]);

        $inquiry = new Inquiry();
        $inquiry->name = $validated['name'];
        $inquiry->email = $validated['email'];
        $inquiry->event_date = $validated['event_date'];
        $inquiry->message = $validated['message'];
        $inquiry->status = 'new';
        $inquiry->source = 'Website Profile';

        // Check if user is logged in natively
        if (auth()->check() && auth()->user()->isClient()) {
            if ($client = auth()->user()->client) {
                $inquiry->client_id = $client->id;
            } else {
                $client = auth()->user()->client()->create();
                $inquiry->client_id = $client->id;
            }
        }

        if ($type === 'vendor') {
            $inquiry->vendor_id = $id;
        } else if ($type === 'agency') {
            $inquiry->agency_id = $id;
        }

        $inquiry->save();

        return back()->with('success', 'Your inquiry has been successfully sent!');
    }
}
