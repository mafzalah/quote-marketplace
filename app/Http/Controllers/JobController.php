<?php

namespace App\Http\Controllers;

use App\Models\CustomerJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        $jobs = CustomerJob::where('customer_id', Auth::id())->latest()->get();
        return view('customer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('customer.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup' => 'required|string|max:255',
            'dropoff' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        CustomerJob::create([
            'customer_id' => Auth::id(),
            'pickup' => $request->pickup,
            'dropoff' => $request->dropoff,
            'vehicle_type' => $request->vehicle_type,
            'notes' => $request->notes,
            'status' => 'OPEN',
        ]);

        return redirect()->route('customer.jobs.index')->with('success', 'Job created successfully.');
    }

    public function openJobs()
    {
        $jobs = CustomerJob::where('status', 'OPEN')
                    ->latest()
                    ->get();

        return view('provider.jobs', compact('jobs'));
    }
}
