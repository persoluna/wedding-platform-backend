<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user->isClient()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $client = $user->client()->with(['inquiries.vendor', 'inquiries.agency', 'bookings.vendor', 'bookings.agency'])->first();

        if (!$client) {
            // Failsafe in case client record is missing
            $client = $user->client()->create();
        }

        return view('client.dashboard', compact('client', 'user'));
    }
}
