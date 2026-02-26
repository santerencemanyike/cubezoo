<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessVisitSubmission;
use App\Models\Visit;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Admin sees all visits, staff sees only their own
        $query = $user->isAdmin ? Visit::query() : Visit::where('user_id', $user->id);
        
        // Filter by status
        if (request('status')) {
            $query->where('status', request('status'));
        }
        
        // Filter by user (admins only)
        if (request('user_id') && $user->isAdmin) {
            $query->where('user_id', request('user_id'));
        }
        
        // Filter by date range
        if (request('date_from')) {
            $query->whereDate('visited_at', '>=', request('date_from'));
        }
        if (request('date_to')) {
            $query->whereDate('visited_at', '<=', request('date_to'));
        }
        
        $visits = $query->with(['site', 'user'])
            ->orderBy('visited_at', 'desc')
            ->paginate(15);

        return view('visits.index', compact('visits'));
    }

    public function create(Site $site = null)
    {
        $sites = Site::all();
        return view('visits.create', compact('sites', 'site'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'visited_at' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $visit = Visit::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'draft',
        ]));

        return redirect()->route('admin.visits.show', $visit)
            ->with('success', 'Visit created successfully');
    }

    public function show(Visit $visit)
    {
        $this->authorize('view', $visit);
        return view('visits.show', compact('visit'));
    }

    public function edit(Visit $visit)
    {
        $this->authorize('update', $visit);
        $sites = Site::all();
        return view('visits.edit', compact('visit', 'sites'));
    }

    public function update(Request $request, Visit $visit)
    {
        $this->authorize('update', $visit);

        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'visited_at' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $visit->update($validated);

        return redirect()->route('admin.visits.show', $visit)
            ->with('success', 'Visit updated successfully');
    }

    public function destroy(Visit $visit)
    {
        $this->authorize('delete', $visit);

        $visit->delete();

        return redirect()->route('admin.visits.index')
            ->with('success', 'Visit deleted successfully');
    }

    public function submit(Visit $visit)
    {
        $this->authorize('update', $visit);

        if ($visit->status !== 'draft') {
            return redirect()->route('admin.visits.show', $visit)
                ->with('error', 'Only draft visits can be submitted');
        }

        $visit->update(['status' => 'submitted']);

        // Dispatch the job to process the visit asynchronously
        ProcessVisitSubmission::dispatch($visit);

        return redirect()->route('admin.visits.show', $visit)
            ->with('success', 'Visit submitted successfully and queued for processing');
    }
}