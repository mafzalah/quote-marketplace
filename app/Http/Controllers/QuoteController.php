<?php

namespace App\Http\Controllers;

use App\Models\CustomerJob;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class QuoteController extends Controller
{
    public function jobQuotes($id)
    {

        $job = CustomerJob::with('quotes.provider')->whereId($id)->first();
        // Ensure the logged-in customer owns this job
        if ($job->customer_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.jobs.quotes', compact('job'));
    }

    // Accept a quote (Customer)
    public function accept(Quote $quote)
    {
        $job = $quote->job;

        // Ensure the logged-in customer owns this job
        if ($job->customer_id !== Auth::id()) {
            abort(403);
        }

        // Only allow accepting if job is still OPEN
        if ($job->status !== 'OPEN') {
            return redirect()->back()->with('error', 'Cannot accept quote. Job already accepted.');
        }

        // Start transaction to avoid inconsistencies
        \DB::transaction(function () use ($quote, $job) {
            // Accept the selected quote
            $quote->status = 'ACCEPTED';
            $quote->save();

            // Reject all other quotes for this job
            Quote::where('job_id', $job->id)
                ->where('id', '!=', $quote->id)
                ->update(['status' => 'REJECTED']);

            // Update job status
            $job->status = 'ACCEPTED';
            $job->save();
        });

        return redirect()->back()->with('success', 'Quote accepted successfully.');
    }

    public function create($id)
    {
        $job = CustomerJob::findOrFail($id);

         // Ensure the job is still OPEN
         if ($job->status !== 'OPEN') {
            return redirect()->back()->with('error', 'Cannot apply. Job is no longer open.');
        }

         // Ensure the provider hasn't already applied to this job
         $existingQuote = Quote::where('job_id', $id)
                                ->where('provider_id', Auth::id())
                                ->first();
         if ($existingQuote) {
             return redirect()->back()->with('error', 'You have already applied to this job.');
         }

        return view('provider.apply', compact('job'));
    }

    public function myQuotes()
    {
        $quotes = Quote::where('provider_id', Auth::id())->with('job')->latest()->get();
        return view('provider.quotes', compact('quotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:customer_jobs,id',
            'price' => 'required|numeric|min:0',
            'message' => 'required|string',
        ]);

        $provider = Auth::user();

        // Check if provider already applied for this job
        $existing = Quote::where('job_id', $request->job_id)
                        ->where('provider_id', $provider->id)
                        ->first();

        if ($existing) {
            return redirect()->route('provider.jobs.open')->with('error', 'You have already applied for this job.');
        }

        // Create quote
        Quote::create([
            'job_id' => $request->job_id,
            'provider_id' => $provider->id,
            'price' => $request->price,
            'message' => $request->message,
            'status' => 'PENDING',
        ]);

        return redirect()->route('provider.jobs.open')->with('success', 'Quote submitted successfully.');

    }

}
